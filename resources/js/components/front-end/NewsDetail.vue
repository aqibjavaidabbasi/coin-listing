<template>
    <div>
        <div>
            <frontend-header></frontend-header>
            <div class="container py-5">
                <div class="row">
                    <div class="col-md-9 mb-5">
                        <div class="card bg-dark-500 rounded">
                            <div class="card-header text-muted text-center">
                                <h1>{{ blog.title }}</h1>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="text-light">
                                            <div v-html="blog.content"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-5">
                        <div class="article-card bg-dark-500 py-3 px-2 rounded">
                            <h3 class="text-dark-200">Featured Articles</h3>
                            <div class="article-widget mb-2" v-for="(blog, index) in latestNews" :key="index">
                                <div class="row">
                                    <div class="col-md-4 pt-2">

                                        <img :src="getImageUrl(blog.image)" v-if="blog.image"
                                            style="width: 100% !important;border-radius: 0;" alt="image" class="img-fluid">

                                        <img :src="getImageUrlPlaceholder()" v-else
                                            style="width: 100% !important;border-radius: 0;" alt="image" class="img-fluid">

                                    </div>
                                    <div class="col-md-8 py-2">
                                        <h5 class="text-info" v-html="limitedText(blog.title, 10)"></h5>
                                        <p class="text-muted"   v-html="limitedTextContent(blog.content, 100)" ></p>
                                        <router-link class="nav-link text-info text-decoration-none"
                                            :to="'/news-detail/' + blog.slug">Read
                                            more...</router-link>
                                        <hr class="bg-light">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <p class="text-muted text-center">
                                    <b>Disclaimer:</b> {{ disclaimer }}
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <frontend-footer></frontend-footer>
        </div>
    </div>
</template>
<style>
p.lead{
    font-size: 0.9rem !important;
}
img {
    width: 100%;
}
</style>
<script>
import FrontendHeader from './partials/header.vue'
import FrontendFooter from './partials/footer.vue'

export default {
    name: "ContactUs",
    data() {
        return {
            dropifyOptions: {
                accept: 'image/*',
            },
            latestNews: [],
            blog: {
                title: '', // Initialize with empty values
                slug: '',
                content: '',
                is_active: 1,
                is_featured: '',

            },
        }
    },
    created() {
        this.getBlog();
        this.LatestFeaturedBlogs();

    },
    components: {
        FrontendHeader,
        FrontendFooter,
    },
    methods: {
        limitedText(text, limit) {
            if (text.length <= limit) {
                return text;
            } else {
                return text.substring(0, limit) + "...";
            }
        },
        limitedTextContent(text, limit) {
            if (text.length <= limit) {
                return text;
            } else {
                return text.substring(0, limit) + "...";
            }
        },
        getBlog() {
            const slug = this.$route.params.slug;

            axios.get(`/api/blog/` + slug)
                .then(res => {
                    if (res.data.success) {
                        this.blog = res.data.data; // Store the news array
                    } else {
                        // Handle error
                    }
                })
                .catch(err => {
                    // Handle error
                });
        },
        LatestFeaturedBlogs() {
            axios.get(`/api/latest-featured-blogs`)
                .then(res => {
                    if (res.data.success) {
                        this.latestNews = res.data.data; // Store the news array
                    } else {
                        // Handle error
                    }
                })
                .catch(err => {
                    // Handle error
                });
        },

        getImageUrl(imagePath) {
            const baseUrl = process.env.MIX_APP_URL;
            return baseUrl + '/storage/blog/' + imagePath;
        },
        getImageUrlPlaceholder(imagePath) {
            const baseUrl = process.env.MIX_APP_URL;
            console.log(baseUrl);
            return baseUrl + '/storage/placeholder.jpg';
        }
    }
}
</script>