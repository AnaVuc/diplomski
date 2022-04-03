<template>
    <div class="w-5/6 mx-auto">
            <Tabs v-model="CurrentView" :values="TabsValues" :nonclikcable='false'></Tabs>
            <AdminUsers v-if="CurrentView=='AdminUsers'"></AdminUsers>
            <AdminRoles v-if="CurrentView=='AdminRoles'"></AdminRoles>
        </div>
</template>
<script>
import Tabs from '../delovi/Tabs.vue';
import AdminUsers from '../admin/AdminUsers.vue';
import AdminRoles from '../admin/AdminRoles.vue';

export default {
    components:{
        Tabs,AdminUsers,AdminRoles
    },
    data(){
        return {
            TabsValues: [
                {name:'Users',component:'AdminUsers'},
                {name:'Roles',component:'AdminRoles'},
            ],
            CurrentView: 'AdminRoles',
        }
    }
}
</script>
