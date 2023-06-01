<template>
    <div>
        <Header></Header>
         <div class="container">
                <div class="card my-4 bg-dark rounded">
                    <div class="card-header text-center text-light">
                        <h2 class="h1-responsive font-weight-bold text-center my-4">Coin Listing Form</h2>
                    </div>
                    <div class="card-body text-light">
                        <ValidationObserver v-slot="{ handleSubmit }" ref="observer">
                            <form class="my-form p-md-5 m-auto">
                                <ul class="ps-0">
                                    <li class="row justify-content-center p-3">
                                        <div class="col-md-3 p-0 m-0 border-dark text-center">
                                            <validation-provider name="Coin Image" rules="" v-slot="{ errors }">
                                                <label class="btn btn-dark bg-dark-700 w-100" @input="pickFile">
                                                    <div class="py-1 border border-bottom border-dark"> <i class="fas fa-file-upload"></i> Coin Image <span class="text-danger">*</span> </div>
                                                    <input 
                                                        type="file"
                                                        accept="image/*"
                                                        ref="fileInput"
                                                        class="imageInput"
                                                        required>
                                                    <div
                                                        class="imagePreviewWrapper mt-0 m-auto"
                                                        :style="{ 'background-image': `url(${previewImage})` }"
                                                    >
                                                    </div>
                                                </label>
                                                <span class="text-sm text-danger">{{ errors[0] }}</span>
                                            </validation-provider>
                                                
                                        </div>
                                    </li>
                                    <li>
                                        <div class="grid grid-2">
                                            <div>
                                                <validation-provider name="Coin Name" rules="required" v-slot="{ errors }">
                                                    <span class="text-muted">Coin Name</span>
                                                    <input type="text" v-model="coin.name" placeholder="Bitcoin etc." required>
                                                    <span class="text-sm text-danger">{{ errors[0] }}</span>
                                                </validation-provider>  
                                            </div>
                                            <div>
                                                <validation-provider name="Coin Symbol" rules="required" v-slot="{ errors }">
                                                    <span class="text-muted">Coin Symbol</span>
                                                    <input type="text" v-model="coin.symbol" placeholder="BTC" required>
                                                    <span class="text-sm text-danger">{{ errors[0] }}</span>
                                                </validation-provider>
                                            </div>
                                            
                                        </div>
                                    </li>
                                    <li>
                                        <div class="grid grid-2">
                                            <div>
                                                <validation-provider name="Coin Type" rules="required" v-slot="{ errors }">
                                                    <span class="text-muted">Network Chain</span>
                                                    <select name="metwork_chain" class="form-control text-light" v-model="coin.network_chain" id="">
                                                        <option value="">Select Network Chain</option>
                                                        <option value="chain 1">Chain 1</option>
                                                        <option value="chain 2">Chain 2</option>
                                                    </select>
                                                    <span class="text-sm text-danger">{{ errors[0] }}</span>
                                                </validation-provider>
                                            </div>
                                            <div>
                                                <validation-provider name="Listing Status" rules="required" v-slot="{ errors }">
                                                    <span class="text-muted">Listing Status</span>
                                                    <select name="listing_status" class="form-control text-light" v-model="coin.listing_status" id="">
                                                        <option value="">Listing Status</option>
                                                        <option value="listed">Listed</option>
                                                        <option value="presale">Presale</option>
                                                    </select>
                                                    <span class="text-sm text-danger">{{ errors[0] }}</span>
                                                </validation-provider>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="grid grid-2">
                                            <div>
                                                <validation-provider name="Listing Date" rules="required" v-slot="{ errors }">
                                                    <span class="text-muted">Listing Date</span>
                                                    <input type="date" v-model="coin.launch_date" placeholder="Listing Date" required>
                                                    <span class="text-sm text-danger">{{ errors[0] }}</span>
                                                </validation-provider>
                                            </div>
                                            <div>
                                                <validation-provider name="Contract Address" rules="required" v-slot="{ errors }">
                                                    <span class="text-muted">Contract Address</span>
                                                    <input type="text" v-model="coin.contract_address" placeholder="Contract Address" required>
                                                    <span class="text-sm text-danger">{{ errors[0] }}</span>
                                                </validation-provider>
                                            </div>
                                            
                                        </div>
                                    </li>
                                    <li>
                                        <div class="grid grid-1">
                                            <div>
                                                <span class="text-mute">Coin Description</span>
                                                <textarea name="coin_description" placeholder="Write coin description here" id="" rows="10" v-model="coin.coin_description"></textarea>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <span class="text-muted">Website Link</span>
                                                <input type="url" v-model="coin.website_link" placeholder="https://www.google.com">
                                            </div>
                                            <div class="col-md-4">
                                                <span class="text-muted">Telegram Link</span>
                                                <input type="url" v-model="coin.telegram_link" placeholder="https://t.me/name">
                                            </div>
                                            <div class="col-md-4">
                                                <span class="text-muted">Chart Link</span>
                                                <input type="url" v-model="coin.chart_link" placeholder="https://poocoin.com/tokens/">
                                            </div>                                        
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <span class="text-muted">Reddit Link</span>
                                                <input type="url" v-model="coin.reddit_link" placeholder="https://reddit.com/r/name" >
                                            </div>
                                            <div class="col-md-4">
                                                <span class="text-muted">Twitter Link</span>
                                                <input type="url" v-model="coin.twitter_link" placeholder="https://twitter.com/name">
                                            </div>
                                            <div class="col-md-4">
                                                <span class="text-muted">Discord Link</span>
                                                <input type="url" v-model="coin.discord_link" placeholder="https://discord.gg/name">
                                            </div>                                        
                                        </div>
                                    </li>
                                    <li>
                                        <input type="checkbox" v-model="terms" @click="enableBtn()" id="terms">
                                        <label for="terms">I have read and agreed with <a href="">the terms and
                                                conditions.</a></label>
                                    </li>
                                    <li>
                                        <div class="grid grid-3">
                                            <div class="required-msg">REQUIRED FIELDS</div>
                                            <button class="btn-grid" type="button" @click="handleSubmit(submitForm)" :disabled="!terms">
                                                <span class="back">
                                                    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/162656/email-icon.svg"
                                                        alt="">
                                                </span>
                                                <span class="front">SUBMIT</span>
                                            </button>
                                            <button class="btn-grid" type="button" @click="resetForm()"  :disabled="!terms">
                                                <span class="back">
                                                    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/162656/eraser-icon.svg"
                                                        alt="">
                                                </span>
                                                <span class="front">RESET</span>
                                            </button>
                                        </div>
                                    </li>
                                </ul>
                            </form>
                        </ValidationObserver>
                    </div>
                </div>
            </div>
        <Footer></Footer>
    </div>
