<template>
    <router-link :to="link">
        <div class="card" :class="cardClass">
            <div class="flex items-start justify-between">
                <div class="font-bold text-xl">{{ title }}</div>
                <i v-if="icon" :class="icon" style="font-size: 30px; opacity: 0.4" />
            </div>
            <div class="text-center flex flex-col gap-2 items-center">
                <template v-if="loading">
                    <Skeleton width="3rem" height="2rem" class="m-2" />
                </template>
                <template v-else>
                    <Knob stroke-width="8px" v-if="showKnob" readonly :max="max" v-model="num" :valueTemplate="valueTemplate" />
                    <div v-else class="font-bold text-4xl">{{ recordCount }}</div>
                </template>
                <div class="text-gray-500">{{ subtitle }}</div>
            </div>
        </div>
    </router-link>
</template>
<script setup>
import { computed, onMounted, ref, watch } from 'vue';
import { useApiService } from 'src/services/api';

const props = defineProps({
    link: { type: String, default: '' },
    apiPath: { type: String, default: '', required: true },
    max: { type: Number, default: 100 },
    title: { type: String, default: '' },
    subtitle: { type: String, default: '' },
    valuePrefix: { type: String, default: '' },
    valueSuffix: { type: String, default: '' },
    icon: { type: String, default: '' },
    cardClass: { type: String, default: '' },
    showKnob: { type: Boolean, default: false }
});
const apiService = useApiService();

const num = ref(0);
const maxValue = ref(props.max);
const loading = ref(false);

const percent = computed(() => {
    return Math.round((num.value / maxValue.value) * 100);
});

const valueTemplate = computed(() => {
    return `${props.valuePrefix}{value}${props.valueSuffix}`;
});

const recordCount = computed(() => {
    return `${props.valuePrefix}${num.value}${props.valueSuffix}`;
});

const getRecordCount = () => {
    if (props.apiPath) {
        loading.value = true;
        apiService.get(props.apiPath).then(
            (response) => {
                loading.value = false;
                const result = response.data;
                if (result.num) {
                    num.value = parseFloat(result.num);
                    if (result.max_value) {
                        maxValue.value = result.max_value;
                    }
                } else {
                    num.value = parseFloat(result);
                }
            },
            () => {
                loading.value = false;
            }
        );
    }
};

watch(() => props.apiPath, getRecordCount);

onMounted(() => {
    getRecordCount();
});
</script>
