<template>
    <Layout>
        <div class="page-header">
            <h3 class="page-title"> Coins </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">List</li>
                </ol>
            </nav>
        </div>
        <filters @filter="filter" :type="'coins'"></filters>
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Coin </th>
                                <th> Coin Status </th>
                                <th> Votes </th>
                                <th> Listing Status </th>
                                <th> Network Chain </th>
                                <th> Contract Address </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="coin in coins" :key="coin.id">
                                <td> {{ coin.id }} </td>
                                <td>
                                    <div class="d-flex">
                                        <img :src="coin.image" style="width:43px!important; height: 43px!important" alt="image" class="img-sm me-3 rounded-circle border">
                                        <div class="media-body">
                                            <h6 class="mb-1 text-light">{{ coin.name }}</h6>
                                            <p class="mb-0 text-muted"> {{ coin.symbol }} </p>
                                        </div>
                                    </div>
                                </td>
                                <td> 
                                    <label class="switch">
                                        <input type="checkbox" v-model="coin.is_active" @change="updateCoin(coin)">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td> {{ coin.votes }} </td>
                                <td class="text-center"> 
                                    <div v-if="coin.listing_status === 'listed'" class="badge badge-pill badge-outline-success">{{ coin.listing_status }}</div>
                                    <div v-else class="badge badge-pill badge-outline-info">{{ coin.listing_status }}</div>
                                <td> {{ coin.network_chain }} </td>
                                <td> {{ coin.contract_address }} </td>
                            </tr>
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from "../layout";
import Filters from "./filters/index";
export default {
    name: 'Dashboard',
    data() {
        return {
            coins: []
        }
    },
    components: {
        Layout,
        Filters
    },
    created() {
        this.getCoins();
    },
    methods: {
        getCoins() {
            var context = this;
            console.log(process.env);
            axios.get(process.env.MIX_API_URL + '/coins' + '?type=all')
                .then(response => {
                    context.coins = response.data.data;
                    console.log(context.coins.data);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        updateCoin(coin) {
            var context = this;
            axios.post(process.env.MIX_API_URL + '/coins/update/' + coin.id, {
                    is_active: coin.is_active,
                })
                .then(response => {
                    this.$swal({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Coin Status Updated',
                        target: '#custom-target',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                        toast: true,
                        background: "linear-gradient(to bottom right, #1ea38f 0%, #5cf9e2 100%)",
                    });
                })
                .catch(error => {
                    this.$swal({
                        position: 'top-end',
                        icon: 'error',
                        title: 'An error occured. Please try again later.',
                        target: '#custom-target',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                        toast: true,
                        color: '#dedefd',
                        background: "linear-gradient(to bottom right, #b51b35 0%, #fd4a68 100%)",
                    });
                    coin.is_active = !coin.is_active;
                });
        },
        filter(filters) {
            var context = this;
            // convert filters obj to query param exclude empty values
            filters = Object.keys(filters)
                .filter(key => filters[key] !== '')
                .map(key => key + '=' + filters[key])
                .join('&');
            axios.get(process.env.MIX_API_URL + '/coins' + '?type=all&' + filters)
                .then(response => {
                    context.coins = response.data.data;
                    console.log(context.coins.data);
                })
                .catch(error => {
                    console.log(error);
                });
        }
    }
}
</script>