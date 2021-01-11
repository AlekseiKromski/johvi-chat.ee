<template>
    <!-- Begin page -->
    <div id="layout-wrapper">
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div v-if="error" class="alert alert-danger error-message">
            {{ error_message }}
        </div>
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    <div class="d-lg-flex mb-4">
                        <!-- Left side chat component -->
                        <left-side-chat-component
                            v-bind:socket="socket"
                            v-bind:username="username"
                            v-bind:user_id="user_id"
                        ></left-side-chat-component>

                        <default-chat-display-component v-if="room_id == 0 && room_id != -1 && channel == 0 && channel != -1"></default-chat-display-component>
                        <!-- Chat component -->
                        <chat-room-display-component
                            v-bind:chatName="chatName"
                            v-bind:messages="dataMessages"
                            v-bind:username="username"
                            v-bind:room_id="room_id"
                            v-bind:count_users="count_users"

                            v-if="display_type == 'room' && room_id != -1 && room_id != 0"
                            v-show="openMountedChat"
                        ></chat-room-display-component>

                        <chat-private-display-component
                            v-bind:chatName="chatName"
                            v-bind:messages="dataMessages"
                            v-bind:username="username"
                            v-bind:channel_id="channel"
                            v-bind:user_recipient="user_recipient"

                            v-if="display_type == 'private' && channel != -1 && channel != 0"
                            v-show="openMountedChat"
                        ></chat-private-display-component>

                        <pre-loader-component v-show="preLoader"></pre-loader-component>

                    </div>
                    <!-- end row -->

                </div> <!-- container-fluid -->
            </div>

        </div>
        <!-- END layout-wrapper -->
    </div>
</template>

<script>
import chatRoomDisplayComponent from "./elements/chatRoomDisplayComponent";
import leftSideChatComponent from "./elements/leftSideChatComponent";
import defaultChatDisplayComponent from "./elements/defaultChatDisplayComponent";
import preLoaderComponent from "./elements/preLoaderComponent";
import chatPrivateDisplayComponent from "./elements/chatPrivateDisplayComponent";
import EventBus from "../eventBus";
export default {
    name: "chatComponent",
    props: ['username', 'user_id'],
    components: {
        'chat-room-display-component': chatRoomDisplayComponent,
        'left-side-chat-component': leftSideChatComponent,
        'default-chat-display-component': defaultChatDisplayComponent,
        'pre-loader-component' : preLoaderComponent,
        'chat-private-display-component' : chatPrivateDisplayComponent,

    },
    data: function (){
        return {
            //Sys
            error: false,
            error_message : '',
            display_type: null,
            socket:null,

            //Rooms
            room_id: 0,
            chatName: '',
            count_users: '',
            dataMessages: [],
            preLoader: false,
            openMountedChat: false,

            //Private
            channel: 0,
            user_recipient: null

        }
    },
    mounted() {
        EventBus.$on('error', message => {this.showError(message)});
        EventBus.$on('open-chat-room-display', room_id => {this.openChatRoomDisplay(room_id)});
        EventBus.$on('open-chat-private-display', channel => {this.openChatPrivateDisplay(channel)});
        this.socket = io.connect('http://178.248.138.70:3000', {transports: ['websocket', 'polling', 'flashsocket']});
        this.socket.on("message-room:App\\Events\\NewMessage", function (data){
            EventBus.$emit('update-room-short-text', data);
            if(this.room_id == Number.parseInt(data.message.chat_room_id)){
                EventBus.$emit('message-delivered', data);
            }
        }.bind(this));
        this.socket.on("join-user:App\\Events\\JoinUser", function (data){

        }.bind(this));
        this.socket.on("user-channel." + this.user_id + ":App\\Events\\CreateNewChat", function (data){
            EventBus.$emit('push-new-chat', data);
        }.bind(this));
    },
    methods: {
        showError: function (message){
            this.error_message = message;
            this.error = true;
            setTimeout(function (){
                this.error = false;
                this.error_message = '';
            }.bind(this), 3500)
        },
        openChatRoomDisplay: function (room_id){
            this.channel = 0;
            if(room_id != this.room_id){
                this.display_type = 'room';
                this.room_id = -1;
                this.preLoader = true;
                this.openMountedChat = false;
                this.dataMessages = [];
                axios.get('/looechat/get-chat-info/' + room_id).then(response =>{
                    this.chatName = response.data.name;
                    this.count_users = response.data.users_count;
                    axios.get('/looechat/get-messages/' + room_id).then(response => {
                        response.data.forEach(e => {
                            e = chatRoomDisplayComponent.methods.getCurrentDate(e);
                            this.dataMessages.push(e);
                        });
                        this.room_id = room_id;
                        EventBus.$on('show-mounted-chat-display', function (this_) {
                            setTimeout(function (){
                                this.preLoader = false;
                                setTimeout(function (){
                                    this_.scrollBottom();
                                }, 0);
                                this.openMountedChat = true;
                            }.bind(this), 1000)

                            EventBus.$emit('open-chat-display-set-class', this.room_id);
                        }.bind(this));
                    });
                });
            }
        },
        openChatPrivateDisplay: function (chat){
            this.room_id = 0;
            if(chat.channel != this.channel){
                this.display_type = 'private';
                this.channel = -1;
                this.preLoader = true;
                this.openMountedChat = false;
                this.dataMessages = [];
                axios.get('/looechat/get-private-messages/' + chat.channel).then(response => {
                    this.chatName = chat.chat.recipient.username;
                    this.user_recipient = chat.chat.recipient.id;
                    response.data.forEach(e => {
                        e = chatPrivateDisplayComponent.methods.getCurrentDate(e);
                        this.dataMessages.push(e);
                    });
                    this.channel = chat.channel;
                    EventBus.$on('show-mounted-chat-display', function (this_) {
                        setTimeout(function (){
                            this.preLoader = false;
                            setTimeout(function (){
                                this_.scrollBottom();
                            }, 0);
                            this.openMountedChat = true;
                        }.bind(this), 1000)

                        EventBus.$emit('open-chat-display-set-class', this.channel);
                    }.bind(this));
                });
            }
        }

    }

}
</script>

<style scoped>
    .error-message{
        width: auto;
        position: absolute;
        right: 15px;
        top: 15px;
    }
</style>
