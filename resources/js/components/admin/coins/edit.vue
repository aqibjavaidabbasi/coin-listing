<template>
    <Layout>
        <div class="page-header">
            <h3 class="page-title"> Coins </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <router-link to="/admin/coins">List</router-link>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">List Coin</h4>
                        <ValidationObserver v-slot="{ handleSubmit }" ref="observer">
                            <form class="form-sample">
                                <div class="row mb-3">
                                    <div class="col-12 col-md-3">
                                        <!-- <validation-provider name="Coin Image" rules="" v-slot="{ errors }">
                                            <vue-dropify ref="coinIcon" class="bg-transparent" message="Drag and drop a file here or click" v-model="coin.icon" :options="dropifyOptions" @file-selected="onFileSelected" />
                                            <span class="text-sm text-danger">{{ errors[0] }}</span>
                                        </validation-provider> -->
                                        <validation-provider name="Coin Image" rules="" v-slot="{ errors }">
                                            <label class="btn btn-dark bg-dark-700 w-100" @input="pickFile">
                                                <div class="py-1 border border-bottom border-dark"> <i
                                                        class="fas fa-file-upload"></i> Coin Image <span
                                                        class="text-danger">*</span> </div>
                                                <input type="file" accept="image/*" ref="fileInput" class="imageInput"
                                                    required>
                                                <div class="imagePreviewWrapper mt-0 m-auto"
                                                    :style="{ 'background-image': `url(${previewImage})` }">
                                                </div>
                                            </label>
                                            <span class="text-sm text-danger">{{ errors[0] }}</span>
                                        </validation-provider>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-12 col-form-label">Coin Name</label>
                                            <div class="col-12">
                                                <validation-provider name="Coin Name" rules="" v-slot="{ errors }">
                                                    <input type="text" class="form-control" v-model="coin.name"
                                                        placeholder="Bitcoin, Etherium etc" required>
                                                    <span class="text-sm text-danger">{{ errors[0] }}</span>
                                                </validation-provider>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-12 col-form-label">Coin Symbol</label>
                                            <div class="col-12">
                                                <validation-provider name="Coin Symbol" rules="" v-slot="{ errors }">
                                                    <input type="text" class="form-control" v-model="coin.symbol"
                                                        placeholder="BTC, ETH" required>
                                                    <span class="text-sm text-danger">{{ errors[0] }}</span>
                                                </validation-provider>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-12 col-form-label">Network Chain</label>
                                            <!-- <div class="col-12">
                                                <validation-provider name="Network Chain" rules="" v-slot="{ errors }">
                                                    <select class="form-control" v-model="coin.network_chain">
                                                        <option value="chain1">Chain 1</option>
                                                        <option value="chain2">Chain 2</option>
                                                    </select>
                                                    <span class="text-sm text-danger">{{ errors[0] }}</span>
                                                </validation-provider>
                                            </div> -->
                                            <div class="col-12">
                                                <validation-provider name="Network Chain" rules="" v-slot="{ errors }">
                                                    <select class="form-control" v-model="coin.network_chain">
                                                        <option v-for="chain in networkChains" :value="chain.id"
                                                            :key="chain.id">
                                                            {{ getNetworkChainName(chain.id) }}
                                                        </option>
                                                    </select>
                                                    <span class="text-sm text-danger">{{ errors[0] }}</span>
                                                </validation-provider>
                                            </div>


                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-12 col-form-label">Listing Status</label>
                                            <div class="col-12">
                                                <validation-provider name="Listing Status" rules="" v-slot="{ errors }">
                                                    <select class="form-control" v-model="coin.listing_status">
                                                        <option value="listed">Listed</option>
                                                        <option value="presale">Presale</option>
                                                    </select>
                                                    <span class="text-sm text-danger">{{ errors[0] }}</span>
                                                </validation-provider>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-12 col-form-label">Listing Date</label>
                                            <div class="col-12">
                                                <validation-provider name="Listing Date" rules="" v-slot="{ errors }">
                                                    <input class="form-control" type="date" v-model="coin.launch_date"
                                                        placeholder="dd/mm/yyyy" required>
                                                    <span class="text-sm text-danger">{{ errors[0] }}</span>
                                                </validation-provider>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-12 col-form-label">Contract Address</label>
                                            <div class="col-12">
                                                <validation-provider name="Contract Address" rules="" v-slot="{ errors }">
                                                    <input class="form-control" type="text" v-model="coin.contract_address"
                                                        placeholder="0x0000000000000000000000000000000000000000" required>
                                                    <span class="text-sm text-danger">{{ errors[0] }}</span>
                                                </validation-provider>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-form-label">Coin Description</label>
                                            <div class="col-sm-12">
                                                <validation-provider name="Coin Description" rules="" v-slot="{ errors }">
                                                    <textarea name="" class="form-control" v-model="coin.coin_description"
                                                        id="" cols="" rows="10" required></textarea>
                                                    <span class="text-sm text-danger">{{ errors[0] }}</span>
                                                </validation-provider>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-12 col-form-label">Website Link</label>
                                            <div class="col-12">
                                                <input type="url" class="form-control" v-model="coin.website_link"
                                                    placeholder="https://www.google.com">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-12 col-form-label">Telegram Link</label>
                                            <div class="col-12">
                                                <input type="url" class="form-control" v-model="coin.telegram_link"
                                                    placeholder="https://t.me/telegram">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="" class="col-12 col-form-label">Chart Link</label>
                                            <div class="col-12">
                                                <input type="url" class="form-control" v-model="coin.chart_link"
                                                    placeholder="https://www.poocoin.com/tokens/">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="" class="col-12 col-form-label">Reddit Link</label>
                                            <div class="col-12">
                                                <input type="url" class="form-control" v-model="coin.reddit_link"
                                                    placeholder="https://reddit.com/r/name/">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="" class="col-12 col-form-label">Twitter Link</label>
                                            <div class="col-12">
                                                <input type="url" class="form-control" v-model="coin.twitter_link"
                                                    placeholder="https://twitter.com/name/">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="" class="col-12 col-form-label">Discord Link</label>
                                            <div class="col-12">
                                                <input type="url" class="form-control" v-model="coin.discord_link"
                                                    placeholder="https://discord.gg/name/">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-primary float-end"
                                            @click="handleSubmit(UpdateCoin)">Save</button>
                                    </div>
                                </div>
                            </form>
                        </ValidationObserver>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
