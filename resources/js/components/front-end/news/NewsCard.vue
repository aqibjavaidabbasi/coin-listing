<template>
    <div>
        <div class="card bg-dark-500 rounded mb-3">
            <div class="card-header p-0">
                <img :src="getImageUrl(news.image)" alt="" class="img-fluid rounded-xt">
            </div>
            <div class="card-body text-light">
                <div class="">
                    <h4 class="card-title text-muted">{{ news.title }}</h4>
                    <!-- <p class="card-text text-dark-200" v-limit-content="news.content" v-html="news.content"></p> -->
                    <p class="card-text text-dark-200" v-html="limitedText(news.content, 200)"></p>
                    <router-link class="nav-link text-info text-decoration-none" :to="'/news-detail/' + news.slug">Read
                        more...</router-link>
                </div>
            </div>
        </div>
    </div>
</template>
  
<script>
export default {
    name: "NewsCard",
    props: {
        news: {
            type: Object,
            required: true,
        },
    },

    methods: {
        limitedText(text, limit) {
            if (text.length <= limit) {
                return text;
            } else {
                return text.substring(0, limit) + "...";
            }
        },
        directives: {
            'limit-content': {
                inserted: function (el, binding) {
                    el.textContent = binding.value.substring(0, binding.arg) + '...';
                }
            }
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
    },
};
</script>
  