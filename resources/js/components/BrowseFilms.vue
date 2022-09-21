<template>
    <div class="m-8 w-4/5 py-10 mx-auto">
        <div class="px-5 ">
            <span class="text-gray-300 text-3xl font-medium">
                Search:
            </span>
            <div class="items-center">
                <input
                    class="my-3 rounded-sm bg-gray-400 w-4/5 p-2"
                    type="text"
                    v-model="search"
                />
                <button
                    class="text-2xl text-white font-semibold bg-blue-300 rounded-md px-4 py-1 mx-4 justify-end"
                    @click="getFilms"
                >
                    Search
                </button>
            </div>
        </div>
        <div class=" flex justify-around w-4/5 pb-20">
            <div class="">
                <span class="text-gray-300 text-lg font-light">Genres:</span>
                <vSelect
                    class="style-chooser w-1/3"
                    :options="optionsForGenre"
                    :reduce="genre => genre.value"
                    :label="'text'"
                    v-model="genre"
                    :multiple="true"
                >
                </vSelect>
            </div>
            <div class="">
                <span class="text-gray-300 text-lg font-light"
                    >IMDB Rating:</span
                >
                <vSelect
                    class="style-chooser"
                    :options="[1, 2, 3, 4, 5, 6, 7, 8, 9, 10]"
                    placeholder="All"
                    v-model="rating"
                ></vSelect>
            </div>
            <div class="">
                <span class="text-gray-300 text-lg font-light">Order By:</span>
                <vSelect
                    class="style-chooser"
                    :options="optionsForOrderBy"
                    :reduce="option => option.value"
                    :label="'text'"
                    placeholder="Latest"
                    v-model="orderBy"
                ></vSelect>
            </div>
        </div>
        <div class="flex px-10" v-if="loaded">
            <div class="grid grid-cols-5  gap-3">
                <div v-for="film in films" :key="film.id">
                    <router-link :to="{ path: `/film/${film.id}` }">
                        <movie-card
                            :size="'w-60 h-80'"
                            :image="film.image"
                            :title="film.title"
                            :year="film.description"
                            :id="film.id"
                            :noStats="true"
                        >
                        </movie-card>
                    </router-link>
                </div>
            </div>
        </div>
        <div v-else class="flex justify-center">
            <Spinner></Spinner>
        </div>
        <div class="bg-blue-300 flex justify-center mx-auto my-5 w-1/5 rounded-xl">
            <nav class="relative z-0 inline-flex -space-x-px" aria-label="Pagination">
                <button href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md text-sm font-medium text-white hover:text-blue-500" :class="current_page==1 ? 'cursor-not-allowed' : ''" :disabled="start_slice==0 " @click="changePage(-25)">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                </button>
                <a href="#" class="text-white relative inline-flex items-center px-3 py-2 text-sm font-medium hover:text-blue-500" v-if="current_page!=1" @click="changePage(-25)">
                {{current_page-1}}
                </a>
                <a href="#" aria-current="page" class="z-10 text-indigo-600 relative inline-flex items-center px-3 py-2 text-sm font-bold">
                {{current_page}}
                </a>
                <a href="#" class="text-white relative inline-flex items-center px-3 py-2 text-sm font-medium hover:text-blue-500" v-if="current_page!=10 || films.length<25" @click="changePage(25)">
                {{current_page+1}}
                </a>
                <button href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md text-sm font-medium text-white hover:text-blue-500" :class="current_page==10 ? 'cursor-not-allowed' : ''" :disabled="current_page==10" @click="changePage(25)">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
                </button>
            </nav>
        </div>
    </div>
</template>
<script>
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import MovieCard from "../components/delovi/MovieCard.vue";
import Multiselect from "vue-multiselect";

