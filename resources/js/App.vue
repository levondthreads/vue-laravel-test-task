<template>
    <div class="container mt-5">

        <BookToolbar @showModal="showCreateDialog = true" :genres="genres" @filterBooks="loadBooks"/>

        <Datatable
            :value="books"
            stateStorage="local"
            stateKey="dt-state-demo-session"
            responsiveLayout="scroll"
            @sort="sort"
        >

            <Column header="ID" field="id" sortable>
            </Column>

            <div v-for="column in defaultColumns" :key="column.field">
                <Column
                    v-if="column.field === 'full_name'"
                    :header="column.header"
                    sortable
                >
                    <template #body="slotProps">
                        <span>{{ slotProps.data.first_name + ' ' + slotProps.data.last_name }}</span>
                    </template>
                </Column>

                <Column
                    v-else
                    :field="column.field"
                    :header="column.header"
                    :key="column.field"
                    sortable
                >

                </Column>
            </div>

            <Column header="Actions">
                <template #body="slotProps">
                    <Button><i class="pi pi-trash" @click="deleteBook(slotProps.data.id)"></i></Button>
                </template>
            </Column>

        </Datatable>

        <Paginator :rows="per_page" :totalRecords="total_records" @page="onPage"></Paginator>


        <BookCreateDialog :genres="genres" :authors="authors" :showCreateDialog="showCreateDialog" @afterSubmit="closeModal"/>
    </div>
</template>

<script>

import Column from 'primevue/column'
import Toolbar from 'primevue/toolbar';
import Button from 'primevue/button';
import Paginator from 'primevue/paginator';
import BookCreateDialog from "./components/Dialogs/BookCreateDialog.vue";
import BookToolbar from "./components/Toolbars/BookToolbar.vue";
export default {
    name: "App",
    components: {
        Column,
        Toolbar,
        Button,
        Paginator,
        BookCreateDialog,
        BookToolbar,
    },
    data() {
        return {
            books: [],
            showCreateDialog: false,
            page: 1,
            per_page: 10,
            total_records: 0,
            defaultColumns: [
                {
                    field: 'name',
                    header: 'Name',
                },
                {
                    field: 'genres',
                    header: 'Genre',
                },
                {
                    field: 'publish_date',
                    header: 'Published AT',
                },
                {
                    field: 'full_name',
                    header: 'Author',
                },
            ],
            authors: [],
            genres: [],
        }
    },
    mounted() {
        this.loadGenres();
        this.loadAuthors();
        this.loadBooks();
    },
    methods: {
        sort({sortField, sortOrder}) {
            this.loadBooks(sortField, sortOrder)
        },
        loadBooks($event) {
            axios.get('api/book', {
                params: {
                    page: this.page,
                    per_page: this.per_page,
                    filters: $event
                }
            }).then(({data}) => {
                this.books = data.data;
                this.page = data.page;
                this.per_page = data.per_page;
                this.total_records = data.total_records;
            })
        },
        loadAuthors() {
            axios.get('api/author', {}).then(({data}) => {
                this.authors = data.data;
            })
        },
        loadGenres() {
            axios.get('api/genres', {}).then(({data}) => {
                this.genres = data.data;
            })
        },
        closeModal() {
            this.showCreateDialog = false;
            let lastPage = Math.ceil(this.total_records / this.per_page);
            if (this.page < lastPage) {
                this.page = lastPage
            }
            this.loadBooks();
        },
        onPage(event) {
            this.page = event.page + 1;
            this.loadBooks();
        },
        deleteBook(id) {
            axios.delete(`api/book/${id}`).then(({data}) => {
                if (data.success) {
                    this.loadBooks();
                } else {
                    alert('Some Error!!')
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
