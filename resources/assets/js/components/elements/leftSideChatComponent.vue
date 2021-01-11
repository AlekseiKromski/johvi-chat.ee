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
                    <h6 class="font-size-12 mt-0 mb-1">
                        ID:#{{user_id}}
                    </h6>

                    <p class="text-muted mb-0"><i class="mdi mdi-circle text-success align-middle mr-1"></i> В сети</p>
                </div>

                <div>
                    <div class="dropdown chat-noti-dropdown">
                        <button class="btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-horizontal font-size-20"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#" @click.prevent="showAddUser = !showAddUser">Добавить пользователя</a>
                            <a class="dropdown-item" href="/looechat/logout">Выйти</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-3 border-bottom" v-if="showAddUser">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="#xxxx" aria-label="#xxxx" v-model="search_id_user" aria-describedby="button-addon2">
                <div class="input-group-append">
                    <button class="btn btn-secondary" type="button" id="button-addon2" @click.prevent="addUser()">Добавить</button>
                </div>
            </div>
        </div>
        <div class="tab-content py-4">
            <div class="tab-pane show active" id="chat">
                <div>
                    <h5 class="font-size-14 px-3 mb-3">Recent</h5>
                    <p class="px-3 mb-3" v-if="chats_rooms.length == 0 && chats_privates.length == 0">
                        You dont have chats 😔
                    </p>

                    <simplebar style="max-height: 475px;" class="list-unstyled chat-list">
                        <!--class="active"-->
                        <!-- v-bind:class="{'active' : chat.statusActive}" -->
                        <li v-for="chat in chats_rooms" v-bind:id="chat.chatroom.id" v-on:click.prevent="openChatRoomDisplay($event)">
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

                        <li v-for="chat in chats_privates" v-bind:id="chat.channel_id" v-on:click.prevent="openChatPrivateDisplay($event)">
                            <a href="">
                                <div class="media">

                                    <div class="user-img online align-self-center mr-3">
                                        <img src="chat/images/users/avatar-2.jpg" class="rounded-circle avatar-xs" alt="">
                                        <span class="user-status"></span>
                                    </div>

                                    <div class="media-body overflow-hidden">
                                        <h5 class="text-truncate font-size-14 mb-1">{{ chat.recipient.username }}</h5>
                                        <p class="text-truncate mb-0">Hey! there I'm available</p>
                                    </div>
                                    <div class="font-size-11">xx min</div>
                                </div>
                            </a>
                        </li>
                    </simplebar>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import EventBus from "../../eventBus";

import simplebar from 'simplebar-vue';
export default {
    name: "leftSideChatComponent",
    props: ['username', 'socket', 'user_id'],
    components: {
        simplebar
    },
    data: function (){
        return {
            chats_rooms: [],
            chats_privates: [],

            //Add user
            showAddUser: false,
            search_id_user: null
        }
    },
    mounted(){
        EventBus.$on('open-chat-display-set-class', function (room_id){
            /*
            this.chats.forEach(e => {
                if(e.statusActive == true){
                    e.statusActive = false;
                }
                if(e.chat_room_id == room_id){
                    e.statusActive = true;
                }
            })*/
            console.log('SET CLASS - leftSideComponent')
        }.bind(this));
        axios.get('/looechat/get-user-chat-rooms').then(response => {
            response.data.forEach(e => {
                e.statusActive = false;
                this.chats_rooms.push(e);
            })
        });
        axios.get('/looechat/get-user-chat-privates').then(response => {
            response.data.forEach(e => {
                e.statusActive = false;
                this.chats_privates.push(e);
                this.socket.on("private-message."+ e.channel_id +":App\\Events\\PrivateNewMessage", function (data){
                    EventBus.$emit('message-private-delivered', data);
                }.bind(this));
            });
        });
        EventBus.$on('join-chat-action', function (id){
            axios.get('/looechat/join/' + id).then(response => {
                if(response.status == 200){
                    this.chats_rooms.push(response.data);
                }
            }).catch(error => {
                if(error.response.status === 405){
                    EventBus.$emit('error', error.response.data.error);
                }else if(error.response.status === 404){
                    EventBus.$emit('error', error.response.data.error);
                }
            });
        }.bind(this))
        EventBus.$on('push-new-chat', function (response){
            this.socket.on("private-message."+ response.chat.channel_id +":App\\Events\\PrivateNewMessage", function (data){
                EventBus.$emit('message-private-delivered', data);
            }.bind(this));
            this.chats_privates.push(response.chat);
        }.bind(this))
    },
    methods:{
        openChatRoomDisplay: function (event){
            EventBus.$emit('open-chat-room-display', event.currentTarget.id);
        },
        openChatPrivateDisplay: function (event){
            let chat;
            this.chats_privates.forEach(e => {
                if(e.channel_id == event.currentTarget.id){
                    chat = e;
                }
            })
            EventBus.$emit('open-chat-private-display',
                {
                    'channel' : event.currentTarget.id,
                    'chat' : chat
                });
        },
        addUser: function(){
            this.search_id_user = this.search_id_user.replace('#','');
            axios.get('looechat/add-user/' + this.search_id_user).then(response => {
                this.search_id_user = '';
                this.showAddUser = false;
            }).catch(error => {
                EventBus.$emit('error', error.response.data.error);
                this.search_id_user = '';
                this.showAddUser = false;
            });
        }
    }
}
</script>

<style scoped>
    .chat-leftsidebar{
        min-height: 655px;
    }
</style>
