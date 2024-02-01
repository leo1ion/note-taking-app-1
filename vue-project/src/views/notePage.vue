<script setup>
    import { useRoute, RouterLink} from 'vue-router';
    import { ref } from "vue";

    const fetchNote = () => {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'http://127.0.0.1:8000/api/fetch-note/'+slug, true);
        xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
            cardData.value = JSON.parse(xhr.responseText);
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
        return true;
    }
    const saveNote = () => {
        var xhr = new XMLHttpRequest();
        xhr.open('PUT', 'http://127.0.0.1:8000/api/update-note', true);
        xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
            console.log(xhr.responseText);
            showSaveButton.value = false;
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
            "slug":cardData.value.slug,
            "title":cardData.value.title,
            "contents":cardData.value.contents,
        }));
    }
    const deleteNote = () => {
        var xhr = new XMLHttpRequest();
        xhr.open('DELETE', 'http://127.0.0.1:8000/api/delete-note', true);
        xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
            console.log(xhr.responseText);
            showDeleteModal.value = false;
            document.getElementById("backButton").click();
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
        xhr.send(JSON.stringify({"slug":slug}));
    }

    const route = useRoute();
    const slug = route.params.slug;
    const cardData = ref();
    const showSaveButton = ref(false);
    const showDeleteModal = ref(false);

    fetchNote();
</script>

<template >
    <div style="background-color:rgb(226, 225, 225)">
        <div v-if="showDeleteModal" class="modal">
            <div class="modalCard">
                <div class="mb-5">
                    <h1>Delete Note?</h1>
                    <div class="flex items-center justify-between text-gray-400 dark:text-gray-400">
                        <button
                            @click="deleteNote"
                            style="margin:30px;"
                            class="hover:shadow-form rounded-md bg-[#fc3d03] py-3 px-3 text-base font-semibold text-white outline-none modal-button"
                        >
                            Delete
                        </button> 
                        <button
                            @click="showDeleteModal = false"
                            style="margin:30px;"
                            class="hover:shadow-form rounded-md bg-[#dcdcdc] py-3 px-3 text-base font-semibold text-white outline-none modal-button"
                        >
                            Cancel
                        </button> 
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="background-color:rgb(226, 225, 225);height:100vw">
        <RouterLink id="backButton" style="margin:20px; width:400px;" :to="'/'" >
            <button>Back</button>
        </RouterLink>
        <div class="flex items-center justify-between text-gray-400 dark:text-gray-400">
            <input  
                @input="showSaveButton = true" v-model="cardData.title"
                type="text"
                name="name"
                id="name"
                placeholder="Full Name"
                style="margin:30px;"
                class="rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
            />
            <button
                @click="showDeleteModal = true"
                style="margin:30px;"
                class="hover:shadow-form rounded-md bg-[#fc3d03] py-3 px-3 text-base font-semibold text-white outline-none modal-button"
            >
                Delete Note
            </button> 
        </div>

        <div class="rounded" >
            <div style="margin:30px;" class=" h-80 flex flex-col justify-between bg-white dark:border-gray-700 rounded-lg border border-gray-400 mb-6 py-5 px-4">
                <textarea @input="showSaveButton = true" v-model="cardData.contents" style="height:70vw" class = "text-sm"></textarea>
                <div class="flex items-center justify-between text-gray-400 dark:text-gray-400">
                    <h5>Created At {{ new Date(cardData.created_at).toLocaleDateString() }}</h5>
                    <h5>Updated At {{ new Date(cardData.updated_at).toLocaleDateString() }}</h5>
                </div>
            </div>
        </div>
        <button
        @click="saveNote()"
        v-if="showSaveButton"
        style="width:100px;margin:30px"
        class="hover:shadow-form rounded-md bg-[#6A64F1] py-3 text-base font-semibold text-white outline-none modal-button"
      >
        Save
      </button> 

    </div>
</template>

<style scoped>
.modalCard{
    width:30%;
    height:200px;
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
</style>
