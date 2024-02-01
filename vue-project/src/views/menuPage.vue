<script setup>
  import { ref } from "vue";
  import noteContainer from "../components/noteContainer.vue";
  import {RouterLink} from "vue-router"

  const notes = ref();
  const showModal = ref(false);
  const newNoteTitle = ref();
  const newNoteContents = ref();
  fetchNotes();
  

  function fetchNotes(){
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'http://127.0.0.1:8000/api/fetch-notes', true);
    xhr.onload = function () {
      if (xhr.status >= 200 && xhr.status < 300) {
        notes.value = JSON.parse(xhr.responseText);
        return true;
      } else {
        console.error('Request failed with status', xhr.status);
        return false;
      }
    };
    xhr.onerror = function () {
      console.error('Request failed');
      return false;
    };
    xhr.send();
  }
  function createNote(){
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'http://127.0.0.1:8000/api/create-note', true);
    xhr.onload = function () {
      if (xhr.status >= 200 && xhr.status < 300) {
        var slug = JSON.parse(xhr.responseText);
        if(slug == false){
          console.error("failed to create note");
          return false
        }
        notes.value.unshift({
          "contents":newNoteContents.value,
          "title":newNoteTitle.value,
          'created_at':new Date(),
          "slug":slug,
        })
        newNoteContents.value = "";
        newNoteTitle.value = "";
        showModal.value = false;
        return true;
      } else {
        console.error('Request failed with status', xhr.status);
        return false;
      }
    };
    xhr.onerror = function () {
      console.error('Request failed');
      return false;
    };
    xhr.send(JSON.stringify({
      "contents":newNoteContents.value,
      "title":newNoteTitle.value,
      "created_at":new Date()
    }));
    return true;
  }
</script>

<template>
  <div style="background-color:rgb(226, 225, 225)">
    <div v-if="showModal" class="modal">
      <div class="modalCard">
        <div class="mb-5">
        <label
          for="name"
          class="mb-3 block text-base font-medium text-[#07074D]"
        >
          Note Title
        </label>
        <input  
          v-model="newNoteTitle"
          type="text"
          name="name"
          id="name"
          placeholder="Full Name"
          class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
        />
      </div>
      <div class="mb-5">
        <label
          for="message"
          class="mb-3 block text-base font-medium text-[#07074D]"
        >
          Notes Contents
        </label>
        <textarea 
          v-model="newNoteContents"
          rows="4"
          name="message"
          id="message"
          placeholder="Type your message"
          class="w-full resize-none rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
        ></textarea>
      </div>
      <button
        @click="createNote()"
        class="hover:shadow-form rounded-md bg-[#6A64F1] py-3 text-base font-semibold text-white outline-none modal-button"
      >
        Create
      </button> 
      <button
        @click="showModal = false"

        class="hover:shadow-form rounded-md bg-[#fc3d03] py-3 text-base font-semibold text-white outline-none modal-button"
      >
        Cancel
      </button> 
      </div>
    </div>
    <div class="flex items-center justify-between text-gray-400 dark:text-gray-400">
      <h1 style="margin:20px;"  >Notes</h1>
      <button  style="margin:20px;"  @click="showModal = true" class="showModalButton">+</button>
    </div>
    <div style="display:flex;flex-wrap:wrap">
      <noteContainer v-for="contents in notes" :contents="contents"/>
    </div>
  </div>
</template>

<style scoped>
  .modalCard{
    width:50%;
    height:500px;
    background-color:white;
    border-radius:10px;
    position:relative;
    display:flex;
    flex-direction:column;
    padding:30px;
  }
  .modal{
    position:absolute;
    width:100%;
    height:100%;
    background-color: rgba(0,0,0,0.8);
    z-index:10;
    display:flex;
    align-items: center;
    justify-content: center;
  }
  .modal-button{
    margin:10px;
  }
  .showModalButton{
    border-radius:50px;
    background-color:black;
    width:50px;
    height:50px;
    color:white;
    font-weight:bold;
    font-size:20px;
  }
</style>
