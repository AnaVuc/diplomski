<template>
    <div class="p-10 block rounded-md bg-gray-700">
        <p class="font-semibold text-6xl flex justify-center border-b-4 border-blue-300 text-white">Edit profile</p>
        <div :class="!editRole? 'flex w-full':'flex justify-evenly'">
            <div :class="!editRole? 'mx-3 w-full py-2':'form-group mx-auto'">
                <label class ="form-group-label text-white" for="">Username: </label>
                <input type="text" spellcheck="false" @keydown="delete errors.username" v-model="user.username"  class="form-group-input bg-gray-300" placeholder="Enter Username">
                <span v-if="errors" class="text-red-700 pl-1 text-sm" role="alert">
                    <strong>{{errors.username?errors.username:''}}</strong>
                </span>
            </div>
            <div class="form-group mx-auto" v-if="editRole">
                <label class="form-group-label text-white">Role:</label>
                <select
                  name="operater"
                  id="operater"
                  v-model="user.role_id"
                  class="form-group-input bg-gray-300"
                >
                  <option
                    v-for="role in roles" :key="role.id"
                    v-bind:value="role.id"
                  >
                    {{ role.name }}
                  </option>
                </select>
                <span v-if="errors" class="text-red-700 pl-1 text-sm" role="alert">
                    <strong>{{errors.role_id?errors.role_id:''}}</strong>
                </span>
            </div>
        </div>
        <div class="flex w-full">
            <div class="mx-3 w-full">
                <label class ="form-group-label text-white" for="">Email: </label>
                <input type="text" spellcheck="false" @keydown="delete errors.email" v-model="user.email"  class="form-group-input bg-gray-300" placeholder="Enter Email">
                <span v-if="errors" class="text-red-700 pl-1 text-sm" role="alert">
                    <strong>{{errors.email?errors.email:''}}</strong>
                </span>
            </div>
        </div>
        <div class="flex justify-evenly">
            <div class="form-group mx-auto">
                <label class ="form-group-label text-white" for="">First name: </label>
                <input type="text" spellcheck="false" @keydown="delete errors.firstName" v-model="user.firstName"  class="form-group-input bg-gray-300" placeholder="Enter First Name">
                <span v-if="errors" class="text-red-700 pl-1 text-sm" role="alert">
                    <strong>{{errors.firstName?errors.firstName:''}}</strong>
                </span>
            </div>
            <div class="form-group mx-auto">
                <label class ="form-group-label text-white" for="">Last name: </label>
                <input type="text" spellcheck="false" @keydown="delete errors.lastName" v-model="user.lastName"  class="form-group-input bg-gray-300" placeholder="Enter Last Name">
                <span v-if="errors" class="text-red-700 pl-1 text-sm" role="alert">
                    <strong>{{errors.lastName?errors.lastName:''}}</strong>
                </span>
            </div>
        </div>
        <div class="flex justify-evenly">
            <div class="form-group mx-auto">
                <label class ="form-group-label text-white" for="">Password: </label>
                <input type="password" spellcheck="false" @keydown="delete errors.password" v-model="user.password"  class="form-group-input bg-gray-300" placeholder="Enter Password">
                <span v-if="errors" class="text-red-700 pl-1 text-sm" role="alert">
                    <strong>{{errors.password?errors.password:''}}</strong>
                </span>
            </div>
            <div class="form-group mx-auto">
                <label class ="form-group-label text-white" for="">Confirm password: </label>
                <input type="password" spellcheck="false" @keydown="delete errors.confirm_password" v-model="user.confirm_password"  class="form-group-input bg-gray-300" placeholder="Enter Confirm Password">
                <span v-if="errors" class="text-red-700 pl-1 text-sm" role="alert">
                    <strong>{{errors.confirm_password?errors.confirm_password:''}}</strong>
                </span>
            </div>
        </div>
        <div class="flex justify-evenly">
            <div class="btn btn-wide bg-red-300 hover:bg-red-500 hover:text-white" @click="hide">Cancel</div>
            <div class="btn btn-wide bg-blue-300 border-blue-400 hover:bg-blue-600 hover:text-white" @click="submit">Submit</div>
        </div>
    </div>
</template>

<script>

export default {
    data(){
        return{
            user:{},
            errors:{
                email:false,
                username:false,
                firstName:false,
                lastName:false,
                password:false,
                confirm_password:false,
                role_id:false
            },
            roles:null,
            editRole:false

        }
    },
    mounted(){
        if (this.$attrs.new){
            this.user={
                email:null,
                username:null,
                firstName:null,
                lastName:null,
                password:null,
                confirm_password:null,
                role_id:null
            }
        }else if(this.$attrs.edit){
            this.user = this.$attrs.user;
            this.user.password=null;
            this.user.confirm_password=null;
        }
        else{
            this.user=this.$userId;
            this.user.password=null;
            this.user.confirm_password=null;
        }
        if (this.$attrs.editRole){
            this.editRole=this.$attrs.editRole;
        }
        this.getRoles();
    },
    methods:{
        getRoles(){
            axios.get('/api/getRoles').then(res=>{
                this.roles=res.data;
            })
        },
        hide(){
            this.$modal.hide('EditProfile');
        },
        submit(){
            //if users is passed to modal update it
            if (!this.$attrs.new){
                axios.post('/api/updateUser',{password:this.user.password,confirm_password:this.user.confirm_password,
                    email:this.user.email,firstName:this.user.firstName,lastName:this.user.lastName,
                    username:this.user.username,role_id:this.user.role_id,id:this.user.id}).then(res=>{

                    this.$swal({
                    title: '<strong>You updated a profile successfully</strong>',
                    icon: 'success',
                    showConfirmButton:false,
                    timer:3000,
                    });
                    window.Event.$emit('user-updated',true);
                this.hide();

                }).catch(error=>{
                    this.errors= error.response.data.errors;
                    for (const [key, value] of Object.entries(this.errors)){
                        console.log(key)
                        this.errors[key]=this.errors[key].toString();
                    }
                })
            //if user is not passed- create it
            }else{
                axios.post('/api/createUser',{password:this.user.password,confirm_password:this.user.confirm_password,
                    email:this.user.email,firstName:this.user.firstName,lastName:this.user.lastName,
                    username:this.user.username,role_id:this.user.role_id}).then(res=>{

                window.Event.$emit('user-inserted',true);
                this.hide();

                }).catch(error=>{
                    this.errors= error.response.data.errors;
                    for (const [key, value] of Object.entries(this.errors)){
                        console.log(key)
                        this.errors[key]=this.errors[key].toString();
                    }
                })
            }
        }
    }


}
</script>
<style>
.form-group {
  width: 50%;
  padding: 1rem;
}

.form-group-label {
  display: block;
  --text-opacity: 1;
  color: #4a5568;
  color: rgba(74, 85, 104, var(--text-opacity));
  font-size: 0.875rem;
  font-weight: 700;
  margin-bottom: 0.5rem;
}

.form-group-input {
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
  -webkit-appearance: none;
     -moz-appearance: none;
          appearance: none;
  border-width: 1px;
  border-radius: 0.25rem;
  width: 100%;
  padding-top: 0.5rem;
  padding-bottom: 0.5rem;
  padding-left: 0.75rem;
  padding-right: 0.75rem;
  --text-opacity: 1;
  color: #4a5568;
  color: rgba(74, 85, 104, var(--text-opacity));
  line-height: 1.25;
}

</style>
