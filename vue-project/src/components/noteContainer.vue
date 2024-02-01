<script setup>
    import { defineProps } from 'vue';
    import {RouterLink} from "vue-router"
    const contents = defineProps(["contents","date"]);
    
</script>

<template>
  <RouterLink style="margin:20px; width:400px;" :to="'/notes/'+contents.contents.slug" >
    <div class="rounded">
      <div class="w-full h-64 flex flex-col justify-between bg-white dark:border-gray-700 rounded-lg border border-gray-400 mb-6 py-5 px-4">
        <h3 class = "text-gray-800 font-bold mb-3">{{ contents.contents.title }}</h3>
        <p class = "text-gray-800 text-sm">{{ contents.contents.contents.substring(0,250) }}</p>
        <div class="flex items-center justify-between text-gray-400 dark:text-gray-400">
          <p class = "text-sm"> {{ new Date(contents.contents.created_at).toLocaleDateString() }}</p>
          <svg  xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z"></path>
            <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4"></path>
            <line x1="13.5" y1="6.5" x2="17.5" y2="10.5"></line>
          </svg>
        </div>
      </div>
    </div>
  </RouterLink>
</template> 

<style scoped>
  .card{
    margin:20px;
    padding:10px;
    border-radius:10px;
    background-color: rgb(255, 179, 80);
    width:200px;
    height:100px;
  }
</style>