</template>

<style scoped lang="scss">
.imagePreviewWrapper {
    width: 150px;
    height: 150px;
    cursor: pointer;
    border-radius: 50%;
    border: var(--border-default);
    background-size: cover;
    background-position: center center;
    position: relative;
    top: -15px;
}

.imageInput {
    width: 0px;
    height: 0px;
    overflow: hidden;
    padding: 0px; 
    margin: 0px; 
    border:none;
}
</style>

<script>
import Header from '../partials/header.vue';
import Footer from '../partials/footer.vue';
export default {
    name: "ListCoin",
    data() {
        return {
            coin : {
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
            },
            terms: false,
            previewImage: 'https://www.lyon-ortho-clinic.com/files/cto_layout/img/placeholder/book.jpg',
        }
    },
    components: { Header, Footer },
    computed: {
        apiUrl() {
            return process.env.VUE_APP_API_URL
        }
    },
    methods: {
        pickFile () {
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
        enableBtn() {
            this.terms = !this.terms
            if (this.terms) {
                this.terms = true
            } else {
                this.terms = false
            }
        },
        submitForm() {
            console.log(this.$refs.observer)
            this.$refs.observer.validate().then(success => {
                if (success) {
                    let formData = new FormData()
                    for (let key in this.coin) {
                        formData.append(key, this.coin[key])
                    }
                    formData.append('image', this.coin.image)
                    axios.post(process.env.MIX_API_URL + '/list-coin', formData)
                    .then(res => {
                        if (res.data.success == true) {
                            // empty input fields
                            this.coin = {
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
                            }
                            this.$refs.observer.reset();
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
            })
        },
    },
}
</script>