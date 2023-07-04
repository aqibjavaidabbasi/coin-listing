<template>
    <div class="container mt-5 mb-5">
        <div class="card bg-dark rounded">
            <div class="card-header text-center text-light display-4">
                <h1>Promoted Coins <i class="fa-solid fa-gem gem-bg"></i> </h1>
            </div>
            <div class="card-body py-0">
                <table class="table table-dark table-striped table-borderless coins-table mb-0">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Name</th>
                            <th>Total Holders</th>
                            <th>Market Cap</th>
                            <th>Price</th>
                            <th>Age</th>
                            <th>Votes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="coin in promotedCoins" :key="coin.id">
                            <td><i class="fa-solid fa-gem gem-bg fa-2x"></i></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <div class="align-self-center">
                                        <img :src="coin.image" width="50" alt="">
                                    </div>
                                    <div class="text-start">
                                        <h5 class="mb-0">{{ coin.name }}</h5>
                                        <p class="mb-0 text-muted">{{ coin.symbol }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>{{ coin.coin_detail ? coin.coin_detail.total_supply : 'N/A' }}</td>
                            <td>{{ coin.coin_detail ? coin.coin_detail.market_cap : 'N/A' }}</td>
                            <td>{{ coin.coin_detail ? coin.coin_detail.price : 'N/A' }}</td>
                            <td>1 year</td>
                            <td>
                                <button class="btn bg-primary-gradient vote-btn" @click="toggleVote(coin.id)">
                                    <i class="fa-solid fa-thumbs-up"></i>
                                    {{ coin.votes }}
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="pagination d-flex justify-content-between mb-3 pt-4">
                    <div class="text text-light">
                        Showing {{ (currentPage - 1) * rowsPerPage + 1 }} to {{ Math.min(currentPage * rowsPerPage,
                            totalRows)
                        }}
                        of {{ totalRows }} rows
                        <select v-model="rowsPerPage" @change="updateCurrentPage(1)">
                            <option>10</option>
                            <option>25</option>
                            <option>50</option>
                            <option>100</option>
                        </select>
                        rows per page
                    </div>
                    <div class="link">
                        <a href="#" class="btn btn-dark border border-light" @click="previousPage">
                            <i class="fa-solid fa-chevron-left"></i>
                        </a>
                        <a v-for="pageNumber in totalPages" href="#" class="btn btn-dark border border-light"
                            :class="{ active: currentPage === pageNumber }" @click="goToPage(pageNumber)">
                            {{ pageNumber }}
                        </a>
                        <a href="#" class="btn btn-dark border border-light" @click="nextPage">
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
                <button class="btn advertise-btn bg-warning-gradient m-auto mb-3">
                    <i class="fa-solid fa-gem text-dark"></i>
                    Promote your coin to get more votes
                </button>
            </div>


        </div>
    </div>
</template>
  
<script>
export default {
    name: 'PromotedCoins',
    data() {
        return {
            coins: [],
            promotedCoins: [],
            currentPage: 1,
            rowsPerPage: 10,
            totalRows: 0,
            totalPages: 0,
        };
    },
    created() {
        this.fetchPromotedCoins();
    },
    methods: {
        fetchPromotedCoins() {
            axios
                .get(process.env.MIX_API_URL + '/promotedCoin', {
                    params: {
                        per_page: this.rowsPerPage,
                        page: this.currentPage,
                    },
                })
                .then(response => {
                    this.promotedCoins = response.data.data.data;
                    this.currentPage = response.data.current_page;
                    this.rowsPerPage = response.data.per_page;
                    this.totalRows = response.data.total;
                    this.totalPages = response.data.last_page;
                })
                .catch(error => {
                    console.log(error);
                });
        },

        previousPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
                this.fetchPromotedCoins();
            }
        },

        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
                this.fetchPromotedCoins();
            }
        },

        goToPage(page) {
            this.currentPage = page;
            this.fetchPromotedCoins();
        },

        toggleVote(id) {
            axios
                .post(process.env.MIX_API_URL + '/vote/' + id)
                .then(response => {
                    // Find the coin in the coins array based on the id
                    const coin = this.coins.find(coin => coin.id === id);
                    if (coin) {
                        // Increment the votes property of the coin by 1
                        coin.votes += 1;

                    }
                })
                .catch(error => {
                    console.log(error);
                });
        }
    },
};
</script>
  