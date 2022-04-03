<template>
<div class="block">
    <div class="flex justify-end">
        <button @click="addUser">
            <div class="flex text-white text-lg bg-blue-700 p-2 rounded-xl">
                <div class="pr-2">Add user</div>
                <i class="fas fa-user-plus mt-1"></i>
            </div>

        </button>
    </div>
    <div class="flex flex-col mx-auto pb-32">
        <div class="overflow-x-auto shadow-md sm:rounded-lg">
            <div class="inline-block min-w-full align-middle dark:bg-gray-800">
                <div class="p-4">
                    <label for="table-search" class="sr-only">Search</label>
                    <div class="relative mt-1">
                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none" >
                            <svg  class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>
                        </div>
                        <input type="text"
                            id="table-search"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Search by username" v-model="search"/>
                    </div>
                </div>
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700 "  >
                        <thead class="bg-gray-100 dark:bg-gray-700 rounded-md">
                            <tr>
                                <th  scope="col"
                                    class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400" >
                                    Username
                                </th>
                                <th scope="col"
                                    class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400"  >
                                    E-mail
                                </th>
                                <th scope="col"
                                    class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400"  >
                                    First Name
                                </th>
                                <th scope="col"
                                    class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400"  >
                                    Last Name
                                </th>
                                <th  scope="col"
                                    class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400"  >
                                    Role
                                </th>
                                <th scope="col" class="p-4">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700"  >
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700"  v-for="user in searchUsers" :key="user.id">
                                <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white" >
                                    {{user.username}}
                                </td>
                                <td class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white"  >
                                    {{user.email}}
                                </td>
                                <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"  >
                                    {{user.firstName}}
                                </td>
                                <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"  >
                                    {{user.lastName}}
                                </td>
                                <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"  >
                                    {{user.role.name}}
                                </td>
                                <td class="py-4  text-sm font-medium  whitespace-nowrap" >
                                    <button class="cursor-pointer px-3" @click="openEditModal(user)">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <button class="cursor-pointer" @click="deleteUser(user.id)">
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
import EditProfile from '../profil/EditProfile.vue';

export default {
    components:{
        EditProfile
    },
    data() {
        return {
            users: [],
            search:null,
            searchUsers:null
        };
    },
    mounted() {
        this.getUsers();
        window.Event.$on('user-updated',value=>{
            this.getUsers();
        });
        window.Event.$on('user-inserted',value=>{
            this.getUsers();
        });
    },
    computed:{
        filtered_users:function(){
            return this.users.filter((user)=>{
                return user.username.toLowerCase().search(this.search.toLowerCase())>=0
            }).sort((x,y)=> x.id - y.id)
        },
    },
    watch:{
        search(){
            this.filterUsers();
        }

    },
    methods: {
        filterUsers(){
            this.searchUsers=this.users.filter((user)=>{
                return user.username.toLowerCase().search(this.search.toLowerCase())>=0
            }).sort((x,y)=> x.id - y.id)
        },
        getUsers() {
            axios.get("/api/getUsers").then(res => {
                this.users = res.data;
                this.searchUsers=res.data

            });
        },
        deleteUser(id){
                this.$swal({
                title: '<strong>Are you sure you want to delete this user?</strong>',
                text: 'You are removing this user permanently.',
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

                        axios.delete('/api/deleteUser',{data:{id:id}}).then(res=>{
                            this.users = this.users.filter((item)=>{
                                return item.id!=id;
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

        },
        openEditModal(user){
            this.$modal.show(EditProfile, {
                user: user,
                editRole:true,
                }, {
                name:'EditProfile',
                width:'50%',
                height:'auto',
                scrollable: true,
                draggable: false,
                clickToClose:false
            })
        },
        addUser(){
            this.$modal.show(EditProfile, {
                new:true,
                user: null,
                editRole:true,
                }, {
                name:'EditProfile',
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
