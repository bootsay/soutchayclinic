<template>
    <main class="main-page"  id="">
        <template v-if="showHeader">
            <section class="page-section mb-4" >
                <div class="flex flex-wrap gap-4 items-center gap-4">
                    <div  v-if="!isSubPage"  class="md:col-span-4 " >
                        <Button @click="$router.go(-1)" label=""  class="p-button p-button-text " icon="pi pi-arrow-left"  />
                    </div>
                    <div  class="col-span-full " >
                        <div class=" text-2xl text-primary font-bold" >
                            Roles
                        </div>
                    </div>
                    
                </div>
            </section>
            <Divider />
            </template>
            <section class="page-section mb-3" >
                <div class="flex flex-wrap justify-between items-center gap-3">
                    <div  class="col-span-full " >
                        <Button label="Add Role" icon="pi pi-plus"  @click="app.openPageDialog({ component: RolesAddPage, url: `/roles/add` , closeBtn: true })"  class="p-button w-full bg-primary "  />
                    </div>
                    <div  class="col-span-full " >
                        <IconField iconPosition="right">
                        <InputText class="w-full"  placeholder="Search" :defaultValue="filters.search.value" @input="debounce(() => { filters.search.value = $event.target.value })"  />
                        <InputIcon class="pi pi-search" />
                        </IconField>
                    </div>
                </div>
            </section>
            <section class="page-section mb-4" >
                <div class="grid grid-cols-12 gap-4">
                    <div  class="col-span-full comp-grid" >
                        <!-- Display filtered items-->
                        <filter-tags :controller="page.filterController" />
                        <div >
                            <template v-if="showBreadcrumbs && $route.query.tag && !isSubPage">
                                <Breadcrumb :home="{icon: 'pi pi-home', to: '/roles'}" :model="pageBreadCrumb" />
                            </template>
                            <!-- page records template -->
                            <div class="page-records"  >
                                <DataTable :lazy="true"   :loading="loading"    v-model:selection="selectedItems"  :value="records" dataKey="role_id" @sort="onSort($event)" class=" p-datatable-sm" :stripedRows ="true" :showGridlines="false" :rowHover="true" responsiveLayout="stack">
                                    <Column selectionMode="multiple" headerStyle="width: 2rem" />
                                        <Column  field="role_id" header="Role Id" >
                                            <template #body="{ data, index }">
                                                <router-link class="p-button-text" :to="`/roles/view/${data.role_id}`">
                                                    {{ data.role_id }}
                                                </router-link>
                                            </template>
                                        </Column>
                                        <Column  field="role_name" header="Role Name" >
                                            <template #body="{ data, index }">
                                                {{ data.role_name }}
                                            </template>
                                        </Column>
                                        <Column  headerStyle="width: 2rem" headerClass="text-center">
                                            <template #body="{ data, index }">
                                                <div class="flex justify-end">
                                                    <PopMenuButton :items="getActionMenuModel(data)" severity="secondary"></PopMenuButton>
                                                </div>
                                            </template>
                                        </Column>
                                    </DataTable>
                                </div>
                                <!-- Empty record -->
                                <template v-if="pageReady && !records.length">
                                    <div class="p-3 my-3 text-gray-500 text-lg font-medium text-center">
                                        No record found
                                    </div>
                                </template>
                                <!-- end of empty record-->
                                <!-- pagination component-->
                                <template v-if="showFooter && pageReady">
                                    <div class="flex justify-between items-center">
                                        <div class="flex gap-2 flex-grow-0 mt-3">
                                            <Button v-if="selectedItems.length" @click="deleteItem(selectedItems)" severity="danger">
                                            <i class="pi pi-trash"></i> Delete Selected ({{ selectedItems.length }})
                                            </Button>
                                            <div v-if="exportButton && records.length">
                                                <Button @click="(event)=> $refs.exportMenu.toggle(event)" label="Export"  title="Export" icon="pi pi-print" />
                                                <Menu ref="exportMenu" popup :model="pageExportFormats" />
                                            </div>
                                            <import-data label="Select a file to import" ref="dataimport" upload-path="roles/importdata" @importComplete="importComplete">
                                            <Button  @click="$refs.dataimport.openDialog()" icon="pi pi-folder" label="Import Data" />
                                            </import-data>
                                        </div>
                                        <div v-if="paginate && totalPages > 1" class="flex-grow-1">
                                            <Paginator class="paginator-flat my-3" :first="recordsPosition - 1" @page="(event)=>{pagination.page = event.page + 1}" :rows="pagination.limit" :totalRecords="totalRecords">
                                                <template #start>
                                                    <span class="px-2">
                                                    Records <b>{{ recordsPosition }} of {{ totalRecords }}</b>
                                                    </span>
                                                </template>
                                                <template #end>
                                                </template>
                                            </Paginator>
                                        </div>
                                    </div>
                                </template>
                                <!-- end of pagination component-->
                            </div>
                        </div>
                    </div>
                </section>
            </main>
