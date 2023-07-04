<template>
    <Layout>
        <div class="page-header">
            <h3 class="page-title"> Vuew Blogs </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">List</li>
                </ol>
            </nav>
        </div>
        <div class="container py-5">
            <div>
                <div class="card bg-dark-500 rounded">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <img :src="getImageUrl(blog.image)" v-if="blog.image"
                                    style="width: 100% !important;border-radius: 0;" alt="image" class="img-fluid rounded">
                                <img :src="getImageUrlPlaceholder()" v-else style="width: 100% !important;border-radius: 0;"
                                    alt="image" class="img-fluid rounded">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="container py-5">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="card bg-dark-500 rounded">
                        <div class="card-header text-muted text-center">
                            <h1> {{ blog.title }}</h1>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div v-html="blog.content"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        
    </Layout>
</template>

<script>
import Layout from "../layout";
export default {
    name: 'View Blog',
    data() {
        return {
            dropifyOptions: {
                accept: 'image/*',
            },
            blog: {
                title: '', // Initialize with empty values
                slug: '',
                content: '',
                image: '',
                is_active: 1,
            },
        }
    },
    components: {
        Layout
    },
    created() {
        this.fetchBlogData();
    },
    methods: {
        fetchBlogData() {
            const blogId = this.$route.params.id;
            axios.get(`/api/blog-edit/${blogId}`)
                .then(res => {

                    if (res.data.success) {

                        const blogData = res.data.data;
                        console.log('data', res.data.data.id)
                        this.blog = {
                            id: blogData.id,
                            title: blogData.title,
                            slug: blogData.slug,
                            content: blogData.content,
                            image: blogData.image,
                            is_active: blogData.is_active,
                        };
                        
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