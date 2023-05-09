<template>
    <div>
        <div class="card bg-dark-500 rounded">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <img src="https://s2.coinmarketcap.com/static/cloud/img/CMC_Headlines.png?_=948d22e" alt="" class="img-fluid rounded">
                    </div>
                    <div class="col-md-6">
                        <div class="card-body text-light">
                            <div class="py-5">
                                <h4 class="card-title">Boots on the Ground, Inclusive Thought
                                    Provoking Ideas</h4>
                                <p class="card-text">Empower communities and energize engaging
                                    ideas; scale and impact do-gooders while disruptring industries. Venture
                                    philanthropy benefits corporations and people by moving the needle.
                                    <router-link class="nav-link text-info text-decoration-none" to="/news-detail/slug">Read more...</router-link>

                                </p>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'NewsBanner'
}
</script>