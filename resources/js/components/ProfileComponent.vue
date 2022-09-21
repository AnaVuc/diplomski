<template>
<div class="w-screen pt-20">
    <div class="py-10  ml-28 w-4/5">
        <div class=" bg-gray-400 p-3 rounded-md block">
            <div class="flex justify-between mx-3">
                <div class="text-xl text-white font-semibold pt-2">
                    {{$userId.username}}
                </div>
                <button class="btn btn-md ml-5 hover:bg-blue-300" @click="openModal()">Edit profile</button>
            </div>
        </div>
        <div class="credit-application-container">
            <Tabs v-model="CurrentView" :values="TabsValues" :nonclikcable='false'></Tabs>
            <Watched v-if="CurrentView=='Watched'"></Watched>
            <Liked v-if="CurrentView=='Liked'"></Liked>
            <Reviews v-if="CurrentView=='Reviews'"></Reviews>
        </div>
    </div>

</div>
</template>
<script>
import Tabs from '../components/delovi/Tabs.vue';
import Watched from '../components/profil/Watched.vue';
import Liked from '../components/profil/Liked.vue';
import Reviews from '../components/profil/Reviews.vue';
import EditProfile from '../components/profil/EditProfile.vue';

export default{
    components:{
        Tabs,Watched,Liked,Reviews
    },
    data(){
        return{
            TabsValues: [
                {name:'Watched',component:'Watched'},
                {name:'Liked',component:'Liked'},
                {name:'Reviews',component:'Reviews'},
            ],
            CurrentView: 'Watched',
            user:{}

        }
    },
    methods:{
        openModal(){
            axios.get('/api/userByUsername',{params:{
                username:this.$userId.id
            }} ).then(res=>{
                this.user=res.data;
                this.$modal.show(EditProfile, {
                    user: this.user,
                    editRole:false,
                    }, {
                    name:'EditProfile',
                    width:'50%',
                    height:'auto',
                    scrollable: true,
                    draggable: false,
                    clickToClose:false
                })
            })
        }
    }
}
</script>
<style >
.credit-application-container {
  margin-top: 2.5rem;
}

.credit-application-tab-content {
  width: 100%;
  padding-top: 0.5rem;
}
</style>
