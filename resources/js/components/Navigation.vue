<template>
    <nav  class="flex justify-between items-center  w-screen h-20 " v-if="flag">
        <div class="flex justify-center">
            <div class="m-4 text-white font-semibold text-2xl">
                <router-link to="/">
                    <i class="fas fa-film"></i>
                </router-link>
            </div>
            <div class="m-2 flex justify-center">
                <div class="m-2 my-auto text-white font-medium text-lg p-2 hover:bg-blue-300 rounded-md" >
                    <router-link to="/browse-movies" class="hover:text-white">
                        <span class="inline-block">Browse Movies</span>
                    </router-link>
                </div>
                 <!-- v-if="$userHasPermission('Approve review')" -->
                <div v-if="$userHasPermission('Approve review')"
                    class="m-2 my-auto text-white font-medium text-lg p-2 hover:bg-blue-300 rounded-md"
                >
                    <router-link to="/reviews" class="hover:text-white">
                        <span class="inline-block">Reviews</span>
                    </router-link>
                </div>
                <div  class="m-2 my-auto text-white font-medium text-lg p-2 hover:bg-blue-300 rounded-md" v-if="logged_user && logged_user.role_id!=2">
                    <div class="flex justify-evenly " v-if="logged_user.role_id!=1">
                        <router-link to="/user" class="hover:no-underline">
                            <div class="rounded-full text-lg mr-3 text-white ">
                                <i class="far fa-user"></i>
                              {{logged_user.username}}
                            </div>
                        </router-link>
                    </div>
                    <div class="flex justify-evenly" v-else-if="logged_user.role_id==1">
                        <router-link to="/admin" class="hover:no-underline">
                            <div class="rounded-full text-lg mr-2 text-white">
                                <i class="fas fa-wrench"></i>
                                Admin
                            </div>
                        </router-link>
                    </div>

                </div>
                <div class="flex justify-center my-auto"  v-if="!logged_user" >
                    <a href="/login">
                        <button
                            class="bg-blue-300 m-2 text-white font-bold py-1 px-4 rounded"
                        >
                            Log In
                        </button>
                    </a>
                    <a href="/register">
                        <button
                            class="bg-blue-300 m-2 text-white font-bold py-1 px-4 rounded"
                        >
                            Register
                        </button>
                    </a>
                </div>
                <div v-else class="my-auto">
                  <!-- <a href="/logout"> -->
                        <button
                            class="bg-blue-700 m-2 text-white font-bold py-1 px-4 rounded" @click="logout"
                        >
                            Log Out
                        </button>
                    <!-- </a> -->
                </div>

            </div>
        </div>
        <div class="flex justify-center">
            <div class="m-3 flex items-center">
                <input
                    type="text"
                    class="border-2 border-gray-300 bg-white h-8 px-4 pr-10 rounded-lg text-sm focus:outline-none"
                    placeholder="Search"
                    v-model="search"
                    @keyup.enter="searchFilms()"
                />
                <button class="bg-blue-700 m-2 text-white font-bold py-1 px-4 rounded" @click="searchFilms()">
                    Search
                </button>
            </div>
        </div>
    </nav>
</template>
<script>
import router from '../router/index';

export default {
    components:{
        router
    },
    data() {
        return {
            search: "",
            logged_user:null,
            flag:false,
            permissions:[]
        };
    },
    mounted(){
    this.logged_user=this.$userId;
      this.flag=true;
    },
    methods: {
        searchFilms() {
            let string=this.search;
            this.search=null;
            if (this.$router.currentRoute.path!='/browse-movies'){
                router.push({ path: `browse-movies/${string}`});
            }
        },
        logout(){
            axios.post('http://localhost/logout').then(response => {
                location.reload();
            })
            .catch(error => {
                console.log(error);
            });
        }
    }
};
</script>
