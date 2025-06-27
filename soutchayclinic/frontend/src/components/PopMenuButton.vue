<template>
    <span>
        <Button type="button" :severity="severity" icon="pi pi-ellipsis-v" @click="toggle" aria-haspopup="true" aria-controls="overlay_menu" />
        <Menu ref="menu" id="overlay_menu" :model="items" :popup="true">
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
        </Menu>
    </span>
</template>

<script setup>
import { ref } from 'vue';

const menu = ref();
const props = defineProps({
    items: Array,
    severity: String
});
const toggle = (event) => {
    menu.value.toggle(event);
};
</script>
