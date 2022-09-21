<template>
    <div>
        <!-- <img
        :src="image" class="w-60 h-8 rounded-sm"> -->
        <a href="http://localhost/film/" class="group">
            <div class="relative z-0 w-full aspect-w-1 aspect-h-1  rounded-lg overflow-hidden xl:aspect-w-7 xl:aspect-h-8">
                <img :src="image" :alt="title" :class="size? size:'w-64 h-96'" class="transition duration-100 ease-in-out transform hover:-translate-y-1 hover:scale-125 rounded-sm object-center object-cover group-hover:opacity-25 ">
                <div class="absolute inset-0 flex justify-center items-center z-10 opacity-0 group-hover:opacity-100" v-if="!noStats">
                    <div class="text-5xl block text-gray-600 ">
                        <div class="py-3 text-white">
                            <i class="fas fa-eye text-white align-middle"></i>
                            <span class="font-medium text-xl my-1">{{watched}}</span>

                        </div>
                        <div class="py-3 text-white">
                            <i class="fas fa-heart align-middle"></i>
                            <span class="font-medium  text-2xl ">{{liked}}</span>

                        </div>
                        <div class="py-4 text-white" >
                            <i class="fas fa-star align-middle"></i>
                            <span class="font-medium  text-2xl ">{{rating}}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="font-medium text-xl text-white">{{title}}</div>
            <div class="font-normal text-base  text-white">{{year}}</div>
      </a>
    </div>
</template>
<script>
export default {
    props:['image','title','year','watched','liked','rating','size','noStats'],
    methods:{
        mounted(){
        }
    }

}
</script>
<style>
.slide-fade-enter-active {
  transition: all .3s ease;
}
.slide-fade-leave-active {
  transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.slide-fade-enter, .slide-fade-leave-to
/* .slide-fade-leave-active below version 2.1.8 */ {
  transform: translateX(10px);
  opacity: 0;
}
</style>
