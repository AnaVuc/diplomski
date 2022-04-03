<template>
    <div class="text-white">
        <div class="p-5">
            <!-- <div class="grid grid-flow-row grid-flow-col gap-4">
                <div v-for="movie in films" :key="movie.id" class="block">
                    <router-link :to="{ path:`film/${movie.id}`}">
                        <div class="block">
                            <img :src="movie.image" class="h-80 w-64 rounded-md hover:border-blue-300 object-contain">
                            <span class="pr-2 text-lg underline ">{{movie.fullTitle}}</span>
                            <div>
                                <span class="italic text-base pr-2">Watched on: </span><span class="font-light text-lg">{{movie.date_watched | dateFilter}} </span>
                            </div>
                        </div>
                    </router-link>
                </div>
            </div> -->
            <div class="flex  px-10">
            <div class="grid grid-cols-5  gap-3">
                <div v-for="film in films" :key="film.id">
                    <router-link :to="{ path: `film/${film.id}` }">
                        <movie-card
                            :size="'w-60 h-80'"
                            :image="film.image"
                            :title="film.title"
                            :year="film.description"
                            :id="film.id"
                            :noStats="true"
                        >
                        </movie-card>
                        <div>
                            <span class="italic text-base pr-2">Watched on: </span><span class="font-light text-lg">{{film.date_watched | dateFilter}} </span>
                        </div>
                    </router-link>
                </div>
            </div>
        </div>
        </div>
    </div>
</template>
<script>
import MovieCard from "../delovi/MovieCard.vue";
export default {
    components:{
        MovieCard
    },
    data(){
        return{
            ids:[],
            films:[],
            watched:{}
        }
    },
    mounted(){
        this.getMyWatchedFilms();
        this.films.sort(this.sortingFilmsByDateWatched);
    },
    methods:{
         getMyWatchedFilms(){
            axios.post('/api/myWatchedFilms',{user: this.$userId.username}).then(res=>{
                this.watched=res.data;
                this.getIds();
                this.ids.forEach(id => {
                    this.getMoviesWithId(id);
                });
            });
        },
        getIds(){
            this.watched.forEach(film=>{
                this.ids.push({id:film.idFilm,date:film.created_at});
            })
        },
         getMoviesWithId(id){
            axios.get('https://imdb-api.com/en/API/Title/pk_3i6onjtnv0nkvost7/'+id.id).then(res=>{
                res.data.date_watched=id.date;
                this.films.push(res.data)
            })
        },
        sortingFilmsByDateWatched(a,b){
            console.log('aaa')
            if (a.date_watched>b.date_watched){
                console.log(a.date_watched>b.date_watched)
                return 1;
            }
            else {
                console.log(a.date_watched, b.date_watched)
                return -1;
            }
        }
    },
    filters:{
        dateFilter: function (value) {
            return moment(value).format("D.M.YYYY")

        }
    }
}
</script>
