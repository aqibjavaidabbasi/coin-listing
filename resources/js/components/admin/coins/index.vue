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
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="coin in coins" :key="coin.id" :id="'coinRow_' + coin.id">
                                <td> {{ coin.id }} </td>
                                <td>
                                    <img :src="getImageUrl(coin.image)" v-if="coin.image" class="responsive" alt="image">
                                    <img :src="getImageUrlPlaceholder()" v-else class="responsive" alt="image">
                                </td>

                                <td>
                                    <label class="switch">
                                        <input type="checkbox" v-model="coin.is_active" @change="updateCoin(coin)">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td> {{ coin.votes }} </td>
                                <td class="text-center">
                                    <div v-if="coin.listing_status === 'listed'"
                                        class="badge badge-pill badge-outline-success">{{ coin.listing_status }}</div>
                                    <div v-else class="badge badge-pill badge-outline-info">{{ coin.listing_status }}</div>
                                <td> {{ coin.network_chain }} </td>
                                <td> {{ coin.contract_address }} </td>
                                <td>
                                    <li class="nav-item dropdown list-style">
                                        <a class="nav-link" id="profileDropdown" href="#" data-bs-toggle="dropdown">
                                            <div class="navbar-profile action-view">
                                                <p class="mb-0 d-none d-sm-block navbar-profile-name text-white">Action</p>
                                                <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list dropdown-action"
                                            aria-labelledby="profileDropdown">

                                            <router-link :to="'/admin/coin/edit/' + coin.id" class="list-style">
                                                <p class="p-1 mb-0 text-center list-style">Edit</p>
                                            </router-link>
                                            <div class="dropdown-divider"></div>
                                            <p class="p-1 mb-0 text-center" @click.prevent="deleteCoin(coin.id)">Delete</p>
                                            <div class="dropdown-divider"></div>

                                        </div>
                                    </li>

                                </td>
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
            axios.post(process.env.MIX_API_URL + '/update/' + coin.id, {
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
        },
        deleteCoin(coinId) {
            if (!confirm('Are you sure you want to delete this post?' + coinId)) {
                return;
            }
            axios.post(process.env.MIX_API_URL + '/coin-delete/' + coinId, {
                "_method": 'delete',
            })
                .then(res => {
                    if (res.data.success == true) {
                        // Remove the table row
                        const tableRow = document.getElementById('coinRow_' + coinId);
                        if (tableRow) {
                            tableRow.remove();
                        }

                        // Display success message
                        this.$swal({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Coin deleted successfully!',
                            target: '#custom-target',
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true,
                            toast: true,
                            background: "linear-gradient(to bottom right, #1ea38f 0%, #5cf9e2 100%)",
                        });
                    } else {
                        this.$swal({
                            position: 'top-end',
                            icon: 'error',
                            title: 'An error occurred. Please try again later.',
                            target: '#custom-target',
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true,
                            toast: true,
                            color: '#dedefd',
                            background: "linear-gradient(to bottom right, #b51b35 0%, #fd4a68 100%)",
                        });
                    }
                })
                .catch(err => {
                    this.$swal({
                        position: 'top-end',
                        icon: 'error',
                        title: 'An error occurred. Please try again later.',
                        target: '#custom-target',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                        toast: true,
                        color: '#dedefd',
                        background: "linear-gradient(to bottom right, #b51b35 0%, #fd4a68 100%)",
                    });
                })
        },
        getImageUrl(imagePath) {
            const baseUrl = process.env.MIX_APP_URL;

            return  imagePath;
        },
        getImageUrlPlaceholder(imagePath) {
            const baseUrl = process.env.MIX_APP_URL;
            console.log(baseUrl);
            return baseUrl + '/storage/placeholder.jpg';
        }
    }
}
</script>