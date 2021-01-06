<template>
    <div class="w-100 user-chat mt-4 mt-sm-0">
        <div class="p-3 px-lg-4 user-chat-border">
            <div class="row">
                <div class="col-md-4 col-6">
                    <h5 class="font-size-15 mb-1 text-truncate">{{chatName}}</h5>
                    <p class="text-muted text-truncate mb-0"><i class="mdi mdi-circle text-success align-middle mr-1"></i> В сети</p>
                </div>
                <div class="col-md-8 col-6">
                    <ul class="list-inline user-chat-nav text-right mb-0">
                        <li class="list-inline-item">
                            x / x users
                        </li>

                    </ul>
                </div>
            </div>
        </div>

        <div class="px-lg-2 custom-chat-box">
            <div class="chat-conversation p-3">
                <ul class="list-unstyled chat-list" >
                    <simplebar ref="scrollElement" id="chat-display" style="max-height: 475px;">
                        <li class="right" v-for="message in dataMessages">
                            <div class="conversation-list">
                                <div class="ctext-wrap">
                                    <div class="conversation-name">{{message.user.username}}</div>
                                    <div class="ctext-wrap-content">
                                        <p class="mb-0">
                                            {{ message.message}}
                                        </p>
                                    </div>

                                    <p class="chat-time mb-0"><i class="bx bx-time-five align-middle mr-1"></i> 123</p>
                                </div>
                            </div>
                        </li>
                    </simplebar>
                </ul>
            </div>

        </div>
        <div class="px-lg-3">
            <div class="p-3 chat-input-section">
                <div class="row">
                    <div class="col">
                        <div class="position-relative">
                            <input type="text" @keydown.enter="sendMessage()" class="form-control chat-input" v-model="message" placeholder="Enter Message...">
                        </div>
                    </div>
                    <div class="col-auto">
                        <button type="submit" @click="sendMessage" class="btn btn-custom-primary chat-send w-md waves-effect waves-light"><span class="d-none d-sm-inline-block mr-2">Send</span> <i class="mdi mdi-send"></i></button>
                    </div>
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
    name: "chatDisplayComponent",
    props: ['username'],
    components: {
        simplebar
    },
    data: function (){
        return {
            dataMessages: [],
            message: '',
            chatName: '',
            room_id: 0
        }
    },
    mounted() {
        /*
        * By yakari76
        * ------------ HOW IT WORK (for future reader) --------------
        *
        * This code will get info of char room and get all room messages by room id and render messages.
        * Later code will be connected to the NODE.JS server with SOCKET.IO
        * When we get new message, code will add message to global array, and render message in display
        *
        * For improvement will be added 2 different methods:
        *   1. getCurrentDate() - will get message object and make perfect date (HOURS:MINUTES)
        *   2. renderMessages() - will add new element to DOM (THAT BAD IDEA, NEED IMPROVEMENT) and
        *       scroll your display to end of message box display
        * */

        EventBus.$on('open-chat-display', room_id => this.showChatDisplay(room_id));
    },
    methods: {
        sendMessage: function (){
            if(this.message != ''){
                axios({
                    method: 'get',
                    url: '/looechat/send-message',
                    params: {message: this.message, room_id: this.room_id}
                }).then((response) => {
                    this.message = '';
                })
            }
        },
        showChatDisplay: function (room_id){
            this.room_id = room_id;
            this.dataMessages = [];
            axios.get('/looechat/get-chat-info/' + this.room_id).then(response =>{
                this.chatName = response.data.name;

                axios.get('/looechat/get-messages/' + this.room_id).then(response => {
                    response.data.forEach(e => {
                        e = this.getCurrentDate(e);
                        this.dataMessages.push(e);
                    });

                    //Listen 'message-delivered' event
                    EventBus.$on('message-delivered', function (data){
                        console.log('ok')
                        data.message = this.getCurrentDate(data.message);
                        this.dataMessages.push(data.message);
                        //document.querySelector('#chat-display').SimpleBar.getScrollElement().scrollTop = $('#chat-display .simplebar-content').height() + 150;
                    }.bind(this));
                })
            });
        },

        //Sys
        getCurrentDate: function (message){
            let date = new Date(message.created_at)
            let cur_date = date.getHours() + ':' + date.getMinutes()
            message.date = cur_date;
            return message;
        }
    }
}
</script>

<style scoped>
    .custom-chat-box{
        min-height: 450px;
    }
    .list-unstyled{
        min-height: 450px;
    }
    .btn-custom-primary{
        background-color: #df7166;
        color: white;
        border: none;
    }
    .btn-custom-primary:focus{
        box-shadow: 0 0 0 3px rgba(223,113,102,.5);
    }
</style>
