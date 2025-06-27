<template>
    <div :class="containerClass" @click="onWrapperClick">
        <div class="layout-topbar  text-primary-100 shadow-7">
            <div class="layout-toggle-menu">
                <Button class="layout-topbar-button" @click="onMenuToggle">
                <i class="pi pi-bars"></i>
                </Button>
            </div>
            
            <router-link to="/" class="layout-topbar-logo flex-grow-none">
                <img src="/images/logo.png" style="max-width: 50px;" alt="logo" class="my-1" />
                <span>{{ $appName }}</span>
                
            </router-link>
            <div class="layout-topbar-menu flex-grow-1 justify-between">
                <TopMenus :menu-items="navbarTopRightItems" />
            </div>
        </div>
        <div class="layout-sidebar card p-2  nice-shadow-10" @click="onSidebarClick">
            <AppMenu :model="navbarSideLeftItems" @menuitem-click="onMenuItemClick" />
                
            </div>
            <div class="layout-main-container ">
                <div class="layout-main">
                    <router-view />
                    
                </div>
                <div class="layout-footer gap-3 flex justify-center items-center">
                    <div>
                        &copy; {{ new Date().getFullYear() }} {{$appName}}. All Rights Reserved
                    </div>
                </div>
                
            </div>
            <!-- App right drawer -->
            <Sidebar :showCloseIcon="false" position="right" v-model:visible="rightDrawer.showDrawer" :style="rightDrawer.drawerWidthStyle">
                <component v-if="rightDrawer.showDrawer" is-sub-page :is="rightDrawer.component" :api-path="rightDrawer.pageUrl" :page-data="rightDrawer.pageData" />
            </Sidebar>
            
            <transition name="layout-mask">
                <div class="layout-mask p-component-overlay" v-if="mobileMenuActive"></div>
            </transition>
            
            <!-- Page display dialog -->
            <Dialog class="card py-4 px-0" :breakpoints="{ '960px': '50vw', '640px': '95vw' }"
                :style="{ width: pageDialog.width, maxWidth: pageDialog.maxWidth }" :modal="!pageDialog.seamless"
                :maximized="pageDialog.maximized" :dismissableMask="!pageDialog.persistent" :position="pageDialog.position"
                v-model:visible="pageDialog.showDialog" :showHeader="false">
                <div style="position: absolute; right: 5px; top: 5px">
                    <Button v-if="pageDialog.closeBtn" @click="pageDialog.showDialog = false" style="position:absolute;right:10px;top:10px" icon="pi pi-times" class="p-button-rounded p-button-text p-button-plain" />
                </div>
                <component v-if="pageDialog.showDialog" is-sub-page :is="pageDialog.component" :api-path="pageDialog.pageUrl"  :page-data="pageDialog.pageData" />
            </Dialog>
            
            <!-- image preview dialog-->
            <Dialog class="card p-0" header="..." :showHeader="true" :breakpoints="{ '960px': '40vw', '640px': '95vw' }"
                style="width:auto" v-model:visible="imageDialog.showDialog" dismissableMask modal>
                <div class="text-center">
                    <Carousel v-if="imageDialog.images.length > 1" :value="imageDialog.images" :circular="false"
                    :page="imageDialog.currentSlide">
                    <template #item="{ data }">
                        <div class="text-center">
                            <NiceImage style="max-width:100%;max-height:70vh" :src="data" />
                        </div>
                    </template>
                    </Carousel>
                    <NiceImage v-else style="max-width:100%;max-height:70vh" :src="imageDialog.images[0]" />
                </div>
            </Dialog>
            
            <!-- app confirm page dialog -->
            <ConfirmDialog></ConfirmDialog>
            
            <!-- app flash message toast -->
            <Toast position="top-center" />
            
            <!-- app fullscreen loading dialog -->
            <Dialog class="card m-0" :showHeader="false" modal v-model:visible="fullScreenLoading"
                :breakpoints="{ '960px': '50vw', '640px': '95vw' }" style="width:20vw;" position="center">
                <ProgressBar mode="indeterminate" style="height: 6px"></ProgressBar>
                <div class="mt-2 text-center text-500">{{ fullScreenLoadingMsg }}</div>
            </Dialog>
        </div>
    
</template>
<script setup>
	import {  toRefs, computed, ref } from "vue";
	import AppMenu from 'src/components/AppMenu.vue';
	import { useApp } from 'src/composables/app';
	
	import { useRoute, useRouter } from 'vue-router';
	
	
	import { useAppStore } from 'src/store/app';

	const app = useApp();
	
	const store = useAppStore();
	
	//const route = useRoute();
	//const router = useRouter();

	const { pageDialog, imageDialog, rightDrawer, fullScreenLoading, fullScreenLoadingMsg } = toRefs(store);

	const layoutMode = ref('static');
	const menuClick = ref(false);
	const staticMenuInactive = ref(false);
	const overlayMenuActive = ref(false);
	const mobileMenuActive = ref(false);

	const containerClass = computed(() => {
		return ['layout-wrapper', {
			'layout-overlay': layoutMode.value === 'overlay',
			'layout-static': layoutMode.value === 'static',
			'layout-static-sidebar-inactive': staticMenuInactive.value && layoutMode.value === 'static',
			'layout-overlay-sidebar-active': overlayMenuActive.value && layoutMode.value === 'overlay',
			'layout-mobile-sidebar-active': mobileMenuActive.value,
			'p-input-filled': false,
		}];
	});
	const navbarSideLeftItems = app.menus.navbarSideLeft;
	const navbarTopRightItems = app.menus.navbarTopRight;
	function onMenuItemClick(event) {
		if (event.item && !event.item.items) {
			overlayMenuActive.value = false;
			mobileMenuActive.value = false;
		}
	}

	function onWrapperClick() {
		if (!menuClick.value) {
			overlayMenuActive.value = false;
			mobileMenuActive.value = false;
		}
		menuClick.value = false;
	}

	function onMenuToggle() {
		menuClick.value = true;
		if (app.isDesktop()) {
			if (layoutMode.value === 'overlay') {
				if(mobileMenuActive.value === true) {
					overlayMenuActive.value = true;
				}
				overlayMenuActive.value = !overlayMenuActive.value;
				mobileMenuActive.value = false;
			}
			else if (layoutMode.value === 'static') {
				staticMenuInactive.value = !staticMenuInactive.value;
			}
		}
		else {
			mobileMenuActive.value = !mobileMenuActive.value;
		}
	}
</script>
<script setup lang="ts">
</script>
