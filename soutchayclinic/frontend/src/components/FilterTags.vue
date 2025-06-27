<template>
    <div :class="wrapperClass">
        <template v-for="(filter, key) in filters" :key="key">
            <div v-if="filterHasValue(filter)" :class="tagClass">
                <span class="font-bold text-primary">{{ filter.tag || key }}</span>
                <Chip v-if="isMultipleFilter(filter)" v-for="val in filter.value" :key="`filtertag-${val}`" :class="chipClass" removable @remove="removeFilter(filter, val)" :label="getFilterLabel(filter, val)" />
                <Chip v-else :class="chipClass" removable @remove="removeFilter(filter)" :label="getFilterLabel(filter)" />
            </div>
        </template>
    </div>
</template>

<script setup>
const props = defineProps({
    controller: {
        type: Object,
        default: () => {}
    },
    chipClass: {
        type: String,
        default: 'font-medium'
    },
    tagClass: {
        type: String,
        default: 'card mb-0 nice-shadow-6 p-2 flex gap-2 items-center'
    },
    wrapperClass: {
        type: String,
        default: 'flex flex-wrap items-center gap-2 mb-3'
    }
});

function isMultipleFilter(filter) {
    return filter.valueType === 'multiple' || filter.valueType === 'multiple-date';
}

const { filterHasValue, getFilterLabel, removeFilter, filters } = props.controller;
</script>
