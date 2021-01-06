<template>

    <div class="chat-leftsidebar">
        <div class="p-3 border-bottom">
            <div class="media">
                <div class="align-self-center mr-3">
                    <img src="chat/images/users/avatar-2.jpg" class="avatar-xs rounded-circle" alt="">
                </div>
                <div class="media-body">
                    <h5 class="font-size-15 mt-0 mb-1">
                        {{username}}
                    </h5>
                    <p class="text-muted mb-0"><i class="mdi mdi-circle text-success align-middle mr-1"></i> В сети</p>
                </div>

                <div>
                    <div class="dropdown chat-noti-dropdown">
                        <button class="btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-horizontal font-size-20"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#">Добавить пользователя</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-content py-4">
            <div class="tab-pane show active" id="chat">
                <div>
                    <h5 class="font-size-14 px-3 mb-3">Recent</h5>
                    <p class="px-3 mb-3" v-if="chats.length == 0">
                        You dont have chats 😔
                    </p>

                    <ul id="chat-list-id" class="list-unstyled chat-list" >
                        <simplebar style="max-height: 475px;">
                            <!--class="active"-->
                            <li  v-for="chat in chats" v-bind:id="chat.chatroom.id" v-on:click.prevent="openChatDisplay($event)">
                                <a href="">
                                    <div class="media">

                                        <div class="user-img online align-self-center mr-3">
                                            <img src="chat/images/users/avatar-2.jpg" class="rounded-circle avatar-xs" alt="">
                                            <span class="user-status"></span>
                                        </div>

                                        <div class="media-body overflow-hidden">
                                            <h5 class="text-truncate font-size-14 mb-1">{{ chat.chatroom.name }}</h5>
                                            <p class="text-truncate mb-0">Hey! there I'm available</p>
                                        </div>
                                        <div class="font-size-11">xx min</div>
                                    </div>
                                </a>
                            </li>
                        </simplebar>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import EventBus from "../../eventBus";

import simplebar from 'simplebar-vue';
import 'simplebar/dist/simplebar.min.css';
export default {
    name: "leftSideChatComponent",
    props: ['username'],
    components: {
        simplebar
    },
    data: function (){
        return {
            chats: []
        }
    },
    mounted(){
        axios.get('/looechat/get-user-chats').then(response => {
            response.data.forEach(e => {
                this.chats.push(e);
            })

            EventBus.$on('join-chat-action', function (id){
                axios.get('/looechat/join/' + id).then(response => {
                    if(response.status == 200){
                        this.chats.push(response.data);
                    }
                }).catch(error => {
                    if(error.response.status === 405){
                        EventBus.$emit('error', error.response.data.error);
                    }else if(error.response.status === 404){
                        EventBus.$emit('error', error.response.data.error);
                    }
                });
            }.bind(this))
        });
    },
    methods:{
        openChatDisplay: function (event){
            EventBus.$emit('open-chat-display', event.currentTarget.id);
        }
    }
}
</script>

<style scoped>

</style>
