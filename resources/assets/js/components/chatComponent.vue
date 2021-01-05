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

                        <!-- Chat component -->
                        <chat-display-component v-bind:username="username"></chat-display-component>
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
export default {
    name: "chatComponent",
    props: ['username'],
    components: {
        'chat-display-component': chatDisplayComponent,
    },
    data: function (){
        return {

        }
    },
    mounted() {

    },
    methods: {

    }
}
</script>

<style scoped>

</style>
