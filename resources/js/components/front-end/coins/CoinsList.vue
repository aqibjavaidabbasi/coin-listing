<template>
    <div class="container mb-5">
        <div class="card bg-dark rounded-lg">
            <div class="card-header text-center text-light py-4">
                <h1>Top Coins Today</h1>
                <h5>Find the highest voted coins in the past 24 hours</h5>
            </div>
            <div class="card-body">
                <div class="filter mb-3">
                    <button class="btn btn-primary">All Time <i class="fa-solid fa-clock"></i></button>
                    <button class="btn btn-primary active">Today <i class="fa-solid fa-clock"></i></button>
                    <button class="btn btn-primary">Premium <i class="fa-solid fa-star"></i></button>

                    <!-- add search field for table -->
                    <div class="d-inline float-end search-coins">
                        <input type="text" placeholder="Search.." name="search" v-model="searchText" @input="searchCoins">

                        <button type="button"><i class="fa fa-search"></i></button>
                    </div>
                </div>
                <table class="table table-dark table-striped table-borderless coins-table float-none">
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

                        <tr v-for="coin in filteredCoins" :key="coin.id">
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
                <div class="pagination d-flex justify-content-between mb-5">
                    <div class="text text-light">
                        Showing {{ (currentPage - 1) * rowsPerPage + 1 }} to {{ Math.min(currentPage * rowsPerPage,
                            totalRows) }} of {{ totalRows }} rows
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
            </div>
        </div>
    </div>
</template>
  
<script>
import axios from 'axios';

export default {
    name: 'PromotedCoins',
    data() {
        return {
            coins: [],
            currentPage: 1,
            rowsPerPage: 10,
            totalRows: 0,
            totalPages: 0,
            searchText: '',


        };
    },
    created() {
        this.fetchCoins();
    },
    computed: {
        filteredCoins() {
            if (this.searchText) {
                const lowerCaseSearchText = this.searchText.toLowerCase();
                return this.coins.filter(coin => {
                    return (
                        coin.name.toLowerCase().includes(lowerCaseSearchText) ||
                        coin.symbol.toLowerCase().includes(lowerCaseSearchText)
                    );
                });
            } else {
                return this.coins;
            }
        },
    },
    methods: {
        searchCoins() {
            this.currentPage = 1; // Reset the current page to 1
            this.fetchCoins(); // Fetch coins with the updated search text
        },
        fetchCoins() {
            // Update the request parameters with pagination details
            const offset = (this.currentPage - 1) * this.rowsPerPage;
            const params = {
                type: 'active',
                limit: this.rowsPerPage,
                offset: offset,
                search: this.searchText,
            };

            // Make the API request with updated parameters
            axios.get(process.env.MIX_API_URL + '/home-coins', { params })
                .then(response => {

                    this.coins = response.data.data.data;

                    this.totalRows = response.data.total;
                    this.totalPages = Math.ceil(this.totalRows / this.rowsPerPage);
                })
                .catch(error => {
                    console.log(error);
                });
        },



        previousPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
                this.fetchCoins();
            }
        },

        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
                this.fetchCoins();
            }
        },

        goToPage(pageNumber) {
            this.currentPage = pageNumber;
            this.fetchCoins();
        },

        updateCurrentPage(page) {
            this.currentPage = page;
            this.fetchCoins();
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
  