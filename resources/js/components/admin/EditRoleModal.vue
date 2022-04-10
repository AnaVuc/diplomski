<template>
    <div class="p-10 block rounded-md bg-gray-700">
        <p class="font-semibold text-6xl flex justify-center border-b-4 border-blue-300 text-white">Edit role</p>
        <div class="block ">
            <div class="form-group mx-auto">
                <label class ="form-group-label text-white" for="">Name: </label>
                <input type="text" spellcheck="false" @keydown="delete errors.name" v-model="role.name"  class="form-group-input bg-gray-300" placeholder="Enter Name">
                <span v-if="errors" class="text-red-700 pl-1 text-sm" role="alert">
                    <strong>{{errors.name?errors.name:''}}</strong>
                </span>
            </div>
            <label class="form-group-label text-white text-center">Permissions:</label>
            <div class="justify-center grid grid-cols-2 gap-1 mx-10 px-2">
                <div
                  name="operater"
                  id="operater"
                  v-for="permission in permissions" :key="permission.id"
                  class=" text-white "
                >
                  <input type="checkbox" :value="permission.id" v-model="checkedPermissions">
                  <label>{{permission.rule}}</label>
                </div>
                <span v-if="errors" class="text-red-700 pl-1 text-sm" role="alert">
                    <strong>{{errors.permissions?errors.permissions:''}}</strong>
                </span>
            </div>
        </div>
        <div class="flex justify-evenly">
            <div class="btn  bg-red-300 hover:bg-red-500 hover:text-white" @click="hide">Cancel</div>
            <div class="btn  bg-blue-300 border-blue-400 hover:bg-blue-600 hover:text-white" @click="submit">Submit</div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            role:{
                name:null
            },
            permissions:{
            },
            checkedPermissions:[],
            errors:{
                name:false,
                permissions:false
            }
        }
    },
    mounted(){
        if (!this.$attrs.new){
            this.role=this.$attrs.role;
            this.permissionsForRole();
        }
        this.getPermissions();
    },
    methods:{
        permissionsForRole(){
            this.checkedPermissions=this.role.permissions.map(permission=> permission.id)
        },
        getPermissions(){
            axios.get('/api/getPermissions').then(res=>{
                this.permissions=res.data;
            })
        },
        submit(){
            //if role is passed to modal update it
            if (!this.$attrs.new){
                axios.post('/api/updateRole',{name:this.role.name,permission_ids:this.checkedPermissions,id:this.role.id}).then(res=>{

                    this.$swal({
                    title: '<strong>You updated a role successfully</strong>',
                    icon: 'success',
                    showConfirmButton:false,
                    timer:3000,
                    });
                    window.Event.$emit('role-updated',true);
                this.hide();

                }).catch(error=>{
                    this.errors= error.response.data.errors;
                    for (const [key, value] of Object.entries(this.errors)){
                        console.log(key)
                        this.errors[key]=this.errors[key].toString();
                    }
                })
            //if role is not passed- create it
            }else{
                axios.post('/api/createRole',{name:this.role.name,permission_ids:this.checkedPermissions}).then(res=>{

                window.Event.$emit('role-inserted',true);
                this.hide();

                }).catch(error=>{
                    this.errors= error.response.data.errors;
                    for (const [key, value] of Object.entries(this.errors)){
                        console.log(key)
                        this.errors[key]=this.errors[key].toString();
                    }
                })
            }
        },
        hide(){
            this.$modal.hide('EditRoleModal');
        }
    }
}
</script>
