<template>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="search">Search</label>
                <input type="text" class="form-control" id="search" placeholder="Search" v-model="filter.search">
            </div>
        </div>
        <div class="col-md-3" v-if="type === 'coins'">
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" v-model="filter.status">
                    <option value="">All</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="status">Listing Status</label>
                <select class="form-control" id="status" v-model="filter.listing_status">
                    <option value="">All</option>
                    <option value="preslae">Preslae</option>
                    <option value="listed">Listed</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <label for="sort">Sort</label>
            <select class="form-control" id="sort" v-model="filter.sort">
                <option value="id">ID</option>
                <option value="name">Name</option>
                <option value="votes">Votes</option>
                <option value="created_at">Created At</option>
            </select>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Filters',
    data() {
        return {
            filter: {
                search: '',
                status: '',
                listing_status: '',
                sort: 'id'
            }
        }
    },
    props: {
        filters: {
            type: Object,
            default: () => {
                return {
                    search: '',
                    status: '',
                    listing_status: '',
                    sort: 'id'
                }
            }
        },
        type: {
            type: String,
            default: 'coins'
        }
    },
    watch: {
        filter: {
            handler: function (val) {
                this.$emit('filter', val);
            },
            deep: true
        }
    },
    created() {
        this.$emit('filter', this.filter);
    },

}
</script>