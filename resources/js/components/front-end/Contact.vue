<template>
    <div>
       <div>
            <frontend-header></frontend-header>
            <div class="container">
                <div class="card my-4 bg-dark rounded">
                    <div class="card-header text-center text-light">
                        <h2 class="h1-responsive font-weight-bold text-center my-4">Contact Us</h2>
                    </div>
                    <div class="card-body text-light">
                       <form class="my-form p-md-5 m-auto">
                            <ul class="ps-0">
                                
                                <li>
                                    <div class="grid grid-2">
                                        <input type="text" v-model="name" placeholder="Name" required>
                                        <input type="text" v-model="surname" placeholder="Surname" required>
                                    </div>
                                </li>
                                <li>
                                    <div class="grid grid-2">
                                        <input type="email" v-model="email" placeholder="Email" required>
                                        <input type="tel" v-model="phone" placeholder="Phone">
                                    </div>
                                </li>
                                <li>
                                    <textarea v-model="message" placeholder="Message"></textarea>
                                </li>
                                <li>
                                    <input type="checkbox" v-model="terms" @click="enableBtn()" id="terms">
                                    <label for="terms">I have read and agreed with <a href="">the terms and
                                            conditions.</a></label>
                                </li>
                                <li>
                                    <div class="grid grid-3">
                                        <div class="required-msg">REQUIRED FIELDS</div>
                                        <button class="btn-grid" type="button" @click="submitForm()" :disabled="!terms">
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
                    </div>
                </div>
            </div>
            <frontend-footer></frontend-footer>
        </div>
    </div>
</template>

<script>
import FrontendHeader from './partials/header.vue'
import FrontendFooter from './partials/footer.vue'

export default {
    name: "ContactUs",
    data() {
        return {
            name: '',
            surname: '',
            email: '',
            phone: '',
            message: '',
            terms: false
        }
    },
    components: {
        FrontendHeader,
        FrontendFooter
    },
    methods: {
        enableBtn() {
            this.terms = !this.terms;
        },
        resetForm() {
            this.name = '';
            this.surname = '';
            this.email = '';
            this.phone = '';
            this.message = '';
            this.terms = false;
        },
        submitForm() {
            console.log(this.name);
            console.log(this.surname);
            console.log(this.email);
            console.log(this.phone);
            console.log(this.message);
            console.log(this.terms);
            this.resetForm();
        }
    }
}
</script>