
<template>
    <div>
    <section class="feed_box mx-auto">
      <div class="container my-2">
        <div class="card">
          <div class="card-header d-flex align-items-center justify-content-between">
            <div class="card-header-left">
                <ProfileSvg/>             
                <h5 class="mb-0 ml-3">{{feedback?.user?.full_name || 'N/A'}}</h5>
            </div>
            <div class="card_header--right">
                <p class="category__wrapper m-0">
                    {{feedback?.category?.name || 'N/A'}}
                </p>
            </div>
          </div>
        
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    {{feedback.title}}
                </h5>
                <p class="card-text">
                    {{feedback.description || 'N/A'}}
                </p>
            </div>
        </div>
         
          <div class="card-footer d-flex justify-content-between align-items-center">
            <div>
                <button class="btn btn-link comment-btn" v-on:click="toggleCommentShow()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-square" viewBox="0 0 16 16">
                      <path d="M0 1a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H3.586L1 15.586V12a1 1 0 0 1-1-1V1z"/>
                      <path d="M1 0a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11.586L15 14.414V1a1 1 0 0 0-1-1H1z"/>
                    </svg> Comment
                </button>
            </div>
            <div ><span class="comment-count">{{commentCount || 0}}</span> Comments</div>
          </div>
          <div class="comment-section m-3" v-if="showComments">
            <textarea
              class="form-control mb-2"
              rows="2"
              placeholder="Write a comment..."
              v-model="comment.content"
            ></textarea>
            <button class="btn btn-success btn-md submit-comment" v-on:click="createCommentOnPost()">
              Send
            </button>
              <!-- Previous comments -->
            <div class="previous-comments my-3" >

                <div class="comment py-1" v-for="(comment, index) in comments" :key="index">
                    <div class="cmnt--user__data d-flex align-items-center">

                        <div class="user_avatar me-3">
                             <profile-svg/>  
                        </div>
                        <div class="user_info_data">
                            <strong>{{comment?.user.full_name}}:</strong> 
                        <p class="m-0">{{comment?.created_at}}</p> 
                        </div>
                    </div>
                    <div class="comment_data position-relative p-4 ms-3 my-3 bg-light">
                        <p>
                        <b>{{comment?.mentions?.map((c)=>c.full_name).join(' ,')}}</b>
                            {{comment?.content}}
                        </p>
                    </div>
                </div>
            
                <!-- Add more previous comments here if needed -->
            </div>
          </div>
        </div>
      </div>
    </section>
    </div>
</template>

<script>
import ProfileSvg from "./ProfileSvg.vue";
import {getCommentOnFeedback, createComment} from '../apiService';
export default {
    name:"FeedbackComponent",
    components:{
        ProfileSvg
    },

    props:{
        feedback: {
            type: Object,
            default: () => {
                return {};
            },
        }
    },

    data(){
        return {
            showComments: false,
            comment:{
                commentable_id: null,
                commentable_type: 'Feedback',
                content: null
            },
            comments:[],
            commentCount: 0
        }
    },

    // computed: {
    //     getCommentCount(){
    //         return this.feedback.comments_count;
    //     }
    // },

    watch:{
        showComments: {
            handler: function(newValue) {
                if(newValue) {
                    this.commentCount = newValue.comments_count;
                }
            }
        },
        feedback: {
            handler: function(newValue) {
                if(newValue) {
                    this.getComments();
                }
            }
        }
    },

    methods: {
        toggleCommentShow(){
            this.showComments = !this.showComments;
        },

        async getComments(){
            await getCommentOnFeedback(this.feedback.id).then((response)=>{
                this.comments = response?.result?.comments;
            }).catch((err)=>{
                console.log(err);
            });
        },
        async createCommentOnPost(){
            
            let payload = {
                 commentable_id: this.feedback.id,
                 commentable_type: 'Feedback',
                 content: this.comment.content
            }
            this.comment.content = null;
            await createComment(payload).then((response)=>{
                this.comments.push(response?.result?.item);
                this.commentCount = this.commentCount +1; 
            }).catch((err)=>{
                console.log(err);
            });
        }
        
    }

}
</script>

<style scoped>
.feed_box {
        max-width: 800px;
}
.previous-comments{
    max-height: 300px;
    overflow-y: auto;
    z-index: 999;
    position: relative;
}
     
.comment_data::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    background-color: #ddcaca;
    rotate: 45deg;
    width: 40px;
    z-index: -1;
    transform: translate(-70%, 0%);
    height: 40px;
}
</style>