</template>
<script setup>
	import {  toRefs, onMounted } from 'vue';
	import { usePageStore } from 'src/store/page';
	import { useApp } from 'src/composables/app.js';
	import { useListPage } from 'src/composables/listpage.js';

	import RolesAddPage from 'src/pages/roles/add.vue';
	
	const props = defineProps({
		primaryKey : {
			type : String,
			default : 'role_id',
		},
		pageStoreKey: {
			type: String,
			default: 'ROLES',
		},
		pageName: {
			type: String,
			default : 'roles',
		},
		routeName: {
			type: String,
			default: 'roleslist',
		},
		apiPath: {
			type: String,
			default: 'roles/index',
		},
		autoLoad: {
			type: Boolean,
			default: true,
		},
		enableCache: {
			type: Boolean,
			default: false,
		},
		paginate: {
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
		showBreadcrumbs: {
			type: Boolean,
			default: true,
		},
		exportButton: {
			type: Boolean,
			default: true,
		},
		importButton: {
			type: Boolean,
			default: true,
		},
		multiCheckbox: {
			type: Boolean,
			default: true,
		},
		page: {
			type: Number,
			default: 1,
		},
		limit: {
			type: Number,
			default: 10,
		},
		mergeRecords: { // for infinite loading
			type: Boolean,
			default: false,
		},
		search: {
			type: String,
			default: '',
		},
		fieldName: null,
		fieldValue: null,
		queryParams: { 
			type: Object,
			default: () => ({})
		},
		sortBy: {
			type: String,
			default: '',
		},
		sortType: {
			type: String,
			default: 'desc', //desc or asc
		},
		isSubPage: {
			type: Boolean,
			default: false,
		},
		emptyRecordMsg: {
			type: String,
			default: "No record found",
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
		filterTagClass: {
			type: String,
			default: 'surface-card p-2 text-500 flex-grow-1 text-center m-1 mb-3 flex-grow-1 text-center',
		}
	});

	
	const app = useApp();
	
	const defaultStoreState = {
		filters: {
			search: {
				tag: "Search",
				value: '',
				valueType: 'single',
				options: [],
			}
		},
		pagination: {
			page: props.page,
			limit: props.limit,
			sortBy: props.sortBy,
			sortType: props.sortType
		},
		primaryKey: props.primaryKey,
		enableCache: props.enableCache
	}
	const store = usePageStore(props.pageStoreKey,  defaultStoreState);

	
	// page hooks where logics resides
	const page = useListPage({ store, props });
	
	const {records, filters,  totalRecords,  selectedItems,  pagination,} = toRefs(store.state);

	const { pageReady, loading, } = toRefs(page.state);
	
	const {  pageBreadCrumb,   totalPages, recordsPosition, } = page.computedProps;
	
	const { load,    exportPage, debounce, onSort,  deleteItem,   importComplete, } = page.methods;

	
	const pageExportFormats =  [
		{
			label: 'Print',
			icon: 'pi pi-print text-blue-500',
			command: () => { exportPage('print') }
		},
		{
			label: 'Pdf',
			icon: 'pi pi-file-pdf text-pink-500',
			command: () => { exportPage('pdf') }
		},
		{
			label: 'Excel',
			icon: 'pi pi-file-excel text-green-500',
			command: () => { exportPage('excel') }
		},
		{
			label: 'Csv',
			icon: 'pi pi-table text-green-200',
			command: () => { exportPage('csv') }
		}
	];
	function getActionMenuModel(data){
		return [
		{
			label: "View",
			to: `/roles/view/${data.role_id}`,
			icon: "pi pi-eye"
		},
		{
			label: "Edit",
			to: `/roles/edit/${data.role_id}`,
			icon: "pi pi-pencil"
		},
		{
			label: "Delete",
			command: (event) => { deleteItem(data.role_id) },
			icon: "pi pi-trash"
		}
	]
	}
	
	onMounted(()=>{ 
		const pageTitle = "Roles";
		app.setPageTitle(props.routeName, pageTitle);
	});
</script>
<style scoped>

</style>
