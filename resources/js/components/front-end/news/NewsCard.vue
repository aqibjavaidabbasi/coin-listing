<template>
    <div>
        <div class="card bg-dark-500 rounded mb-3">
            <div class="card-header p-0">
                <img src="https://s2.coinmarketcap.com/static/cloud/img/CMC_Headlines.png?_=948d22e" alt="" class="img-fluid rounded-xt">
            </div>
            <div class="card-body text-light">
                <div class="">
                    <h4 class="card-title text-muted">Boots on the Ground, Inclusive Thought
                        Provoking Ideas</h4>
                    <p class="card-text text-dark-200">Empower communities and energize engaging
                        ideas; scale and impact do-gooders while disruptring industries. Venture
                        philanthropy benefits corporations and people by moving the needle.
                        <router-link class="nav-link text-info text-decoration-none" to="/news-detail/slug">Read more...</router-link>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'NewsCard'
}
</script>