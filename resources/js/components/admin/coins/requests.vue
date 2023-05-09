<template>
    <Layout>
        <div class="page-header">
            <h3 class="page-title"> Coins </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <router-link to="/admin/coins">List</router-link>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Requests</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Icon </th>
                                <th> Coin Status </th>
                                <th> Name </th>
                                <th> Symbol </th>
                                <th> Votes </th>
                                <th> Listing Status </th>
                                <th> Network Chain </th>
                                <th> Contract Address </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="coin in coins" :key="coin.id">
                                <td> {{ coin.id }} </td>
                                <td> <img :src="coin.image" alt="coin icon" width="50" height="50"> </td>
                                <td> 
                                    <div v-if="coin.is_active === 1" class="badge badge-pill badge-success">Active</div>
                                    <div v-else class="badge badge-pill badge-danger">Inactive</div>    
                                </td>
                                <td> {{ coin.name }} </td>
                                <td> {{ coin.symbol }} </td>
                                <td> {{ coin.votes }} </td>
                                <td class="text-center"> 
                                    <div v-if="coin.listing_status === 'active'" class="badge badge-pill badge-success">{{ coin.listing_status }}</div>
                                    <div v-else class="badge badge-pill badge-danger">{{ coin.listing_status }}</div>
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
export default {
    name: 'Dashboard',
    data() {
        return {
            coins: []
        }
    },
    components: {
        Layout
    },
    created() {
        this.getCoins();
    },
    methods: {
        getCoins() {
            var context = this;
            axios.get('/api/coins/requests')
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