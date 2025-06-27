<template>
    <div v-if="pageReady" id="master-detailpage">
        <TabView v-model:activeIndex="activeTab">
            <TabPanel>
                <template #header>
                    <div class=" text-lg font-bold" >
                        Role Permissions
                    </div>
                </template>
                <div class="card my-3 p-3 surface-50">
                    <PermissionsListPage ref="permissionsListPage"  field-name="permissions.role_id" :field-value="masterRecord.role_id" :show-header="false" :show-breadcrumbs="false" page-store-key="PERMISSIONS-DETAIL-PAGE" isSubPage>
                    </PermissionsListPage>
                </div>
            </TabPanel>
            <TabPanel>
                <template #header>
                    <div class=" text-lg font-bold" >
                        Role User
                    </div>
                </template>
                <div class="card my-3 p-3 surface-50">
                    <UserListPage ref="userListPage"  field-name="user.user_role_id" :field-value="masterRecord.role_id" :show-header="false" :show-breadcrumbs="false" page-store-key="USER-DETAIL-PAGE" isSubPage>
                    </UserListPage>
                </div>
            </TabPanel>
        </TabView>
    </div>
</template>
<script setup>
import { watch, computed, ref, onMounted } from 'vue';
import { useApp } from 'src/composables/app.js';
import { usePageStore } from 'src/store/page';

import PermissionsListPage from 'src/pages/permissions/list.vue';
import UserListPage from 'src/pages/user/list.vue';
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

const store = usePageStore('ROLES');
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
	 
	// set permissions form data
	const permissionsStore = usePageStore('permissions');
	permissionsStore.setFormData({ role_id:record?.role_id });

	 
	// set user form data
	const userStore = usePageStore('user');
	userStore.setFormData({ user_role_id:record?.role_id });

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
