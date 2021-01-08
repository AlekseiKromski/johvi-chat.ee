<template>
    <div class="w-100 user-chat mt-4 mt-sm-0 default-display">
        <div class="container-fluid h-100">
            <div class="row h-100 justify-content-center align-items-center">
                <div class="col-12 text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "preLoaderComponent"
}
</script>

<style scoped>
    .spinner-border{
        color: #df7166;
    }
</style>
