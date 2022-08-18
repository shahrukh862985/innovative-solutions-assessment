<template>
    <div>
        <!-- <h3 class="text-center">Film Detail</h3> -->
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <img :src="film.photo" class="card-img-top" :alt="film.slug">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h2>{{ film.name }}</h2>
                <table class="table">
                    <tbody>
                        <tr>
                            <th scope="row">Ticket Price</th>
                            <td>{{ film.price }}/RS</td>
                        </tr>
                        <tr>
                            <th scope="row">Added</th>
                            <td>{{ film.created_at }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Rating</th>
                            <td>{{ film.rating }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Released</th>
                            <td>{{ film.release_date }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Genre</th>
                            <td>{{ parseGenre(film) }}</td>
                        </tr>
                        <tr>
                            <th>Country</th>
                            <td>{{ film.country }}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>{{ film.description }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="d-flex justify-content-between my-2">
                    <h2>Film Comments</h2>

                </div>
            </div>
            <div class="col-md-10 mb-2" v-if="authenticate">
                <form @submit.prevent="commentFormSubmit" method="post">
                    <div class="form-group">
                        <label for="">Comment</label>
                        <textarea rows="5" v-model="form.comment" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-secondary mt-2">Add Comment</button>
                </form>
            </div>
            <div class="col-md-10 mb-3" v-for="(value, key) in film.comments">
                <div class="card">
                    <div class="card-body">
                        <h5>{{ value.username }} <span class="text-secondary comment-date">{{ value.added_date }}</span>
                        </h5>
                        <p>{{ value.comment }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

const url = process.env.MIX_BASE_URL
export default {
    data() {
        return {
            film: {
                comments: []
            },
            form: {
                comment: ''
            },
            authenticate: false
        }
    },
    created() {
        this.getFilmDetail()
        this.isAuthenticate()
    },
    methods: {
        parseGenre(film) {
            if (film.hasOwnProperty('genre'))
                return film.genre.join(', ')

            return ''
        },
        getFilmDetail() {
            const _this = this
            const paramSlug = _this.$route.params.id
            axios.get(`${url}/api/films/${paramSlug}`)
                .then(response => {
                    _this.film = response.data
                })
                .catch(err => {
                    Vue.$toast.open({
                        message: this.parseValidationErrors(err.response.data.error),
                        type: 'error',
                        position: 'top-right'
                    });
                })
        },
        commentFormSubmit() {
            if (this.form.comment === '') {
                Vue.$toast.open({
                    message: "Comment field is required.",
                    type: 'error',
                    position: 'top-right'
                });
                return;
            }
            let _this = this
            axios.post(`${url}/api/comments`,
                {
                    comment: this.form.comment,
                    film_id: this.film.id
                }
            ).then(response => {
                Vue.$toast.open({
                    message: response.data.message,
                    type: 'success',
                    position: 'top-right'
                });
                _this.form.comment = '';
                _this.film.comments.splice(0, 0, response.data.comment)
            })
                .catch(err => {
                    Vue.$toast.open({
                        message: this.parseValidationErrors(err.response.data.error),
                        type: 'error',
                        position: 'top-right'
                    });
                });
        },
        isAuthenticate() {
            this.authenticate = this.$parent.isAuthenticate()
        }
    }
}
</script>
<style scoped>
.comment-date {
    float: right;
    font-size: 14px;
}
</style>