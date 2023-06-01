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
                        <tr v-for="coin in promotedCoins" v-bind:key="coin.id">
                            <td><i class="fa-solid fa-gem gem-bg fa-2x"></i></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <div class="align-self-center">
                                        <img :src='coin.image' width="50" alt="">
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

                        <tr>
                            <td><i class="fa-solid fa-gem gem-bg fa-2x"></i></td>
                            <td>Your coin here</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>
                                <button class="btn bg-success-gradient promote-btn">
                                    <i class="fa-solid fa-gem"></i>
                                    Promote
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-center">
                <button class="btn advertise-btn bg-warning-gradient m-auto">
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
                promotedCoins: [],
            }
        },
        created () {
            axios.get(process.env.MIX_API_URL + '/coins/promoted')
                .then(response => {
                    this.promotedCoins = response.data.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        methods: {
            toggleVote(id) {
                axios.post(process.env.MIX_API_URL + '/coins/vote/' + id)
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
