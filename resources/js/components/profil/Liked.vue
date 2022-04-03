<template>
    <div class="text-white">
        <div class="p-5">
            <div class="grid grid-flow-row grid-flow-col gap-4">
                <div v-for="movie in movies" :key="movie.id">
                    <router-link :to="{ path:`film/${movie.id}`}">
                        <div>
                            <img :src="movie.image" class="h-80 object-contain  rounded-md hover:border-blue-300">
                            <span class="pr-2 text-lg underline flex-wrap">{{movie.fullTitle}}</span>
                        </div>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            ids:[],
            movies:[]
        }
    },
    mounted(){
        this.getMovies();
    },
    methods:{
        getMovies(){
            axios.post('/api/myLikedFilms',{user:this.$userId.username}).then(res=>{
                this.ids=res.data;
                this.ids.forEach(id => {
                    axios.get('https://imdb-api.com/en/API/Title/pk_3i6onjtnv0nkvost7/'+id).then(res=>{
                        this.movies.push(res.data)
                    })

                });
            })
        }
    }
}
</script>
