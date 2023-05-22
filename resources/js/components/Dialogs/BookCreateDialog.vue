<template>
        <Dialog header="Header" :visible.sync="showCreateDialog" :containerStyle="{width: '500px'}" @hide="clearBookForm">
            <div class="form">
                <div class="mb-3">
                    <label for="formGroupExampleInput" class="form-label">Name</label>
                    <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Name"
                           v-model="bookForm.name">
                </div>
                <div class="mb-3">
                    <label for="formGroupExampleInput2" class="form-label">Publish Date</label>
                    <input type="date" class="form-control" id="formGroupExampleInput2"
                           placeholder="Publish Date" v-model="bookForm.publish_date">
                </div>
                <div class="mb-3">
                    <label for="formGroupExampleInput3" class="form-label">Author</label>
                    <select class="form-control" id="formGroupExampleInput3"
                            placeholder="Choose Author"
                            v-model="bookForm.author_id"
                    >
                        <option v-for="author in authors" :key="author.id" :value="author.id">
                            {{ author.first_name }} {{ author.last_name }}
                        </option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="formGroupExampleInput4" class="form-label">Genres</label>
                    <select class="form-control" id="formGroupExampleInput4"
                            placeholder="Choose Author"
                            v-model="bookForm.genres"
                            multiple
                    >
                        <option v-for="genre in genres" :key="genre.id" :value="genre.id">
                            {{ genre.name }}
                        </option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="formGroupExampleInput5" class="form-label">Pages Count</label>
                    <input type="number" class="form-control" id="formGroupExampleInput5"
                           placeholder="Pages Count" v-model="bookForm.page_count">
                </div>
                <div class="mb-3">
                    <label for="formGroupExampleInput6" class="form-label">Avg. Reading Time</label>
                    <input type="number" class="form-control" id="formGroupExampleInput6"
                           placeholder="Avg. Reading Time" v-model="bookForm.avg_reading_time">
                </div>
            </div>

            <template #footer>
                <Button label="Save" @click="saveBook"/>
            </template>
        </Dialog>
</template>

<script>

import Button from 'primevue/button';
import Dialog from 'primevue/dialog';

export default {
    name: "App",
    props: {
        showCreateDialog: {
            type: Boolean,
            default: false,
        },
        genres: {
            type: Array,
            default: [],
        },
        authors: {
            type: Array,
            default: [],
        },
    },
    components: {
        Button,
        Dialog,
    },
    data() {
        return {
            bookForm: {
                name: null,
                author_id: null,
                publish_date: null,
                genres: [],
                page_count: null,
                avg_reading_time: null,
            },
            filterForm: {
                first_name: null,
                last_name: null,
                birthday: null,
                alive: null,
                publish_date: null,
                genres: [],
                avg_reading_time: null,
            },
        }
    },
    mounted() {
    },
    methods: {
        saveBook() {
            axios.post('api/book', this.bookForm).then((res) => {
                if (res.data.success) {
                    this.$emit('afterSubmit', true)

                    this.clearBookForm();
                }
            })
        },
        clearBookForm() {
            this.bookForm = {
                name: null,
                author_id: null,
                publish_date: null,
                genres: [],
                pages_count: null,
                avg_reading_time: null,
            }
        },
    }
}
</script>

<style scoped>

</style>
