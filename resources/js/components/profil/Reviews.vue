<template>
    <div class="mt-10">
        <div v-for="review in reviews" :key="review.filmTitle" class="py-3 border-b-2 text-white">
            <div class="font-semibold text-xl">
                {{review.filmTitle}}
            </div>
            <div class="font-light">
                <span class="italic">Reviewed on:</span> <span> {{review.created_at | dateFilter}}</span>
            </div>
            <div class="flex justify-between w-full">
                <p class=" pt-2 text-lg">{{review.reviewText}}</p>
                <p class=" text-red-500 my-auto italic" v-if="review.approved_at==null"> * Waiting for approval</p>

            </div>

        </div>
    </div>
</template>
<script>

export default {
    data(){
        return{

            reviews:[],
            logged_user:null
        }
    },
    mounted(){
        this.logged_user=this.$userId;
        this.getReviewsForUser();
    },
    methods:{
        getReviewsForUser(){
            axios.post('/api/reviewsForUser',{user:this.$userId.username}).then(res=>{
                this.reviews=res.data;
            })
        }
    },
    filters: {
        dateFilter: function (value) {
            return moment(value).format("D.M.YYYY")

        }
}
}
</script>
