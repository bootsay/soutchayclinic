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
                                        Payment Details
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
                                    <div class="mb-3 grid grid-cols-12 gap-4">
                                        <div class="col-span-full md:col-span-4">
                                            <div class="flex gap-2 items-center card p-3 ">
                                                <div>
                                                    <div class="text-gray-600 mb-1">Payment Id</div>
                                                    <div class="font-bold">{{ item.payment_id }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-span-full md:col-span-4">
                                            <div class="flex gap-2 items-center card p-3 ">
                                                <div>
                                                    <div class="text-gray-600 mb-1">Appointment Id</div>
                                                    <div class="font-bold">
                                                        <Button variant="text" icon="pi pi-eye" label="Appointments Detail" v-if="item.appointment_id" @click="app.openPageDialog({ component: AppointmentsViewPage, url: `/appointments/view/${item.appointment_id}` , closeBtn: true })" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-span-full md:col-span-4">
                                            <div class="flex gap-2 items-center card p-3 ">
                                                <div>
                                                    <div class="text-gray-600 mb-1">Amount</div>
                                                    <div class="font-bold">{{ item.amount }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-span-full md:col-span-4">
                                            <div class="flex gap-2 items-center card p-3 ">
                                                <div>
                                                    <div class="text-gray-600 mb-1">Method</div>
                                                    <div class="font-bold">{{ item.method }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-span-full md:col-span-4">
                                            <div class="flex gap-2 items-center card p-3 ">
                                                <div>
                                                    <div class="text-gray-600 mb-1">Payment Date</div>
                                                    <div class="font-bold">{{ item.payment_date }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-span-full md:col-span-4">
                                            <div class="flex gap-2 items-center card p-3 ">
                                                <div>
                                                    <div class="text-gray-600 mb-1">Status</div>
                                                    <div class="font-bold">{{ item.status }}</div>
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

	import AppointmentsViewPage from 'src/pages/appointments/view.vue';
import PaymentsEditPage from 'src/pages/payments/edit.vue';
	const props = defineProps({
		id: [String, Number],
		primaryKey: {
			type: String,
			default: 'payment_id',
		},
		pageStoreKey: {
			type: String,
			default: 'PAYMENTS',
		},
		pageName: {
			type: String,
			default: 'payments',
		},
		routeName: {
			type: String,
			default: 'paymentsview',
		},
		apiPath: {
			type: String,
			default: 'payments/view',
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
			command: (event) => { app.openPageDialog({ component: PaymentsEditPage, url: `/payments/edit/${data.payment_id}`, closeBtn: true }) },
			icon: "pi pi-pencil"
		},
		{
			label: "Delete",
			command: (event) => { deleteItem(data.payment_id) },
			icon: "pi pi-trash"
		}
	]
	}
	
	onMounted(()=>{ 
		const pageTitle = "Payment Details";
		app.setPageTitle(props.routeName, pageTitle); // set browser page title
	});
	
</script>
<style scoped>

</style>
