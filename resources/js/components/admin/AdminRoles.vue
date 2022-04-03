<template>
<div class="block">
    <div class="flex justify-end">
        <button @click="addRole">
            <div class="flex text-white text-lg  p-2 rounded-xl bg-blue-700">
                <div class="pr-2">Add role</div>
                <i class="fas fa-user-plus mt-1"></i>
            </div>

        </button>
    </div>
    <div class="flex flex-col mx-auto pb-32 pt-10">
        <div class="overflow-x-auto shadow-md sm:rounded-lg">
            <div class="inline-block min-w-full align-middle dark:bg-gray-800">
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700 "  >
                        <thead class="bg-gray-100 dark:bg-gray-700 rounded-md">
                            <tr>
                                <th  scope="col"
                                    class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400" >
                                    Name
                                </th>
                                <th scope="col"
                                    class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400"  >
                                    Number of permissions
                                </th>
                                <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400" >
                                    Edit permission
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700"  >
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700"  v-for="role in roles" :key="role.id">
                                <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white" >
                                    {{role.name}}
                                </td>
                                <td class="py-4 px-3 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white"  >
                                    {{role.permissions.length}}
                                </td>
                                <td class="py-4  text-sm font-medium  whitespace-nowrap" >
                                    <button class="cursor-pointer px-3" @click="openEditModal(role)">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <button class="cursor-pointer" @click="deleteRole(role.id)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
</template>
<script>
import EditRoleModal from '../admin/EditRoleModal.vue';

export default {
    components:{
        EditRoleModal
    },
    data(){
        return {
            roles:[]
        }
    },
    mounted(){
        this.getRoles();
        window.Event.$on('role-updated',value=>{
            this.getRoles();
        });
        window.Event.$on('role-inserted',value=>{
            this.getRoles();
        });
    },
    methods:{
        getRoles(){
            axios.get('/api/getRoles').then(res=>{
                this.roles=res.data;
            })
        },
        openEditModal(role){
            this.$modal.show(EditRoleModal, {
                role: role,
                new:false,
                }, {
                name:'EditRoleModal',
                width:'30%',
                height:'auto',
                scrollable: true,
                draggable: false,
                clickToClose:false
            })
        },
        deleteRole(id){
            this.$swal({
                title: '<strong>Are you sure you want to delete this role?</strong>',
                text: 'You are removing this role permanently.',
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

                        axios.delete('/api/deleteRole',{data:{id:id}}).then(res=>{
                            this.roles = this.roles.filter((item)=>{
                                return item.id!=id;
                            });
                            this.$swal(
                                'Deleted!',
                                'Role removed.',
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
        },
        addRole(){
            this.$modal.show(EditRoleModal, {
                role: null,
                new:true,
                }, {
                name:'EditRoleModal',
                width:'30%',
                height:'auto',
                scrollable: true,
                draggable: false,
                clickToClose:false
            })
        }
    }
}
</script>
