<template>
    <div>
        <h3 class="text-center">List of Films</h3>
        <div class="row">
            <div class="col-md-4" v-for="(film, key) in films" :key="film.id">
                <div class="card mb-2" style="width: 18rem;">
                    <img :src="film.photo" class="card-img-top" :alt="film.slug">
                    <div class="card-body">
                        <h5 class="card-title">{{ film.name }}</h5>
                        <router-link :to="'/films/'+film.slug" class="btn btn-primary">Show Details</router-link>
                    </div>
                    <div class="card-footer text-muted">
                        Release Date: {{ film.release_date }}
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
        return { films: [] }
    },
    created() {
        this.getFilms()
    },
    methods: {
        getFilms() {
            const _this = this
            axios.get(`${url}/api/films`)
                .then(response => {
                    _this.films = response.data
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