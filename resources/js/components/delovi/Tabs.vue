<template>
    <div class="mx-auto my-6 h-16 border-b-2  flex">
        <div class="w-full h-16 p-4 tabs flex justify-center" v-for="(value,key) in values" :key="key" v-bind:class="wClass(value.component)" v-on:click="changeTab( value.component)">
                <h3 class="text-white  font-bold "> {{value.name}} 
                <span v-if="value.page" class="text-xs">{{value.page}}</span>    
                </h3>   
        </div>
    </div>
</template>
<script>
export default {
    /**
     * values prop expects array of objects in format [{name:"screen name",component:"component name"},{name:'oher name',component:"other component"},....]
     * nonclickable prop can be ommited, if passed needs to be boolean and will prevent clicking on tabs
     * 
     * 
     */
    props: ['values','nonclikcable'],
    data() {
        return {
        
        }
    },
    methods: {
        changeTab(value){
            if(this.nonclikcable){
               return
            }
            this.$emit('input', value)
        },
        wClass: function (component) {
            let isActive = component==this.$attrs.value?'activeTab text-lg':""
            let isCleckable = this.nonclikcable?"cursor-default":'cursor-pointer'
        return isActive +" "+isCleckable
      
    }
    },
}
</script>
<style>
.activeTab {
  border-bottom-width: 6px;
  --border-opacity: 1;
  border-color: #00497b;
  border-color: rgba(147, 197, 253, var(--border-opacity));
}

.activeTab > * {
  --text-opacity: 1;
  color: #00497b;
  color: rgba(147, 197, 253, var(--text-opacity));
}
</style>