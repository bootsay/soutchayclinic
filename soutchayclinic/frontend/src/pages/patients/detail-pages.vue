<template>
    <div v-if="pageReady" id="master-detailpage">
        <TabView v-model:activeIndex="activeTab">
            <TabPanel>
                <template #header>
                    <div class=" text-lg font-bold" >
                        Patient Appointments
                    </div>
                </template>
                <div class="card my-3 p-3 surface-50">
                    <AppointmentsListPage ref="appointmentsListPage"  field-name="appointments.patient_id" :field-value="masterRecord.patient_id" :show-header="false" :show-breadcrumbs="false" page-store-key="APPOINTMENTS-DETAIL-PAGE" isSubPage>
                        </AppointmentsListPage>
                    </div>
                </TabPanel>
            </TabView>
        </div>
</template>
<script setup>
import { watch, computed, ref, onMounted } from 'vue';
import { useApp } from 'src/composables/app.js';
import { usePageStore } from 'src/store/page';

import AppointmentsListPage from 'src/pages/appointments/list.vue';
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

const store = usePageStore('PATIENTS');
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
	 
	// set appointments form data
	const appointmentsStore = usePageStore('appointments');
	appointmentsStore.setFormData({ patient_id:record?.patient_id });

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
