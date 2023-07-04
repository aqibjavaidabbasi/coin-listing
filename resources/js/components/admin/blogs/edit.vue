<template>
    <Layout>
        <div class="page-header">
            <h3 class="page-title"> Edit Blogs </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <router-link to="/admin/blogs">List</router-link>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-12">
                <h4 class="card-title">Add new blog</h4>
                <ValidationObserver v-slot="{ handleSubmit }" ref="observer">
                    <form class="form-sample">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <validation-provider name="Blog Title" rules="" v-slot="{ errors }">
                                                <input type="text" class="form-control mb-3" id="title" v-model="blog.title"
                                                    placeholder="Blog title" @keydown="generateSlug" required>
                                                <span class="text-sm text-danger">{{ errors[0] }}</span>
                                            </validation-provider>
                                            <p class="text-muted"><strong>Link : </strong>{{ blog.slug }}</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="content">Content</label>
                                            <editor api-key="no-api-key" :init="editorOption" v-model="blog.content" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h4>Publish</h4>
                                    </div>

                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" class="form-control" id="status" v-model="blog.is_active">
                                                <option :value="0">Draft</option>
                                                <option :value="1">Published</option>
                                            </select>
                                        </div>



                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary float-end"
                                                @click="handleSubmit(updateBlog)">Publish</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-3">
                                    <div class="form-group p-3">
                                        <label for="status">Feature </label>
                                        <label class="switch float-end">
                                            <input type="checkbox" name="is_featured"  v-model="blog.is_featured">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h4>Featured Image</h4>
                                    </div>
                                   
                                    <validation-provider name="Coin Image" rules="" v-slot="{ errors }">
                                        <label class="btn btn-dark bg-dark-700 w-100" @input="pickFile">
                                            <div class="py-1 border border-bottom border-dark pb-5">
                                                <i class="fas fa-file-upload"></i> Coin Image <span
                                                    class="text-danger">*</span>
                                            </div>
                                            <input type="file" accept="image/*" ref="fileInput" class="imageInput" required>
                                            <div class="imagePreviewWrapper mt-0 m-auto"
                                                :style="{ 'background-image': `url(${previewImage})` }">
                                                <!-- Display the pre-selected image -->
                                                <img v-if="previewImage" :src="getImageUrl(blog.image)"
                                                    class="imagePreviewWrapperedit" alt="Preview Image">
                                            </div>
                                        </label>
                                        <span class="text-sm text-danger">{{ errors[0] }}</span>
                                    </validation-provider>

                                </div>
                            </div>
                        </div>
                    </form>
                </ValidationObserver>
            </div>
        </div>
    </Layout>
</template>
<script>
import Layout from "../layout";
import VueDropify from 'vue-dropify';
import Editor from '@tinymce/tinymce-vue'
import axios from 'axios';


export default {
    name: 'Edit',
    data() {
        return {
            dropifyOptions: {
                accept: 'image/*',
            },
            blog: {
                title: '', // Initialize with empty values
                slug: '',
                content: '',
                is_active: 1,
                is_featured: '',

            },


            editorOption: {
                selector: 'textarea#open-source-plugins',
                plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
                imagetools_cors_hosts: ['picsum.photos'],
                menubar: 'file edit view insert format tools table help',
                toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
                toolbar_sticky: true,
                autosave_ask_before_unload: true,
                autosave_interval: '30s',
                autosave_prefix: '{path}{query}-{id}-',
                autosave_restore_when_empty: false,
                autosave_retention: '2m',
                image_advtab: true,
                link_list: [
                    { title: 'My page 1', value: 'https://www.tiny.cloud' },
                    { title: 'My page 2', value: 'http://www.moxiecode.com' }
                ],
                image_list: [
                    { title: 'My page 1', value: 'https://www.tiny.cloud' },
                    { title: 'My page 2', value: 'http://www.moxiecode.com' }
                ],
                image_class_list: [
                    { title: 'None', value: '' },
                    { title: 'Some class', value: 'class-name' }
                ],
                importcss_append: true,
                file_picker_callback: function (callback, value, meta) {
                    /* Provide file and text for the link dialog */
                    if (meta.filetype === 'file') {
                        callback('https://www.google.com/logos/google.jpg', { text: 'My text' });
                    }

                    /* Provide image and alt text for the image dialog */
                    if (meta.filetype === 'image') {
                        callback('https://www.google.com/logos/google.jpg', { alt: 'My alt text' });
                    }

                    /* Provide alternative source and posted for the media dialog */
                    if (meta.filetype === 'media') {
                        callback('movie.mp4', { source2: 'alt.ogg', poster: 'https://www.google.com/logos/google.jpg' });
                    }
                },
                templates: [
                    { title: 'New Table', description: 'creates a new table', content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>' },
                    { title: 'Starting my story', description: 'A cure for writers block', content: 'Once upon a time...' },
                    { title: 'New list with dates', description: 'New List with dates', content: '<div class="mceTmpl"><span class="cdate">cdate</span><br /><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>' }
                ],
                template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
                template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
                height: 600,
                image_caption: true,
                quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
                noneditable_noneditable_class: 'mceNonEditable',
                toolbar_mode: 'sliding',
                contextmenu: 'link image imagetools table',
                skin: 'oxide-dark',
                content_css: 'dark',
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
            },
            previewImage: 'https://www.lyon-ortho-clinic.com/files/cto_layout/img/placeholder/book.jpg',
            previewHeight: 0
        }
    },
 
    components: {
        Layout,
        Editor,
    },
    created() {
        this.fetchBlogData();
    },

    methods: {
        getImageUrl(previewImage) {
            const baseUrl = process.env.MIX_APP_URL;

            return baseUrl + '/storage/blog/' + previewImage;
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
            this.blog.image = file[0]
        },
        generateSlug() {
            console.log(this.blog.title)

            this.blog.slug = 'http://127.0.0.1:8000' + '/' + this.blog.title.toLowerCase().replace(/ /g, '-')
        },
        updateBlog() {
            const blogId = this.$route.params.id;
            this.$refs.observer.validate().then(success => {
                if (success) {
                    let formData = new FormData()
                    for (let key in this.blog) {
                        formData.append(key, this.blog[key]);
                    }

                    // formData.append('image', this.coin.image)
                    formData.append('source', 'admin')
                    console.log(formData);
                    axios.post('/api/blog-update/' + blogId, formData)
                        .then(res => {
                            if (res.data.success == true) {
                                // empty input fields
                                // this.blog = {
                                //     name: "",
                                //     slug: "",
                                //     content: "",

                                // }
                              //  this.$refs.observer.reset();
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
        },

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
                            is_featured: blogData.is_featured,
                        };
                        this.previewImage = blogData.image;
                    } else {
                        // Handle error
                    }
                })
                .catch(err => {
                    // Handle error
                });
        },
    }
}
</script>