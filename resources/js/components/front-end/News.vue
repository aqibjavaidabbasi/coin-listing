<template>
    <div>
      <frontend-header></frontend-header>
      <div class="container py-5">
        <news-banner :latest-news="latestNews"></news-banner>
      </div>
  
      <div class="container">
        <div class="row">
          <div class="col-md-3 col-lg-4" v-for="n in displayedNews" :key="n.id">
            <news-card :news="n"></news-card>
          </div>
        </div>
  
        <div class="pagination d-flex justify-content-between mb-5">
          <div class="text text-light">
            Showing {{ (currentPage - 1) * rowsPerPage + 1 }} to {{ Math.min(currentPage * rowsPerPage, news.length) }} of {{ news.length }} rows
            <select v-model="rowsPerPage" @change="updateCurrentPage(1)">
              <option>10</option>
              <option>25</option>
              <option>50</option>
              <option>100</option>
            </select>
            rows per page
          </div>
          <div class="link">
            <a href="#" class="btn btn-dark border border-light" @click="previousPage">
              <i class="fa-solid fa-chevron-left"></i>
            </a>
            <a v-for="pageNumber in totalPages" href="#" class="btn btn-dark border border-light" :class="{ active: currentPage === pageNumber }" @click="goToPage(pageNumber)">
              {{ pageNumber }}
            </a>
            <a href="#" class="btn btn-dark border border-light" @click="nextPage">
              <i class="fa-solid fa-chevron-right"></i>
            </a>
          </div>
        </div>
      </div>
  
      <frontend-footer></frontend-footer>
    </div>
  </template>
  
  <script>
  import FrontendHeader from './partials/header.vue'
  import FrontendFooter from './partials/footer.vue'
  import NewsBanner from './news/NewsBanner.vue'
  import NewsCard from './news/NewsCard.vue'
  
  export default {
    name: "ContactUs",
    components: {
      FrontendHeader,
      FrontendFooter,
      NewsBanner,
      NewsCard,
    },
    data() {
      return {
        news: [],
        latestNews: [],
        rowsPerPage: 10,
        currentPage: 1,
      };
    },
    computed: {
      totalPages() {
        return Math.ceil(this.news.length / this.rowsPerPage);
      },
      displayedNews() {
        const startIndex = (this.currentPage - 1) * this.rowsPerPage;
        const endIndex = startIndex + this.rowsPerPage;
        return this.news.slice(startIndex, endIndex);
      },
    },
    created() {
      this.getBlogs();
      this.getLatestFeaturedBlog();
    },
    methods: {
      previousPage() {
        if (this.currentPage > 1) {
          this.currentPage--;
        }
      },
      nextPage() {
        if (this.currentPage < this.totalPages) {
          this.currentPage++;
        }
      },
      goToPage(pageNumber) {
        this.currentPage = pageNumber;
      },
      updateCurrentPage(page) {
        this.currentPage = page;
      },
      getBlogs() {
      
        axios
          .get('/api/blogs/get-all-blog')
          .then(response => {
            if (response.data.success) {
              this.news = response.data.data;
            } else {
              console.error('Failed to retrieve blogs:', response.data.error);
            }
          })
          .catch(error => {
            console.error('Error while retrieving blogs:', error);
          });
      },
      getLatestFeaturedBlog() {
        axios
          .get('/api/latest-featured-blog')
          .then(response => {
            if (response.data.success) {
              this.latestNews = response.data.data;
            } else {
              console.error('Failed to retrieve latest featured blog:', response.data.error);
            }
          })
          .catch(error => {
            console.error('Error while retrieving latest featured blog:', error);
          });
      },
    },
  };
  </script>
  