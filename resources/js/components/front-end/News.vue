<template>
    <div>
       <div>
            <frontend-header></frontend-header>
            <div class="container py-5">
                <news-banner></news-banner>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-lg-4"  v-for="(n, index) in news" v-bind:key="index">
                        <news-card></news-card>
                    </div>
                </div>
                <div>
                    <div class="pagination d-flex justify-content-between mb-5">
                        <div class="text text-light">
                            Showing 1 to 10 of 9370 rows
                            <!-- add drop down -->
                            <select class="">
                                <option>10</option>
                                <option>25</option>
                                <option>50</option>
                                <option>100</option>
                            </select>
                            rows per page
                        </div>
                        <div class="link">
                            <a href="#" class="btn btn-dark border border-light">
                                <i class="fa-solid fa-chevron-left"></i>
                            </a>
                            <a href="#" class="btn btn-dark border border-light">
                                1
                            </a>
                            <a href="#" class="btn btn-dark border border-light">
                                2
                            </a>
                            <a href="#" class="btn btn-dark border border-light">
                                3
                            </a>
                            <a href="#" class="btn btn-dark border border-light">
                                ...
                            </a>
                            <a href="#" class="btn btn-dark border border-light">
                                100
                            </a>
                            <a href="#" class="btn btn-dark border border-light">
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                        </div>
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
import NewsBanner from './news/NewsBanner.vue'
import NewsCard from './news/NewsCard.vue'

export default {
    name: "ContactUs",
    data() {
        return {
            news: [
                {
                    title: 'Boots on the Ground, Inclusive Thought Provoking Ideas',
                    image: 'https://s2.coinmarketcap.com/static/cloud/img/CMC_Headlines.png?_=948d22e',
                    description: 'Empower communities and energize engaging ideas; scale and impact do-gooders while disruptring industries. Venture philanthropy benefits corporations and people by moving the needle.'
                },
                {
                    title: 'Boots on the Ground, Inclusive Thought Provoking Ideas',
                    image: 'https://s2.coinmarketcap.com/static/cloud/img/CMC_Headlines.png?_=948d22e',
                    description: 'Empower communities and energize engaging ideas; scale and impact do-gooders while disruptring industries. Venture philanthropy benefits corporations and people by moving the needle.'
                },
                {
                    title: 'Boots on the Ground, Inclusive Thought Provoking Ideas',
                    image: 'https://s2.coinmarketcap.com/static/cloud/img/CMC_Headlines.png?_=948d22e',
                    description: 'Empower communities and energize engaging ideas; scale and impact do-gooders while disruptring industries. Venture philanthropy benefits corporations and people by moving the needle.'
                },
                {
                    title: 'Boots on the Ground, Inclusive Thought Provoking Ideas',
                    image: 'https://s2.coinmarketcap.com/static/cloud/img/CMC_Headlines.png?_=948d22e',
                    description: 'Empower communities and energize engaging ideas; scale and impact do-gooders while disruptring industries. Venture philanthropy benefits corporations and people by moving the needle.'
                },
                {
                    title: 'Boots on the Ground, Inclusive Thought Provoking Ideas',
                    image: 'https://s2.coinmarketcap.com/static/cloud/img/CMC_Headlines.png?_=948d22e',
                    description: 'Empower communities and energize engaging ideas; scale and impact do-gooders while disruptring industries. Venture philanthropy benefits corporations and people by moving the needle.'
                },
                {
                    title: 'Boots on the Ground, Inclusive Thought Provoking Ideas',
                    image: 'https://s2.coinmarketcap.com/static/cloud/img/CMC_Headlines.png?_=948d22e',
                    description: 'Empower communities and energize engaging ideas; scale and impact do-gooders while disruptring industries. Venture philanthropy benefits corporations and people by moving the needle.'
                },
            ]
        }
    },
    components: {
    FrontendHeader,
    FrontendFooter,
    NewsBanner,
    NewsCard
},
    methods: {
    }
}
</script>