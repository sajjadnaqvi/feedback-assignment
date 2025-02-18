<template>
    <div>
        <h1>Home</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Create Feedback
        </button>
        <div v-for="(feedback, index) in feedbacks" :key="index">
            <FeedbackComponent :feedback="feedback"/>
        </div>
        <LoaderComponent :processing="processing" />

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form fields -->
                    <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" v-model="feedback.title">
                    <span class="text-danger" v-if="$v.feedback.title.$error">Title Required</span>
                    </div>
                    <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" rows="3" v-model="feedback.description"></textarea>
                    <span class="text-danger" v-if="$v.feedback.description.$error">Description Required</span>
                    </div>
                    <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" id="category" v-model="feedback.category_id" >
                        <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                    </select>
                    <span class="text-danger" v-if="$v.feedback.category_id.$error">Category Required</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" v-on:click="addFeedback">Create</button>
                </div>
                </div>
            </div>
            </div>
    </div>
    
</template>

<script>

import {getAuthenticatedUser} from '../utils';
import FeedbackComponent from "../components/FeedbackComponent.vue"
import { mapGetters } from 'vuex';
import {listAllFeedback, listAllCategoriess,  createFeedback } from '../apiService';
import LoaderComponent from "../components/LoaderComponent.vue";
import { required} from 'vuelidate/lib/validators';


export default {
    name:"HomeComponent",
    components:{
        FeedbackComponent,
        LoaderComponent
    },

    data() {
        return {
            feedback:{
                title: null,
                description: null,
                category_id: null
            },
            categories: [],
            feedbacks: [],
            processing : false,
        }
    },

    validations:{
        feedback:{
            title: {required},
            description: {required},
            category_id: {required}
        },
    },

    mounted() {
        getAuthenticatedUser();
         this.getFeedbacks();
         this.getCategoriess();
    },

    computed: {
    ...mapGetters(['currentUser', 'isAuthenticated', 'accessToken'])
    },

    methods: {
        async getFeedbacks (url)
        {
            this.processing = true;
            await listAllFeedback(url).then((response)=>{
                this.feedbacks = response?.result?.paginated_items?.data;
            }).catch((err)=>{
                console.log(err);
            }).finally(()=>{
                this.processing = false;
            });
        },

         async getCategoriess ()
        {
            await listAllCategoriess().then((response)=>{
                this.categories = response?.result?.paginated_items?.data;
            }).catch((err)=>{
                console.log(err);
            });
        },

        async addFeedback ()
        {
            this.$v.feedback.$touch();
            if(this.$v.feedback.$invalid){
                return;
            }
             let payload = {
                 title: this.feedback.title,
                 description: this.feedback.description,
                 category_id: this.feedback.category_id
            }
            
            await createFeedback(payload).then((response)=>{
                this.feedbacks.push(response?.result?.item); 
                this.closeModal();
            }).catch((err)=>{
                console.log(err);
            });
        },

        closeModal() {
            var modal = document.getElementById('exampleModal');
            if (modal) {
                modal.style.display = 'none';
            }
        }
    }
}
</script>
