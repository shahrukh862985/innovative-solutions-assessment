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
                <h2>{{film.name}}</h2>
                <table class="table">
                    <tbody>
                        <tr>
                            <th scope="row">Added</th>
                            <td>{{film.created_at}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Rating</th>
                            <td>{{film.rating}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Released</th>
                            <td>{{film.release_date}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Genre</th>
                            <td>{{parseGenre(film)}}</td>
                        </tr>
                        <tr>
                            <th>Country</th>
                            <td>{{film.country}}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>{{film.description}}</td>
                        </tr>
                    </tbody>
                </table>
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
            film: {}
        }
    },
    created() {
        this.getFilmDetail()
    },
    methods: {
        parseGenre(film){
            if(film.hasOwnProperty('genre'))
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
        }
    }
}
</script>