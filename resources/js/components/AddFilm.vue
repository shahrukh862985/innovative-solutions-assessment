<template>
    <div>
        <!-- <h3 class="text-center">Film Detail</h3> -->
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h3>Add Film</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" @submit.prevent="addFilmFormSubmit">
                        <div class="row">
                            <div class="form-group col-md-6 mb-3">
                                <label for="">Name</label>
                                <input type="text" v-model="form.name"  class="form-control"
                                    placeholder="Enter Name">
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="">Slug</label>
                                <input type="text" v-model="form.slug"  class="form-control"
                                    placeholder="Enter Slug">
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="">Country</label>
                                <input type="text" v-model="form.country"  class="form-control"
                                    placeholder="Enter Country">
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="">Release Date</label>
                                <input type="date" v-model="form.release_date"  class="form-control"
                                    placeholder="Enter Release Date">
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="">Rating</label>
                                <input type="number" step="0.1" v-model="form.rating"  class="form-control"
                                    placeholder="Enter Rating">
                                <div id="emailHelp" class="form-text">Rating must be between 1 to 5</div>
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="">Price</label>
                                <input type="number" step="0.1" v-model="form.price"  class="form-control"
                                    placeholder="Enter Price">
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="">Genre</label>
                                <vue-tags-input v-model="form.tag" :tags="form.genre" @tags-changed="newTags => form.genre = newTags" />
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="">Photo</label><br>
                                <input type="file" class="form-control-file" id="file" ref="file" v-on:change="onChangeFileUpload()">
                            </div>
                            <div class="form-group col-md-12 mb-3">
                                <label for="">Description</label>
                                <textarea rows="5" v-model="form.description"  class="form-control"></textarea>
                            </div>
                        </div>
                        <input type="submit" value="Add" class="btn btn-primary">
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import VueTagsInput from '@johmun/vue-tags-input';
const url = process.env.MIX_BASE_URL
export default {
    components: {
        VueTagsInput,
    },
    data() {
        return {
            form: {
                tag: '',
                genre: []
            },
            file:''
        }
    },
    created() {
        
    },
    methods: {
        
        addFilmFormSubmit(){
            let _this = this
            axios.post(`${url}/api/films`,
                this.parseFormObjectToFormData(),
                {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
              }
            ).then(response =>{
                Vue.$toast.open({
                        message: response.data.message,
                        type: 'success',
                        position: 'top-right'
                    });
                _this.$router.push({name:'films'})
            })
            .catch(err => {
                Vue.$toast.open({
                    message: this.parseValidationErrors(err.response.data.error),
                    type: 'error',
                    position: 'top-right'
                });
            });
        },
        onChangeFileUpload(){
            this.file = this.$refs.file.files[0];
        },
        parseFormObjectToFormData(){
            let formData = new FormData()
            formData.append('name', this.form.name)
            formData.append('slug', this.form.slug)
            formData.append('country', this.form.country)
            formData.append('release_date', this.form.release_date)
            formData.append('rating', this.form.rating)
            formData.append('price', this.form.price)
            for (const item of this.form.genre) {
                formData.append('genre[]', item.text)
            }
            formData.append('description', this.form.description)
            formData.append('photo',this.file)
            return formData
        }
    }
}
</script>