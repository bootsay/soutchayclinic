<template>

    <img v-show="status === 'loaded'" :src="src" v-bind="$attrs" @load="loaded" @error="error" />
    <div v-if="status === 'loading'" class="loading text-center flex items-center justify-center bg-surface-100" v-bind="$attrs">
        <ProgressSpinner style="width: 30px; height: 30px" />
    </div>
    <div v-if="status === 'error'" v-bind="$attrs" class="bg-surface-100 flex items-center justify-center text-center rounded">
        <i class="text-400 pi pi-info-circle text-pink-500" style="font-size: 30px"></i>
    </div>
</template>
<script>
export default {
    props: {
        src: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            status: 'loading'
        };
    },
    methods: {
        loaded() {
            this.status = 'loaded';
        },
        error() {
            this.status = 'error';
        }
    }
};
</script>
