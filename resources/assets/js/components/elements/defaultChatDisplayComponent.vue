<template>
    <div class="w-100 user-chat mt-4 mt-sm-0 default-display">
        <div class="container-fluid h-100">
            <div class="row h-100 justify-content-center align-items-center">
                <div class="col-12 text-center">
                    <h2>LooE chat</h2>
                    <p>Список рекомендуемы чатов</p>
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <button id="1" href="" @click.prevent="joinAction($event)" class="btn btn-outline-primary">ALPHA TEST SERVER</button>
                            <button id="2" href="" @click.prevent="joinAction($event)" class="btn btn-outline-primary">ALPHA TEST SERVER2</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import EventBus from "../../eventBus";
export default {
    name: "defaultChatDisplayComponent",
    methods: {
        joinAction: function (e){
            EventBus.$emit('join-chat-action', e.target.id);
        }
    }
}
</script>

<style scoped>
    .default-display{
        min-height: 655px;
        background-color: #fbfbfb;
    }

</style>
