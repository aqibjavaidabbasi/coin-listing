<template>
    <div>
        <frontend-header></frontend-header>
        <promoted-coins></promoted-coins>
        <coins-list></coins-list>
        <sources></sources>
        <frontend-footer></frontend-footer>
    </div>
</template>

<script>
import FrontendHeader from './partials/header.vue'
import PromotedCoins from './coins/PromotedCoins.vue'
import CoinsList from './coins/CoinsList.vue'
import FrontendFooter from './partials/footer.vue'
import Sources from './partials/Sources.vue'

export default {
    name: 'MainComponent',
    components: {
    FrontendHeader,
    PromotedCoins,
    CoinsList,
    FrontendFooter,
    Sources
}
}
</script>