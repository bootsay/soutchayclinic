<template>
    <main class="main-page"  id="">
        <template v-if="pageReady">
            <template v-if="showHeader">
                <section class="page-section mb-4" >
                    <div class="flex flex-wrap gap-4 items-center gap-4">
                        <div  v-if="!isSubPage"  class="md:col-span-4 " >
                            <Button @click="$router.go(-1)" label=""  class="p-button p-button-text " icon="pi pi-arrow-left"  />
                        </div>
                        <div  class="col-span-full " >
                            <div class=" flex gap-2 items-center " >
                                <Avatar size="large" class="" icon="pi pi-eye" />
                                    <div class="text-2xl text-primary font-bold flex-1">
                                        Patient Details
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </section>
                    <Divider />
                    </template>
                    <section class="page-section mb-4" >
                        <div class="grid grid-cols-12 gap-4">
                            <div  class="col-span-full comp-grid" >
                                <div >
                                    <div class="">
                                        <div class="col-span-full">
                                            <div class="mb-3 grid grid-cols-12 gap-4">
                                                <div class="col-span-full md:col-span-4">
                                                    <div class="flex gap-2 items-center card p-3 ">
                                                        <div>
                                                            <div class="text-gray-600 mb-1">Patient Id</div>
                                                            <div class="font-bold">{{ item.patient_id }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-span-full md:col-span-4">
                                                    <div class="flex gap-2 items-center card p-3 ">
                                                        <div>
                                                            <div class="text-gray-600 mb-1">Full Name</div>
                                                            <div class="font-bold">{{ item.full_name }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-span-full md:col-span-4">
                                                    <div class="flex gap-2 items-center card p-3 ">
                                                        <div>
                                                            <div class="text-gray-600 mb-1">Gender</div>
                                                            <div class="font-bold">{{ item.gender }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-span-full md:col-span-4">
                                                    <div class="flex gap-2 items-center card p-3 ">
                                                        <div>
                                                            <div class="text-gray-600 mb-1">Birth Date</div>
                                                            <div class="font-bold">{{ item.birth_date }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-span-full md:col-span-4">
                                                    <div class="flex gap-2 items-center card p-3 ">
                                                        <div>
                                                            <div class="text-gray-600 mb-1">Phone</div>
                                                            <div class="font-bold">{{ item.phone }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-span-full md:col-span-4">
                                                    <div class="flex gap-2 items-center card p-3 ">
                                                        <div>
                                                            <div class="text-gray-600 mb-1">Email</div>
                                                            <div class="font-bold">{{ item.email }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-span-full md:col-span-4">
                                                    <div class="flex gap-2 items-center card p-3 ">
                                                        <div>
                                                            <div class="text-gray-600 mb-1">Address</div>
                                                            <div class="font-bold">{{ item.address }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-span-full md:col-span-4">
                                                    <div class="flex gap-2 items-center card p-3 ">
                                                        <div>
                                                            <div class="text-gray-600 mb-1">Created At</div>
                                                            <div class="font-bold">{{ item.created_at }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- action buttons -->
                                            <div  class=" flex gap-3 ">
                                                <div v-if="exportButton">
                                                    <Button @click="(event)=> $refs.exportMenu.toggle(event)" label="Export"  title="Export" icon="pi pi-print" />
                                                    <Menu ref="exportMenu" popup :model="pageExportFormats" />
                                                </div>
                                                <PageMenubar  :model="getActionMenuModel(item)" />
                                            </div>
                                        </div>
                                        <!-- Detal Page Column -->
                                        <template v-if="currentRecord && !isSubPage">
                                            <div class="col-span-12">
                                                <div class="card  my-3 p-1">
                                                    <component :is="masterDetailPage" :scroll-into-view="false"></component>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </template>
                <template v-if="loading">
                    <div style="min-height:200px" class="flex gap-3 justify-center items-center p-3">
                        <div><ProgressSpinner style="width:50px;height:50px" /> </div>
                        <div class="text-gray-500">Loading... </div>
                    </div>
                </template>
            </main>
</template>
<script setup>
	import {  toRefs, onMounted } from 'vue';
	import { useApp } from 'src/composables/app.js';
	import { usePageStore } from 'src/store/page';
	import { useViewPage } from 'src/composables/viewpage.js';

	import PatientsEditPage from 'src/pages/patients/edit.vue';
	const props = defineProps({
		id: [String, Number],
		primaryKey: {
			type: String,
			default: 'patient_id',
		},
		pageStoreKey: {
			type: String,
			default: 'PATIENTS',
		},
		pageName: {
			type: String,
			default: 'patients',
		},
		routeName: {
			type: String,
			default: 'patientsview',
		},
		apiPath: {
			type: String,
			default: 'patients/view',
		},
		autoLoad: {
			type: Boolean,
			default: true,
		},
		titleBeforeDelete: {
			type: String,
			default: "Delete record",
		},
		msgBeforeDelete: {
			type: String,
			default: "Are you sure you want to delete this record?",
		},
		msgAfterDelete: {
			type: String,
			default: "Record deleted successfully",
		},
		exportButton: {
			type: Boolean,
			default: true,
		},
		showHeader: {
			type: Boolean,
			default: true,
		},
		showFooter: {
			type: Boolean,
			default: true,
		},
		isSubPage: {
			type : Boolean,
			default : false,
		}
	});
	
	const store = usePageStore(props.pageStoreKey);
	const app = useApp(props);
	
	const page = useViewPage({ store, props }); // where page logics resides
	
	const {  currentRecord } = toRefs(store.state);
	const { loading, pageReady } = toRefs(page.state);
	const item = currentRecord;
	
	const  { load, deleteItem, exportPage,   } = page.methods;

	
	const pageExportFormats =  [
		{
			label: 'Pdf',
			icon: 'pi pi-file-pdf text-pink-500',
			command: () => { exportPage('pdf') }
		}
	];
	function getActionMenuModel(data){
		return [
		{
			label: "Edit",
			command: (event) => { app.openPageDialog({ component: PatientsEditPage, url: `/patients/edit/${data.patient_id}`, closeBtn: true }) },
			icon: "pi pi-pencil"
		},
		{
			label: "Delete",
			command: (event) => { deleteItem(data.patient_id) },
			icon: "pi pi-trash"
		}
	]
	}
	
	onMounted(()=>{ 
		const pageTitle = "Patient Details";
		app.setPageTitle(props.routeName, pageTitle); // set browser page title
	});
	
</script>
<style scoped>

</style>
