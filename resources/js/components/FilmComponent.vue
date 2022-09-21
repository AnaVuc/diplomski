<template>
    <div class="w-10/12 mx-auto  flex py-5" v-show="flag">
        <div class="block w-1/4 px-10 ">
            <img class="rounded-md  bg-contain" :src="film.image">
            <div class="block pt-2">
                <div v-if="$userHasPermission('Rate film') && $userHasPermission('Mark film as watched') && $userHasPermission('Mark film as liked')">
                    <div class="flex justify-evenly items-center my-2 bg-blue-300 p-2 rounded-2xl">
                        <div class="text-xl text-white block ">
                            <i :class="[watch? 'fas fa-eye px-1':'far fa-eye px-1']" class="transform hover:scale-125" @click="change('watch')"></i>
                            <span class="text-base block">Watch</span>
                        </div>
                        <div class="text-xl  text-white block">
                            <i :class="[!heart? 'far fa-heart px-1':'fas fa-heart px-1']" class="transform hover:scale-125" @click="change('heart')"></i>
                            <span class="text-base block pl-1">Like</span>
                        </div>
                    </div>
                    <div class="flex justify-center items-center bg-gray-600 p-2 rounded-2xl">
                        <div class="text-xl  text-white ">
                            <star-rating  v-model="rating" :increment="0.5" :show-rating="false" :star-size="30" @rating-selected="changeRating()"/>
                            <span class="text-lg block text-center pt-2">Rate</span>
                        </div>
                    </div>
                    <div class="flex justify-center items-center bg-blue-300 my-2 rounded-2xl hover:bg-blue-400" @click="openModal()">
                        <button  >
                            <div class="text-xl  text-white flex justify-center  px-3 py-2">
                                <span class="text-xl font-normal">Add a review...</span>
                            </div>
                        </button>

                    </div>

                </div>
                <div v-else>
                    <div class="text-xl text-white block ">
                        <span class="text-base block">Sign in to log, rate or review</span>
                    </div>
                </div>

                <div class="py-3 rounded-4xl">
                    <div class="text-4xl flex justify-evenly items-center">
                        <div class="block justify-items-center">
                            <i class="fas fa-eye text-blue-500 block "></i>
                            <span class="font-medium text-white text-2xl block px-2.5">{{countViews}}</span>

                        </div>
                        <div class="block">
                            <i class="fas fa-heart text-red-500 block"></i>
                            <span class="font-medium text-white text-2xl block px-2.5">{{countLikes}}</span>

                        </div>
                        <div class="block">
                            <i class="fas fa-star text-yellow-600 block"></i>
                            <span class="font-medium text-white text-2xl block px-2.5">{{averageRating}}</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="w-2/3 ml-10 mr-40">
            <div class="inline">
                <div class="text-3xl font-medium text-white pb-2 border-b-2">
                    {{film.title}}
                </div>

            </div>

            <div class="text-lg  inline text-white font-light mt-4">
                {{film.genres}}
            </div>
            <div class="my-3">
                <p class="text-base text-white text-justify">{{film.plot}}</p>
            </div>
            <div class="text-lg text-blue-200 font-semibold ">
                Cast:
            </div>
            <div class="my-3 flex flex-wrap">
                <div class=" bg-gray-600  px-2 py-2 shadow-md m-1 rounded-xl" v-for="(actor,key) in actors" :key="key">

                    <div class="tooltip">
                        <p class="text-sm text-gray-200"> {{actor.name}}</p>
                        <span class="tooltiptext text-sm">{{actor.asCharacter}}</span>
                    </div>
                </div>
            </div>
            <div class="text-base text-blue-200 font-semibold ">
                <i class="fas fa-clock"></i> {{film.runningTime}}
            </div>

            <div class="mt-6 border-b-2 border-white">
                <span class="text-lg text-white font-semibold mx-3 mb-2">Reviews:</span>
            </div>
            <div class="" v-if="Array.isArray(reviews) && reviews.length">
                <div v-for="review in reviews" :key="review.user">
                    <div class="border-b-2 border-blue-300 p-3">
                        <div class="flex">
                            <span class="font-light text-gray-300 pr-2">Review by </span><span class="font-semibold text-white pr-4">{{review.idUser}}</span>
                            <star-rating v-if="review.rating!=null" class="flex" :read-only='true' :rating="review.rating.rating" :increment="0.5" :show-rating="false" :star-size="15" active-color="#93c4fd" :star-points="[23,2, 14,17, 0,19, 10,34, 7,50, 23,43, 38,50, 36,34, 46,19, 31,17]"/>
                        </div>
                        <p class="text-gray-100 text-opacity-90 font-medium text-base py-2 ">{{review.reviewText}}</p>
                    </div>
                </div>
                <div class="flex justify-start my-4">
                    <div class="btn bg-blue-300 hover:bg-blue-400" @click="moreReviews" v-if="reviews.length>5">View more</div>
                </div>
            </div>
            <div v-else>
                <div class="text-white text-lg flex justify-center py-8"> There are no reviews for this movie</div>
            </div>


        </div>


    </div>
</template>
<script>
import ReviewModal from '../components/delovi/ReviewModal.vue'
import StarRating from 'vue-star-rating'

