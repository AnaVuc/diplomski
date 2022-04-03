<template>
    <div class="block ">
        <div class="w-full h-3/5 coverImage">
        <div class="relative">
            <img class="object-contain w-screen h-1/2 bg-image " src="images/cover.jpg" />
            <div class="absolute inset-0 z-10 bg-gradient-to-t from-gray-700 text-blue-50">
                <div class="mt-16 mx-6 flex justify-start pt-6 ">
                    <div class="block p-4 opacity-90">
                        <div class="flex justify-end">
                            <div class="text-6xl  font-semibold">Track films you’ve watched.</div>
                        </div>
                        <div class="flex justify-end pt-2">
                            <div class="text-xl font-medium">Show some love for your favourite films. Rate each film on a five-star scale.</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        </div>
        <div class="block pt-2 pb-12">
            <div class="flex justify-items-center justify-center pb-5">
                <div class="font-bold text-4xl text-white">
                    Most popular movies
                </div>
            </div>
            <div class="flex justify-items-center justify-center">
                    <div class="px-4"
                        v-for="movie in popularMovies"
                        :key="movie.id" >
                        <router-link :to="{ path:`film/${movie.id}`}">
                            <movie-card :image='movie.image' :title="movie.title" :year="movie.year" :id="movie.id" :watched="movie.numWatched" :liked="movie.numLiked" :rating="movie.rating"> </movie-card>
                        </router-link>
                    </div>
            </div>
            <div class="my-5 border-b-2 border-gray-500"></div>
            <div class="flex justify-items-center justify-center pt-2 pb-5">
                <div class="font-bold text-4xl text-white">
                    Top rated movies
                </div>
            </div>
            <div class="flex justify-items-center justify-center">
                <div class="px-4"
                    v-for="movie in topRatedMovies"
                    :key="movie.id" >
                    <router-link :to="{ path:`film/${movie.id}`}">
                        <movie-card :image='movie.image' :title="movie.title" :year="movie.year"></movie-card>
                    </router-link>

                </div>
            </div>
        </div>
    </div>

</template>


<script>
import MovieCard from '../components/delovi/MovieCard.vue'

export default {
    components:{
      MovieCard
    },
    data() {
        return {
            popularMovies: [],
            popularIds: [],
            topRatedMovies: [],
            topRatedIds: [],
            showDetails: false,
        };
    },
    mounted() {
        this.getPopularMovies();
        this.getTopRatedMovies();
    },
    methods: {
        goToFilm(id){
            console.log(id)
            // router.push({ path: `film/${id}`});
        },
        async getPopularMovies() {

            await axios.get("https://imdb-api.com/en/API/MostPopularMovies/pk_3i6onjtnv0nkvost7").then(response => {
                    this.popularMovies = response.data.items.splice(0, 5);

            })
            .catch(function(error) {
                console.error(error);
            });
            this.getStatsForMovies();


        },
        async getTopRatedMovies(){
            await axios.get('/api/topRatedMovies').then(res=>{
                this.topRatedIds=res.data;
                console.log(res.data)
            })
            this.topRatedIds.forEach( id=>{
                axios.get('https://imdb-api.com/en/API/Title/pk_3i6onjtnv0nkvost7/'+id).then(res=>{
                    this.topRatedMovies.push(res.data);
                })
            }
            )
        },
        getStatsForMovies(){
            console.log(this.popularMovies)
            axios.post('/api/statsForFilms',{films:this.popularMovies}).then(res=>{
                this.popularMovies=res.data;
            })
        }
    }
};
</script>
<style>
.coverImage{
    background-image: url('/images/cover.jpg');
    background-size: contain;
    background-attachment: fixed;
}
</style>