export default {
    components: {
        vSelect,
        MovieCard,
        Multiselect
    },
    // props:['searchText'],
    data() {
        return {
            films: [],
            allFilms:[],
            genre: null,
            rating: null,
            orderBy: "Popularity",
            loaded: false,
            search: "",
            current_page:1,
            start_slice:0,
            end_slice:25,
            optionsForGenre: [
                { text: "Action", value: "action" },
                { text: "Adventure", value: "adventure" },
                { text: "Animation", value: "animation" },
                { text: "Comedy", value: "comedy" },
                { text: "Crime", value: "crime" },
                { text: "Documentary", value: "documentary" },
                { text: "Drama", value: "drama" },
                { text: "Family", value: "family" },
                { text: "Fantasy", value: "fantasy" },
                { text: "Film-Noir", value: "film_noir" },
                { text: "History", value: "history" },
                { text: "Horror", value: "horror" },
                { text: "Musical", value: "musical" },
                { text: "Mystery", value: "mystery" },
                { text: "Romance", value: "romance" },
                { text: "Sci-Fi", value: "sci_fi" },
                { text: "Sport", value: "sport" },
                { text: "Thriller", value: "thriller" },
                { text: "War", value: "war" },
                { text: "Western", value: "western" }
            ],
            optionsForOrderBy: [
                { text: "Year Descending", value: "year,desc" },
                { text: "Year Ascending", value: "year,asc" },
                { text: "Rating Descending", value: "user_rating,desc" },
                { text: "Rating Ascending", value: "user_rating,asc" },
                { text: "Popularity", value: "moviemeter,asc" }
            ],
            advancedSearchUrl:
                "https://imdb-api.com/API/AdvancedSearch/k_aqki26bs7?title_type=feature",
            isTyping: false
        };
    },
    created(){

    },
    mounted() {
        if (this.$route.params.search){
            this.search=this.$route.params.search;
            this.searchFilm();
        }else{

            this.getFilms();
        }
    },
    methods: {
        getFilms() {
            this.makeUrl();
            axios.get(this.advancedSearchUrl).then(res => {
                this.allFilms=res.data.results;
                this.getFilmsForPage();
                this.loaded = true;
            });
        },
        searchFilm() {
            console.log('searchFilm');
            axios
                .get(
                    "https://imdb-api.com/en/API/SearchMovie/k_aqki26bs/" +
                        this.search
                )
                .then(res => {
                    this.allFilms = res.data.results;
                    this.getFilmsForPage();
                    this.loaded = true;
                });
        },
        makeUrl() {
            this.advancedSearchUrl =
                "https://imdb-api.com/API/AdvancedSearch/k_aqki26bs?title_type=feature&count=250";
            this.concatForURL("genres", this.genre);
            this.concatForURL("user_rating", this.rating);
            this.concatForURL("title", this.search);
            this.concatForURL("sort", this.orderBy);
        },
        concatForURL(param, values) {
            if (values != null && values != "") {
                this.advancedSearchUrl = this.advancedSearchUrl.concat("&",param,"=",values);
                console.log(this.advancedSearchUrl);
            }
        },
        changePage(num){
            if (num==25){
                this.start_slice+=25;
                this.end_slice+=25;
                this.current_page++;
                this.getFilmsForPage();
            }else{
                this.start_slice-=25;
                this.end_slice-=25;
                this.current_page--;
                this.getFilmsForPage();
            }
        },
        getFilmsForPage(){
            this.films = this.allFilms.slice(this.start_slice, this.end_slice);
        }
    }
};
</script>
<style>
.style-chooser .vs__search::placeholder,
.style-chooser .vs__dropdown-toggle,
.style-chooser .vs__dropdown-menu {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background: rgb(156 163 175);
    border: none;
    color: #394066;
    text-transform: lowercase;
    font-variant: small-caps;
    width: auto;
    padding: 0.25rem;
    line-height: 1.25;
    min-width: 200px;
}

/* .style-chooser .vs__clear,
.style-chooser .vs__open-indicator {
  fill: #394066;
  width: 100%;

} */
.form-group {
    width: 50%;
    padding: 1rem;
}

.form-group-select {
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    /* border-width: 1px; */
    border-radius: 0.25rem;
    width: 100%;
    padding: 0.25rem;
    --text-opacity: 1;
    color: #4a5568;
    color: rgba(74, 85, 104, var(--text-opacity));
    line-height: 1.25;
}
</style>