export default {
    components:{
        StarRating
    },
    watch:{
        averageRating(value){
            this.averageRating=value;
        }
    },
    data() {
        return {
            film: {},
            flag: false,
            actors: [],
            averageRating:0,
            countViews:0,
            countLikes:0,
            id:null,
            heart:false,
            watch:false,
            rating:null,
            myReview:null,
            reviews:null,
            numOfReviews:5,
            user:null
        };
    },
    created(){
        window.Event.$on('changed-like',like=>{
            this.heart=like;
        });
        window.Event.$on('changed-rating',rating=>{
            this.rating=rating;
            this.updateAverageRating();
        });
        window.Event.$on('changed-watched',watch=>{
            this.watch=watch;
        });
    },
    mounted() {
        window.Event.$on('film-id',id=>{
            this.id=id;
        });
        this.user=this.$userId;

        this.id=this.$route.params.id;
        this.getFilm();
        this.getReviews();
        this.check();
        this.filmStats();
        window.Event.$on('reload-filmComponent',value=>{
            this.check();
        })
    },
    methods: {
        moreReviews(){
            this.numOfReviews+=5;
            this.getReviews();
        },
        getReviews(){
            axios.post('/api/getReviews',{numberForShowing:this.numOfReviews,idFilm:this.id}).then(res=>{
                this.reviews=res.data.data;
            })

        },
        getRatings(){
            this.reviews.forEach(review=>{
                axios.get('/api/reviewRating',{param:{reviewId:review.id}}).then(res=>{

                })
            })
        },
        changeRating(){
            axios.get('/api/getRating',{params:{idFilm:this.id, idUser:this.$userId.username}}).then(res=>{
                console.log(res.data)
                if (res.data.length==0){
                    console.log("changeRating")
                    this.rateFilm();
                    this.updateAverageRating();
                }
                else{
                    this.updateRating();
                }
            });

        },
        async updateRating(){
            await axios.post('/api/updateRating',{idFilm:this.id, idUser:this.$userId.username, rating:this.rating});
            this.updateAverageRating();
        },
        updateAverageRating(){
            axios.post('/api/calculateFilmRating',{idFilm:this.id}).then(res=>{
                this.averageRating=res.data;
                this.averageRating=Math.round(this.averageRating * 100) / 100
            });
        },
        filmStats(){
            axios.post('/api/countFilmWatched',{idFilm:this.id}).then(res=>{
                this.countViews=res.data;
            });

            axios.post('/api/countFilmLiked',{idFilm:this.id}).then(res=>{
                this.countLikes=res.data;
            });

            axios.post('/api/calculateFilmRating',{idFilm:this.id}).then(res=>{
                if (res.data.length==0){
                    this.averageRating='/'
                }else{
                    this.averageRating=res.data;
                    this.averageRating=Math.round(this.averageRating * 100) / 100

                }
                console.log(res.data.length)
            });


        },
        rateFilm(){
            console.log('rateFilm')
            axios.post('/api/rateFilm',{idFilm:this.id, idUser:this.$userId.username, rating:this.rating}).then(res=>{
            });
            this.updateAverageRating();

        },
        check(){
            var data={
                    "idFilm":this.id,
                    "idUser":this.$userId.username
            };
            axios.post('/api/checkIfLiked',data).then(res=>{
                if (res.data.length!=0){
                    this.heart=true;
                }
            })
            axios.post('/api/checkIfWatched',data).then(res=>{
                if (res.data.length!=0){
                    this.watch=true;
                }
            })
            axios.get('/api/getRating',{params:{idFilm:this.id, idUser:this.$userId.username}}).then(res=>{
                this.rating=res.data.pop();
            })

            axios.post('/api/checkIfReviewed',{idFilm:this.id, idUser:this.$userId.username}).then(res=>{
                if (res.data.length!=0){
                    this.myReview=res.data;
                }
            });
        },
        change(param){
            if (param=="heart"){
                this.likeFilm();
                this.heart= !this.heart;

            }
            if (param=="watch"){
                this.watchFilm();
                this.watch= !this.watch;
            }
        },
        likeFilm(){
            var data={
                "idFilm":this.id,
                "idUser":this.$userId.username
            };
            if (!this.heart){
                console.log(data)
                axios.post('/api/likeFilm',data);
                this.countLikes++;
            }else{
                axios.post('/api/deleteLike',data);
                this.countLikes--;
            }
        },
        watchFilm(){
            var data={
                "idFilm":this.id,
                "idUser":this.$userId.username
            };
            if (!this.watch){
                axios.post('/api/watchFilm',data);
                this.countViews++;
            }else{
                axios.post('/api/deleteWatch',data);
                this.countViews--;
            }
        },
        getFilm() {
            axios.get("https://imdb-api.com/en/API/Title/k_aqki26bs/"+this.id)
                .then(response => {
                    this.film.title=response.data.title;
                    this.film.year=response.data.year;
                    this.film.image=response.data.image;
                    this.film.plot = response.data.plot;
                    this.film.genres = response.data.genres;
                    this.film.runningTime = response.data.runtimeStr;
                    this.actors=response.data.actorList;
                    this.flag=true;

                    console.log(response.data);
                })
                .catch(function(error) {
                    console.error(error);
                });
            this.flag=true;
        },
        openModal(){
            this.$modal.show(ReviewModal, {
                film: this.film,
                id:this.id,
                review:this.myReview,
                star:this.rating,
                like:this.heart
                }, {
                name:'ReviewModal',
                width:'50%',
                height:'auto',
                scrollable: true,
                draggable: false,
                clickToClose:false
                })
        }
    }
};
</script>
<style scoped>
.tooltip {
  position: relative;
  display: flex;
  opacity: 1;
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: max-content;
  background-color: rgb(59, 59, 59);
  color: #fff;
  border-radius: 6px;
  padding: 3px 10px;
  position: absolute;
  z-index: 3 !important;
  bottom: 95%;
  margin-left: 10px;
  font-weight: normal;
  opacity: 1;
  transition: opacity 0.5s;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
  opacity: 1;
}


</style>
