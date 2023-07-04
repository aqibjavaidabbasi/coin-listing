<template>
    <Layout>
        <div class="page-header">
            <h3 class="page-title"> Blogs </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">List</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Icon </th>
                                <th> Blog Status </th>
                                <th> Title </th>
                                <th> Featured </th>
                                <th> Promoted </th>
                                <th> visitors </th>
                                <th> Impressions </th>
                                <th>  </th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="blog in blogs" :key="blog.id" :id="'blogRow_' + blog.id">
                                <td> {{ blog.id }} </td>
                                <td>
                                    <img :src="getImageUrl(blog.image)" v-if="blog.image" class="responsive"
                                        alt="image"
                                       >
                                    <img :src="getImageUrlPlaceholder()" v-else class="responsive"
                                        alt="image"
                                        >
                                </td>

                                <td>
                                    <div v-if="blog.is_active === 1" class="badge badge-pill badge-success">Active</div>
                                    <div v-else class="badge badge-pill badge-danger">Inactive</div>
                                </td>
                                <td>
                                    <h6 class="mb-1 text-light">{{ blog.title }}</h6>
                                </td>

                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="is_featured" v-model="blog.is_featured"
                                            @change="updateBlog(blog, 'is_featured')">
                                        <span class="slider round"></span>
                                    </label>
                                </td>

                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="is_promoted" v-model="blog.is_promoted"
                                            @change="updateBlog(blog, 'is_promoted')">
                                        <span class="slider round"></span>
                                    </label>
                                </td>

                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="visitors" v-model="blog.visitors"
                                            @change="updateBlog(blog, 'visitors')">
                                        <span class="slider round"></span>
                                    </label>
                                </td>

                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="impressions" v-model="blog.impressions"
                                            @change="updateBlog(blog, 'impressions')">
                                        <span class="slider round"></span>
                                    </label>
                                </td>

                                <td>
                                    <li class="nav-item dropdown list-style">
                                        <a class="nav-link" id="profileDropdown" href="#" data-bs-toggle="dropdown">
                                            <div class="navbar-profile action-view">
                                                <p class="mb-0 d-none d-sm-block navbar-profile-name text-white">Action</p>
                                                <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list dropdown-action" aria-labelledby="profileDropdown">

                                            <router-link :to="'/admin/blogs/edit/' + blog.id" class="list-style">
                                                <p class="p-1 mb-0 text-center list-style">Edit</p>
                                            </router-link>
                                            <div class="dropdown-divider"></div>
                                            <p class="p-1 mb-0 text-center" @click.prevent="deleteBlogs(blog.id)">Delete</p>
                                            <div class="dropdown-divider"></div>
                                            <router-link :to="'/admin/blogs/view/' + blog.id" class="list-style">
                                                <p class="p-1 mb-0 text-center list-style">View</p>
                                            </router-link>
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
export default {
    name: 'EditBlog',
    data() {
        return {
            blogs: []
        }
    },
    components: {
        Layout
    },
    created() {
        this.getBlogs();
    },
    methods: {
        updateBlog(blog, field) {
            let updateValue = blog[field] ? 1 : 0;

            let fieldName = '';
            switch (field) {
                case 'is_featured':
                    fieldName = 'Feature';
                    break;
                case 'is_promoted':
                    fieldName = 'Promotion';
                    break;
                case 'visitors':
                    fieldName = 'Visitors';
                    break;
                case 'impressions':
                    fieldName = 'Impressions';
                    break;
            }

            let messages = ''; // Declare and initialize the variable

            axios
                .post(process.env.MIX_API_URL + '/blog-status-update/' + blog.id, {
                    [field]: updateValue
                })
                .then(response => {

                    messages = response.data.message; // Assign the value from response.data.message

                    this.$swal({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Blog Status Updated',
                        text: messages,
                        target: '#custom-target',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                        toast: true,
                        background: 'linear-gradient(to bottom right, #1ea38f 0%, #5cf9e2 100%)',
                    });
                })
                .catch(error => {
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
                        background: 'linear-gradient(to bottom right, #b51b35 0%, #fd4a68 100%)',
                    });
                    console.error(error);
                });
        },

        getBlogs() {
            var context = this;
            axios.get('/api/blogs/list-blogs')
                .then(response => {
                    context.blogs = response.data.data;

                })
                .catch(error => {
                    console.log(error);
                });
        },

        deleteBlogs(blogId) {
            if (!confirm('Are you sure you want to delete this post?' + blogId)) {
                return;
            }

            axios.post('/api/blog-delete/' + blogId, {
                "_method": 'delete',
            })
                .then(res => {
                    if (res.data.success == true) {
                        // Remove the table row
                        const tableRow = document.getElementById('blogRow_' + blogId);
                        if (tableRow) {
                            tableRow.remove();
                        }

                        // Display success message
                        this.$swal({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Blog deleted successfully!',
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