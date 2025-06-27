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
                                <Avatar size="large" class="" icon="pi pi-plus" />
                                    <div class="text-2xl text-primary font-bold flex-1">
                                        Add Service
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </section>
                    <Divider />
                    </template>
                    <section class="page-section " >
                        <div class="grid grid-cols-12 gap-4">
                            <div  class="col-span-full md:col-span-7 comp-grid" >
                                <div >
                                    <form ref="observer" tag="form" @submit.prevent="submitForm()"  class="card ">
                                        <div class="grid grid-cols-12 gap-4">
                                            <div class="col-span-full">
                                                <div class="grid grid-cols-4 md:gap-3">
                                                    <div class="col-span-full md:col-span-1">
                                                        Name 
                                                    </div>
                                                    <div class="col-span-full md:col-span-3">
                                                        <InputText  v-model.trim="formData.name"  label="Name" type="text" placeholder="Enter Name"     
                                                        class=" w-full" :class="getErrorClass('name')">
                                                        </InputText>
                                                        <small v-if="isFieldValid('name')" class="p-error">{{ getFieldError('name') }}</small> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-span-full">
                                                <div class="grid grid-cols-4 md:gap-3">
                                                    <div class="col-span-full md:col-span-1">
                                                        Category 
                                                    </div>
                                                    <div class="col-span-full md:col-span-3">
                                                        <InputText  v-model.trim="formData.category"  label="Category" type="text" placeholder="Enter Category"     
                                                        class=" w-full" :class="getErrorClass('category')">
                                                        </InputText>
                                                        <small v-if="isFieldValid('category')" class="p-error">{{ getFieldError('category') }}</small> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-span-full">
                                                <div class="grid grid-cols-4 md:gap-3">
                                                    <div class="col-span-full md:col-span-1">
                                                        Price 
                                                    </div>
                                                    <div class="col-span-full md:col-span-3">
                                                        <InputText  v-model.trim="formData.price"  label="Price" type="number" placeholder="Enter Price"   step="0.1"   
                                                        class=" w-full" :class="getErrorClass('price')">
                                                        </InputText>
                                                        <small v-if="isFieldValid('price')" class="p-error">{{ getFieldError('price') }}</small> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-span-full">
                                                <div class="grid grid-cols-4 md:gap-3">
                                                    <div class="col-span-full md:col-span-1">
                                                        Duration Min 
                                                    </div>
                                                    <div class="col-span-full md:col-span-3">
                                                        <InputText  v-model.trim="formData.duration_min"  label="Duration Min" type="number" placeholder="Enter Duration Min"   step="any"   
                                                        class=" w-full" :class="getErrorClass('duration_min')">
                                                        </InputText>
                                                        <small v-if="isFieldValid('duration_min')" class="p-error">{{ getFieldError('duration_min') }}</small> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-span-full">
                                                <div class="grid grid-cols-4 md:gap-3">
                                                    <div class="col-span-full md:col-span-1">
                                                        Description 
                                                    </div>
                                                    <div class="col-span-full md:col-span-3">
                                                        <Textarea :class="getErrorClass('description')" class="w-full" rows="5"  v-model="formData.description" placeholder="Enter Description"    type="textarea">
                                                        </Textarea>
                                                        <small v-if="isFieldValid('description')" class="p-error">{{ getFieldError('description') }}</small> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-span-full">
                                                <div class="grid grid-cols-4 md:gap-3">
                                                    <div class="col-span-full md:col-span-1">
                                                        Is Active 
                                                    </div>
                                                    <div class="col-span-full md:col-span-3">
                                                        <InputText  v-model.trim="formData.is_active"  label="Is Active" type="number" placeholder="Enter Is Active"   step="any"   
                                                        class=" w-full" :class="getErrorClass('is_active')">
                                                        </InputText>
                                                        <small v-if="isFieldValid('is_active')" class="p-error">{{ getFieldError('is_active') }}</small> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-if="showSubmitButton" class="text-center my-3">
                                            <Button class="p-button-primary" type="submit" label="Submit" icon="pi pi-send" :loading="saving" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </section>
                </template>
            </main>
</template>
<script setup>
	import {  computed, reactive, toRefs, onMounted } from 'vue';
	import { required, numeric, } from 'src/services/validators';
	import { useApp } from 'src/composables/app.js';
	import { useAddPage } from 'src/composables/addpage.js';
	import { usePageStore } from 'src/store/page';
	const props = defineProps({
		pageStoreKey: {
			type: String,
			default: 'SERVICES',
		},
		pageName : {
			type : String,
			default : 'services',
		},
		routeName : {
			type : String,
			default : 'servicesadd',
		},
		apiPath : {
			type : String,
			default : 'services/add',
		},
		submitButtonLabel: {
			type: String,
			default: "Submit",
		},
		formValidationError: {
			type: String,
			default: "Form is invalid",
		},
		formValidationMsg: {
			type: String,
			default: "Please complete the form",
		},
		msgTitle: {
			type: String,
			default: "Create Record",
		},
		msgAfterSave: {
			type: String,
			default: "Record added successfully",
		},
		msgBeforeSave: {
			type: String,
			default: "",
		},
		showHeader: {
			type: Boolean,
			default: true,
		},
		showSubmitButton: {
			type: Boolean,
			default: true,
		},
		redirect: {
			type : Boolean,
			default : true,
		},
		isSubPage: {
			type : Boolean,
			default : false,
		},
		pageData: { // use to set formData default values from another page
			type: Object,
			default: () => ({
				name: "NULL", category: "NULL", price: "NULL", duration_min: "NULL", description: "", is_active: "1", 
			})
		},
	});
	//lines
	const store = usePageStore(props.pageStoreKey);
	const app = useApp();
	
	const formData = reactive({ ...props.pageData });
	
	//vuelidate form validation rules
	const rules = computed(() => {
		return {
			name: {  },
			category: {  },
			price: { numeric },
			duration_min: { numeric },
			description: {  },
			is_active: { numeric }
		}
	});

	
	const page = useAddPage({ store, props, formData, rules, beforeSubmit, afterSubmit });
	
	// event raised before submit form
	function beforeSubmit(){
		return true;
	}

	
	// event raised after form submited
	function afterSubmit(response) { 
		app.flashMsg(props.msgTitle, props.msgAfterSave);
		page.setFormDefaultValues(); //reset form data
		if(app.isDialogOpen()){
			app.closeDialogs(); // if page is open as dialog, close dialog
		}
		else if(props.redirect) {
			app.navigateTo(`/services`);
		}

	}

	
	const {  saving, pageReady, } = toRefs(page.state);

	
	const { submitForm, getErrorClass, getFieldError, isFieldValid,  } = page.methods;
	
	onMounted(()=>{
		const pageTitle = "Add Service";
		app.setPageTitle(props.routeName, pageTitle); // set browser page title
	});
	
	// expose page object for other components access
	defineExpose({
		page
	});
</script>
<style scoped>

</style>
