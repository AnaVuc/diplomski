<template>
    <div class="bg-gray-700 rounded-md px-14 pt-5 pb-3 main bg-opacity-90" v-if="film" >
        <div class="flex justify-end -m-4 text-gray-300 text-lg " >
            <i class="fas fa-times hover:text-white" @click='hide()'></i>
        </div>
        <div class="mb-3 border-b-2 border-white">
            <span class="text-2xl text-white font-medium">{{film.title}}</span><span class="text-white text-lg pl-4">({{film.year}})</span>
        </div>
        <div class="my-4">
            <textarea class="rounded-xl w-3/4 h-40 border-2 placeholder-gray-300 p-3" v-model="review.reviewText" placeholder="Add a review..."></textarea>
        </div>
        <div class="my-4 flex justify-start items-center mx-3">
            <div class="text-xl  text-white ">
                <span class="text-lg block pt-1">Rating:</span>
                <star-rating  v-model="rating" :increment="0.5" :show-rating="false" :star-size="25"/>
            </div>
            <div class="text-xl  text-white ml-14">
                <span class="text-lg block pl-1">Like</span>
                <i :class="[!heart? 'far fa-heart px-1':'fas fa-heart px-1']" class="transform hover:scale-125 pt-2" @click="change('heart')"></i>
            </div>
        </div>
        <div class="flex justify-end">
            <button class="btn bg-gray-300 hover:bg-red-400 text-white mx-2" @click="deleteReview()">Delete</button>
            <button class="btn bg-blue-300 hover:bg-blue-400 text-white ml-2" @click="saveReview()">Save</button>
        </div>
    </div>
</template>
<script>
import StarRating from 'vue-star-rating'

export default {
    components:{
        StarRating
    },
    data(){
        return {
            film:{},
            review:{},
            heart:false,
            rating:null,
            id:null,
            review:{},
            logged_user:null
        }
    },
    mounted(){
        this.film=this.$attrs.film
        this.id=this.$attrs.id
        if (this.$attrs.review){
            this.review=this.$attrs.review;
            this.check();
        }
        if (this.$attrs.star) this.rating = this.$attrs.star
        if (this.$attrs.like) this.heart = this.$attrs.like
        this.logged_user=this.$userId;
    },
    methods:{
        check(){
            axios.post('/api/reviewHasLike',{reviewId:this.review.id}).then(res=>{
                if (res.data.length!=0){
                    this.heart=true;
                }
            });

            axios.post('/api/reviewHasRating',{reviewId:this.review.id}).then(res=>{
                if (res.data.length!=0){
                    this.rating=res.data.pop();
                    this.rating=this.rating.rating
                    console.log(res.data)
                }
            });
        },
        hide(){
            this.$modal.hide('ReviewModal')
        },
        change(param){
            if (param=="heart"){
                this.heart= !this.heart;
            }
        },
        saveReview(){
            if (!this.$attrs.review){
                axios.post('/api/saveReview',{reviewText:this.review.reviewText, like:this.heart,rating:this.rating,idFilm:this.id,idUser:this.$userId.username,filmTitle:this.film.title}).then();
                window.Event.$emit('reload-filmComponent',true);
                this.hide();
            }
            else {
                axios.post('/api/updateReview',{reviewText:this.review.reviewText, like:this.heart,rating:this.rating,idFilm:this.id,idUser:this.$userId.username,filmTitle:this.film.title}).then(res=>{
                    this.hide()
                    window.Event.$emit('changed-like',this.heart);
                    window.Event.$emit('changed-rating',this.rating);

                 }
                );
            }
        },
        //TODO
        deleteReview(){
            axios.post('/api/deleteReview',{idFilm:this.id,idUser:this.$userId.username}).then(res=>{
                this.hide();
                //TODO mozda ne mora da bude false, ako su van review-a ocenili ili lajkovali, proveri na kraju
                window.Event.$emit('changed-like',false);
                window.Event.$emit('changed-rating',false);
            });
        }
    }


}
</script>
<style>
.vm--container{
    z-index: 1100 !important;
};

.vm--overlay { background-color: rgba(0, 0, 0, 0) !important; }
</style>
