<template>
    <div class="w-screen p-20">
        <div class="text-3xl font-bold text-white border-b-2 border-collapse"> List of reviews:</div>
        <div class="mt-10">
            <div v-for="review in reviews" :key="review.filmTitle" class="py-3 border-b-2 text-white">
                <div class="font-semibold text-xl">
                    {{review.filmTitle}}
                </div>
                <div class="font-light flex justify-between mx-auto pr-10">
                    <div>
                        <span class="italic">Review by:</span> <span class="font-semibold"> {{review.idUser}}</span>
                    </div>
                    <div class="">
                        <button class="bg-green-400 px-4 py-2 rounded-full text-white font-bold mr-3 hover:bg-green-600" @click="accept(review.id)">Accept</button>
                        <button class="bg-red-400 px-4 py-2 rounded-full text-white font-bold hover:bg-red-600" @click="reject(review)">Reject</button>
                    </div>
                </div>
                <p class="pt-1 text-lg">{{review.reviewText}}</p>

            </div>
        </div>

    </div>

</template>

<script>

export default {
    data(){
        return{
            reviews:[]
        }
    },
    mounted(){
        this.getReviews();
    },
    methods:{
        getReviews(){
            axios.get('/api/getReviewsForModerator').then(res=>{
                this.reviews=res.data;
            })
        },
        accept(reviewId){
            axios.post('/api/acceptReview',{id:reviewId}).then(res=>{
                this.getReviews();
            })
        },
        reject(review){
            this.$swal({
                title: '<strong>Are you sure you want to delete this review?</strong>',
                text: 'You are removing this review permanently.',
                icon: 'question',
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText:
                    '<i class="far fa-2 fa-check-circle"></i> Yes!',
                confirmButtonAriaLabel: 'Yes!',
                cancelButtonText:
                    '<i class="far fa-2 fa-times-circle"></i> No!',
                cancelButtonAriaLabel: 'Thumbs down',
                }).then((result) => {
                    if (result.value) {
                        axios.post('/api/deleteReview',{idFilm:review.idFilm,idUser:review.idUser})
                            .then((res) => {
                                this.reviews = this.reviews.filter((item)=>{
                                    return item.id!=review.id;
                                });
                                this.$swal(
                                    'Deleted!',
                                    'Review removed.',
                                    'success'
                                )
                            }).catch((res) => {
                                this.$swal(
                                    'Ooops!',
                                    'Something went wrong please try again.',
                                    'error'
                                )
                            });
                    }
            });
        }
    }
}
</script>