<style scoped lang="scss"></style>
<script>
import Layout from "../layout";
import VueDropify from 'vue-dropify';

export default {
    name: 'Dashboard',
    data() {
        return {
            coinId: null, // Add a coinId property to store the ID of the coin being edited
            coins: [],
            dropifyOptions: {
                accept: 'image/*',
            },
            coin: {
                image: '',
                name: "",
                symbol: "",
                network_chain: "",
                listing_status: "",
                launch_date: "",
                contract_address: "",
                coin_description: "",
                website_link: "",
                telegram_link: "",
                chart_link: "",
                reddit_link: "",
                twitter_link: "",
                discord_link: "",
                network_chain_name: "",
            },
            previewImage: 'https://www.lyon-ortho-clinic.com/files/cto_layout/img/placeholder/book.jpg',
            selectedNetworkChain: "", // Add this line to define the selectedNetworkChain property
        }

    },
    components: {
        Layout,
        'vue-dropify': VueDropify
    },
    created() {
        this.coinId = this.$route.params.id; // Get the coin ID from the route params
        this.fetchCoinData();
        this.getNetworks();

    },
    methods: {
        getNetworkChainName(chainId) {
            const chain = this.networkChains.find(chain => chain.id === chainId);
            return chain ? chain.name : '';
        },
        pickFile() {
            let input = this.$refs.fileInput
            let file = input.files
            if (file && file[0]) {
                let reader = new FileReader
                reader.onload = e => {
                    this.previewImage = e.target.result
                }
                reader.readAsDataURL(file[0])
                this.$emit('input', file[0])
            }
            this.coin.image = file[0]
        },
        fetchCoinData() {
            axios.get(`/api/coin-edit/${this.coinId}`) // Fetch the coin data using the coin ID
                .then(res => {
                    if (res.data.success) {
                        const coinData = res.data.data;
                        this.coin = { ...coinData }; // Assign the fetched coin data to the 'coin' object
                        this.previewImage = coinData.image;
                    } else {
                        // Handle error
                    }
                })
                .catch(err => {
                    // Handle error
                });
        },
        getNetworks() {
            axios
                .get('/api/networks') // Assuming the endpoint is '/api/networks'
                .then(response => {
                    console.log(response);
                    this.networkChains = response.data.data; // Assign the response data to networks
                })
                .catch(error => {
                    console.log(error);
                });
        },

        UpdateCoin() {
            this.$refs.observer.validate().then(success => {
                const coinId = this.$route.params.id;
                if (success) {
                    let formData = new FormData()
                    for (let key in this.coin) {
                        formData.append(key, this.coin[key])
                    }
                    // formData.append('image', this.coin.image)
                    // formData.append('source', 'admin')
                    console.log(formData);

                    axios.post(process.env.MIX_API_URL + '/update/' + coinId, formData)
                        .then(res => {
                            if (res.data.success == true) {
                                // empty input fields

                                // this.$refs.observer.reset();
                                // remove image
                                this.previewImage = 'https://www.lyon-ortho-clinic.com/files/cto_layout/img/placeholder/book.jpg'
                                this.$swal({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Coin is submitted for listing. Thank you!',
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
                                    title: 'An error occured. Please try again later.',
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
                                title: 'An error occured. Please try again later.',
                                target: '#custom-target',
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                                toast: true,
                                color: '#dedefd',
                                background: "linear-gradient(to bottom right, #b51b35 0%, #fd4a68 100%)",
                            });
                        })
                }
            });
        }
    }
}
</script>