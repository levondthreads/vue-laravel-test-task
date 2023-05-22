<template>
    <Toolbar>
        <template #start>
            <Button label="New" icon="pi pi-plus" class="mr-2" @click="showModal"/>
        </template>

        <template #end>
            <select name="" id="" v-model="selectedFilter" class="form-control filterSelect"
                    @change="changeFilterField">
                <option v-for="filterField in filters" :value="filterField" :key="filterField.field">
                    {{ filterField.label }}
                </option>
            </select>


            <input v-if="filterIsText" type="text" class="filter-field" v-model="filterForm.value"
                   :placeholder="selectedFilter.label">
            <input v-else-if="filterIsBoolean" type="checkbox" class="filter-field" v-model="filterForm.value"
                   :checked="filterForm.value">
            <input v-else-if="filterIsDate" type="date" class="filter-field" v-model="filterForm.value"
                   :checked="filterForm.value">
            <select v-else-if="filterIsArray" class="form-control filter-field" v-model="filterForm.value" multiple>
                <option v-for="genre in genres" :value="genre.name">{{ genre.name }}</option>
            </select>

            <Button label="Filter" icon="pi pi-filter" class="mr-2" @click.prevent="$emit('filterBooks', filterForm)"/>
            <Button label="Clear" icon="pi pi-filter" class="mr-2" @click.prevent="clearFilters"/>


        </template>
    </Toolbar>
</template>

<script>

import Toolbar from 'primevue/toolbar';
import Button from 'primevue/button';

export default {
    name: "App",
    props: {
        genres: {
            type: Array,
            default: [],
        },
    },
    components: {
        Toolbar,
        Button,
    },
    data() {
        return {
            filters: [
                {field: 'first_name', label: "First Name", type: 'text'},
                {field: 'last_name', label: "Last Name", type: 'text'},
                {field: 'birthday', label: "Birthday", type: 'date'},
                {field: 'alive', label: "Alive", type: 'bool'},
                {field: 'publish_date', label: "Publish Date", type: 'date'},
                {field: 'genres', label: "Genres", type: 'array'},
            ],
            filterForm: {
                field: null,
                value: null,
                type: null
            },
            selectedFilter: null,
        }
    },
    methods: {
        showModal() {
            this.$emit('showModal', true);
        },
        clearFilters() {
            this.filterForm = {
                field: null,
                value: null,
                type: null
            };
            this.selectedFilter = null;
            this.$emit('filterBooks', null)
        },
        changeFilterField() {
            this.filterForm.field = this.selectedFilter.field
            this.filterForm.type = this.selectedFilter.type
            this.filterForm.value = this.selectedFilter.type === 'array' ? [] : null;
        }
    },
    computed: {
        filterIsText() {
            return this.selectedFilter && this.selectedFilter.type === 'text';
        },
        filterIsArray() {
            return this.selectedFilter && this.selectedFilter.type === 'array';
        },
        filterIsDate() {
            return this.selectedFilter && this.selectedFilter.type === 'date';
        },
        filterIsBoolean() {
            return this.selectedFilter && this.selectedFilter.type === 'bool';
        }
    }
}
</script>

<style scoped>
.filterSelect {
    width: 150px;
    margin-right: 100px;
}

.filter-field {
    margin-right: 50px;
}
</style>
