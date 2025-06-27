<template>
    <div v-if="pageReady" id="master-detailpage">
        <TabView v-model:activeIndex="activeTab">
            <TabPanel>
                <template #header>
                    <div class=" text-lg font-bold" >
                        Appointment Payments
                    </div>
                </template>
                <div class="card my-3 p-3 surface-50">
                    <PaymentsListPage ref="paymentsListPage"  field-name="payments.appointment_id" :field-value="masterRecord.appointment_id" :show-header="false" :show-breadcrumbs="false" page-store-key="PAYMENTS-DETAIL-PAGE" isSubPage>
                    </PaymentsListPage>
                </div>
            </TabPanel>
        </TabView>
    </div>
</template>
<script setup>
import { watch, computed, ref, onMounted } from 'vue';
import { useApp } from 'src/composables/app.js';
import { usePageStore } from 'src/store/page';

import PaymentsListPage from 'src/pages/payments/list.vue';
//[--PAGE-IMPORT-STATEMENT--]

// user page import

const props = defineProps({
	isSubPage: {
		type : Boolean,
		default : true,
	},
	scrollIntoView: {
		type : Boolean,
		default : false,
	},
});

const store = usePageStore('APPOINTMENTS');
const app = useApp();

const masterRecord = computed(() => store.state.currentRecord);

const activeTab = ref(0);
const pageReady = computed(() => masterRecord.value != null);

//scroll detail page into view
function scrollToDetailPage() {
	if (props.scrollIntoView) {
		const pageElement = document.getElementById('master-detailpage');
		if(pageElement){
			pageElement.scrollIntoView({behavior:'smooth', block:'start'});
		}
	}
}

// pass form data from master to detail
function setDetailPageFormData(){
	const record = masterRecord.value;
	 
	// set payments form data
	const paymentsStore = usePageStore('payments');
	paymentsStore.setFormData({ appointment_id:record?.appointment_id });

}

watch(() => masterRecord, () => {
		setDetailPageFormData();
		scrollToDetailPage();
	},
	{ deep: true, immediate: true }
);

onMounted(()=>{ 
    scrollToDetailPage();
});

</script>
