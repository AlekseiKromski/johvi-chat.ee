<template>
    <!-- Begin page -->
    <div id="layout-wrapper">
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    <div class="d-lg-flex mb-4">
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
                            <!--
                                                        <div class="chat-leftsidebar-nav">
                                                            <ul class="nav nav-pills nav-justified">
                                                                <li class="nav-item">
                                                                    <a href="#chat" data-toggle="tab" aria-expanded="true" class="nav-link active">
                                                                        <i class="ri-message-2-line font-size-20"></i>
                                                                        <span class="mt-2 d-none d-sm-block">Chat</span>
                                                                    </a>
                                                                </li>

                                                                <li class="nav-item">
                                                                    <a href="#group" data-toggle="tab" aria-expanded="false" class="nav-link">
                                                                        <i class="ri-group-line font-size-20"></i>
                                                                        <span class="mt-2 d-none d-sm-block">Group</span>
                                                                    </a>
                                                                </li>

                                </ul>
                            </div>-->
                            <div class="tab-content py-4">
                                <div class="tab-pane show active" id="chat">
                                    <div>
                                        <h5 class="font-size-14 px-3 mb-3">Recent</h5>
                                        <ul class="list-unstyled chat-list" data-simplebar style="max-height: 475px;">
                                            <li class="active">
                                                <a href="#">
                                                    <div class="media">

                                                        <div class="user-img online align-self-center mr-3">
                                                            <img src="chat/images/users/avatar-2.jpg" class="rounded-circle avatar-xs" alt="">
                                                            <span class="user-status"></span>
                                                        </div>

                                                        <div class="media-body overflow-hidden">
                                                            <h5 class="text-truncate font-size-14 mb-1">ALPHA SERVER ROOM</h5>
                                                            <p class="text-truncate mb-0">Hey! there I'm available</p>
                                                        </div>
                                                        <div class="font-size-11">xx min</div>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="w-100 user-chat mt-4 mt-sm-0">
                            <div class="p-3 px-lg-4 user-chat-border">
                                <div class="row">
                                    <div class="col-md-4 col-6">
                                        <h5 class="font-size-15 mb-1 text-truncate">ALPHA SERVER ROOM</h5>
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
                                    <ul id="chat-list" class="list-unstyled mb-0 pr-3" data-simplebar style="max-height: 450px;">




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
                                            <button type="submit" @click="sendMessage" class="btn btn-primary chat-send w-md waves-effect waves-light"><span class="d-none d-sm-inline-block mr-2">Send</span> <i class="mdi mdi-send"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                </div> <!-- container-fluid -->
            </div>

        </div>
        <!-- END layout-wrapper -->
    </div>
</template>

<script>
export default {
    props: ['username'],
    name: "chatComponent",
    data: function (){
        return {
            dataMessages: [],
            message: '',
        }
    },
    mounted() {
        let socket = io.connect('http://178.248.138.70:3000', {transports: ['websocket', 'polling', 'flashsocket']});
        socket.on("message-room:App\\Events\\NewMessage", function (data){
            this.dataMessages.push(data);
            let messageBlock = $('.simplebar-content')[1];
            let text = '';
            if(data.user == this.username){
                text = `
                <li class="right">
                                            <div class="conversation-list">
                                                <div class="ctext-wrap">
                                                    <div class="conversation-name">${this.username}</div>
                                                    <div class="ctext-wrap-content">
                                                        <p class="mb-0">
                                                            ${data.message}
                                                        </p>
                                                    </div>

                                                    <p class="chat-time mb-0"><i class="bx bx-time-five align-middle mr-1"></i> 10:02</p>
                                                </div>
                                            </div>
                                        </li>
            `;
            }else{
                text = `
                <li>
                                            <div class="conversation-list">
                                                <div class="ctext-wrap">
                                                    <div class="conversation-name">NO USER NAME</div>
                                                    <div class="ctext-wrap-content">
                                                        <p class="mb-0">
                                                            ${data.message}
                                                        </p>
                                                    </div>

                                                    <p class="chat-time mb-0"><i class="bx bx-time-five align-middle mr-1"></i> 10:02</p>
                                                </div>
                                            </div>
                                        </li>
            `;
            }
            messageBlock.innerHTML = messageBlock.innerHTML + text;
            document.querySelector('#chat-list').SimpleBar.getScrollElement().scrollTop =
                $('#chat-list .simplebar-content').height() + 150;

        }.bind(this));
    },
    methods: {
        sendMessage: function (){
            axios({
                method: 'get',
                url: '/looechat/send-message',
                params: {message: this.message}
            }).then((response) => {
                this.message = '';
            })
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
</style>
