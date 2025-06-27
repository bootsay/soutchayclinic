<template>
    <Menubar breakpoint="0px" :model="items">
        <template #item="{ item, props }">
            <router-link v-if="item.to" v-slot="{ href, navigate }" :to="item.to" custom>
                <a v-ripple :href="href" v-bind="props.action" @click="navigate">
                    <span :class="item.icon" />
                    <span class="ml-2">{{ item.label }}</span>
                </a>
            </router-link>
            <a v-else v-ripple :href="item.url" :target="item.target" v-bind="props.action">
                <span :class="item.icon" />
                <span class="ml-2">{{ item.label }}</span>
            </a>
        </template>
    </Menubar>
</template>

<script setup>
const props = defineProps({
    items: Array,
});
</script>
