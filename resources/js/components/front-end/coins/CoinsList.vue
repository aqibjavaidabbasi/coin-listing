<template>
    <div class="container mb-5">
        <div class="card bg-dark rounded-lg">
            <div class="card-header text-center text-light py-4">
                <h1>Top Coins Today</h1>
                <h5>Find the highest voted coins in the past 24 hours</h5>
            </div>
            <div class="card-body">
                <div class="filter mb-3">
                    <button class="btn btn-primary">
                        All Time <i class="fa-solid fa-clock"></i>
                    </button>
                    <button class="btn btn-primary active">
                        Today <i class="fa-solid fa-clock"></i>
                    </button>
                    <button class="btn btn-primary">
                        Premium <i class="fa-solid fa-star"></i>
                    </button>

                    <!-- add search field for table -->
                    <div class="d-inline float-end search-coins">
                        <input type="text" placeholder="Search.." name="search">
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
                        <tr v-for="coin in coins" v-bind:key="coin.id">
                            <td><i class="fa-solid fa-gem gem-bg fa-2x"></i></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <div class="align-self-center">
                                        <img :src="coin.image" width="50" alt="">
                                    </div>
                                    <div class="text-start">
                                        <h5 class="mb-0">{{coin.name}}</h5>
                                        <p class="mb-0 text-muted">{{coin.symbol}}</p>
                                    </div>
                                </div>
                            </td>
                            <td>1,000,000,000</td>
                            <td>$1,000,000,000</td>
                            <td>$1,000,000,000</td>
                            <td>1 year</td>
                            <td>
                                <button class="btn bg-primary-gradient vote-btn" @click="toggleVote(coin.id)">
                                    <i class="fa-solid fa-thumbs-up"></i>
                                    {{coin.votes}}
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="pagination d-flex justify-content-between">
                    <div class="text text-light">
                        Showing 1 to 10 of 9370 rows
                        <!-- add drop down -->
                        <select class="dropdown">
                            <option>10</option>
                            <option>25</option>
                            <option>50</option>
                            <option>100</option>
                        </select>
                          rows per page
                    </div>
                    <div class="link">
                        <a href="#" class="btn btn-dark">
                            <i class="fa-solid fa-chevron-left"></i>
                        </a>
                        <a href="#" class="btn btn-dark active">
                            1
                        </a>
                        <a href="#" class="btn btn-dark">
                            2
                        </a>
                        <a href="#" class="btn btn-dark">
                            3
                        </a>
                        <a href="#" class="btn btn-dark disabled">
                            ...
                        </a>
                        <a href="#" class="btn btn-dark">
                            100
                        </a>
                        <a href="#" class="btn btn-dark">
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
            </div>                
        </div>
    </div>    
</template>

<script>
export default {
    name: 'PromotedCoins',
    data() {
        return {
            coins: []
        }
    },
    created() {
        axios.get(process.env.MIX_APP_URL + '/coins')
            .then(response => {
                this.coins = response.data.data;
            })
            .catch(error => {
                console.log(error);
            });
    },
    methods: {
        toggleVote(id) {
            axios.post(process.env.MIX_APP_URL + '/coins/vote/' + id)
                .then(response => {
                    console.log(response);
                })
                .catch(error => {
                    console.log(error);
                });
        }
    }
}
</script>