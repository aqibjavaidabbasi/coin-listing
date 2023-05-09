<template>
    <div>
        <div class="container-scroller">
            <Sidebar />
            <div class="container-fluid page-body-wrapper">
                <Header />
                <div class="main-panel">
                    <div class="content-wrapper">
                        <slot></slot>
                    </div>
                    <Footer />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Sidebar from './partials/sidebar.vue'
import Header from './partials/header.vue'
import Footer from './partials/footer.vue'

export default {
    name: 'Dashboard',
    components: {
        Sidebar,
        Header,
        Footer
    },
}
</script>