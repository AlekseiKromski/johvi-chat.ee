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
                        <left-side-chat-component v-bind:username="username"></left-side-chat-component>

                        <default-chat-display-component v-if="room_id == 0 && room_id != -1"></default-chat-display-component>
                        <!-- Chat component -->
                        <chat-display-component
                            v-bind:chatName="chatName"
                            v-bind:messages="dataMessages"
                            v-bind:username="username"
                            v-bind:room_id="room_id"
                            v-bind:count_users="count_users"
                            v-bind:online_users="online_users"
                            v-if="room_id != -1 && room_id != 0"
                            v-show="openMountedChat"
                        ></chat-display-component>

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
import chatDisplayComponent from "./elements/chatDisplayComponent";
import leftSideChatComponent from "./elements/leftSideChatComponent";
import defaultChatDisplayComponent from "./elements/defaultChatDisplayComponent";
import preLoaderComponent from "./elements/preLoaderComponent";
import EventBus from "../eventBus";
export default {
    name: "chatComponent",
    props: ['username'],
    components: {
        'chat-display-component': chatDisplayComponent,
        'left-side-chat-component': leftSideChatComponent,
        'default-chat-display-component': defaultChatDisplayComponent,
        'pre-loader-component' : preLoaderComponent
    },
    data: function (){
        return {
            room_id: 0,
            error: false,
            error_message : '',
            chatName: '',
            count_users: '',
            dataMessages: [],
            preLoader: false,
            openMountedChat: false,
            online_users: null,

        }
    },
    mounted() {
        EventBus.$on('error', message => {this.showError(message)});
        EventBus.$on('open-chat-display', room_id => {this.openChatDisplay(room_id)});
        let socket = io.connect('http://178.248.138.70:3000', {transports: ['websocket', 'polling', 'flashsocket']});
        socket.on("message-room:App\\Events\\NewMessage", function (data){
            if(this.room_id == Number.parseInt(data.message.chat_room_id)){
                EventBus.$emit('message-delivered', data);
            }
        }.bind(this));
        socket.on("join-user:App\\Events\\JoinUser", function (data){

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
        openChatDisplay: function (room_id){
            if(room_id != this.room_id){
                this.room_id = -1;
                this.preLoader = true;
                this.openMountedChat = false;
                this.dataMessages = [];
                axios.get('/looechat/get-chat-info/' + room_id).then(response =>{
                    this.chatName = response.data.name;
                    this.count_users = response.data.users_count;
                    this.online_users = response.data.online_users;
                    axios.get('/looechat/get-messages/' + room_id).then(response => {
                        response.data.forEach(e => {
                            e = chatDisplayComponent.methods.getCurrentDate(e);
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
                axios.get('looechat/joined-to-channel/' + room_id);
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
