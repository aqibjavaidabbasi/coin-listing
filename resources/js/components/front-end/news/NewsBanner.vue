<template>
    <div>
      <div class="card bg-dark-500 rounded">
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              
  
              <img :src="getImageUrl(latestNews.image)" alt="" class="img-fluid rounded" />
            </div>
            <div class="col-md-6">
              <div class="card-body text-light">
                <div class="py-5">
                  <h4 class="card-title">{{ latestNews.title }}</h4>
                  <p class="card-text text-dark-200" v-html="limitedText(latestNews.content, 200)"></p>
                  <router-link class="nav-link text-info text-decoration-none" :to="'/news-detail/' + latestNews.slug">
                    Read more...
                  </router-link>
                </div>
                <hr />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'NewsBanner',
    props: {
      latestNews: {
        type: Object,
        required: true,
      },
    },
    methods: {
      limitedText(text, limit) {
        if (text.length <= limit) {
          return text;
        } else {
          return text.substring(0, limit) + '...';
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
      },
    },
  };
  </script>
  