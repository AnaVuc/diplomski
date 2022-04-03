<template>
    <div class="m-3 flex items-center">
      <input type='text' class="border-2 border-gray-300 bg-white h-8 px-4 pr-10 rounded-lg text-sm focus:outline-none" placeholder="Search" v-model="search" @input='searchFilms'>
      <!-- <div class="block" v-if="results">
          <div v-for="result in results" :key="result.id">
              <div class="border-b-2 text-white h-20 fixed">
                  <img :src="result.image">
              </div>
          </div>
      </div> -->
      <button class="bg-blue-700 m-2 text-white font-bold py-1 px-4 rounded">Search </button>
    </div>
</template>
<script>
export default {
    data(){
        return{
            search:null,
            results:[]
        }
    },
    methods:{

        searchFilms(){
            axios.get("https://imdb-api.com/en/API/SearchMovie/k_295ij2b9/"+this.search).then(res=>{
                this.results=res.data;
            })
        }
    }
}
</script>