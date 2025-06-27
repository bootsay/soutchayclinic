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
                                        Add Patient
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
                                                        Full Name 
                                                    </div>
                                                    <div class="col-span-full md:col-span-3">
                                                        <InputText  v-model.trim="formData.full_name"  label="Full Name" type="text" placeholder="Enter Full Name"     
                                                        class=" w-full" :class="getErrorClass('full_name')">
                                                        </InputText>
                                                        <small v-if="isFieldValid('full_name')" class="p-error">{{ getFieldError('full_name') }}</small> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-span-full">
                                                <div class="grid grid-cols-4 md:gap-3">
                                                    <div class="col-span-full md:col-span-1">
                                                        Gender 
                                                    </div>
                                                    <div class="col-span-full md:col-span-3">
                                                        <Dropdown  class="w-full" :class="getErrorClass('gender')"      optionLabel="label" optionValue="value" v-model="formData.gender" :options="app.menus.gender" label="Gender"  placeholder="Select a value ..." >
                                                        </Dropdown> 
                                                        <small v-if="isFieldValid('gender')" class="p-error">{{ getFieldError('gender') }}</small> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-span-full">
                                                <div class="grid grid-cols-4 md:gap-3">
                                                    <div class="col-span-full md:col-span-1">
                                                        Birth Date 
                                                    </div>
                                                    <div class="col-span-full md:col-span-3">
                                                        <Calendar  :showButtonBar="true" class="w-full" :class="getErrorClass('birth_date')" dateFormat="yy-mm-dd" v-model="formData.birth_date" :showIcon="true"     mask="YYYY-MM-DD"      />
                                                        <small v-if="isFieldValid('birth_date')" class="p-error">{{ getFieldError('birth_date') }}</small> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-span-full">
                                                <div class="grid grid-cols-4 md:gap-3">
                                                    <div class="col-span-full md:col-span-1">
                                                        Phone 
                                                    </div>
                                                    <div class="col-span-full md:col-span-3">
                                                        <InputText  v-model.trim="formData.phone"  label="Phone" type="text" placeholder="Enter Phone"     
                                                        class=" w-full" :class="getErrorClass('phone')">
                                                        </InputText>
                                                        <small v-if="isFieldValid('phone')" class="p-error">{{ getFieldError('phone') }}</small> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-span-full">
                                                <div class="grid grid-cols-4 md:gap-3">
                                                    <div class="col-span-full md:col-span-1">
                                                        Email 
                                                    </div>
                                                    <div class="col-span-full md:col-span-3">
                                                        <InputText  v-model.trim="formData.email"  label="Email" type="email" placeholder="Enter Email"     
                                                        class=" w-full" :class="getErrorClass('email')">
                                                        </InputText>
                                                        <small v-if="isFieldValid('email')" class="p-error">{{ getFieldError('email') }}</small> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-span-full">
                                                <div class="grid grid-cols-4 md:gap-3">
                                                    <div class="col-span-full md:col-span-1">
                                                        Address 
                                                    </div>
                                                    <div class="col-span-full md:col-span-3">
                                                        <Textarea :class="getErrorClass('address')" class="w-full" rows="5"  v-model="formData.address" placeholder="Enter Address"    type="textarea">
                                                        </Textarea>
                                                        <small v-if="isFieldValid('address')" class="p-error">{{ getFieldError('address') }}</small> 
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
	import { required, email, } from 'src/services/validators';
	import { useApp } from 'src/composables/app.js';
	import { useAddPage } from 'src/composables/addpage.js';
	import { usePageStore } from 'src/store/page';
	const props = defineProps({
		pageStoreKey: {
			type: String,
			default: 'PATIENTS',
		},
		pageName : {
			type : String,
			default : 'patients',
		},
		routeName : {
			type : String,
			default : 'patientsadd',
		},
		apiPath : {
			type : String,
			default : 'patients/add',
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
				full_name: "NULL", gender: "", birth_date: "NULL", phone: "NULL", email: "NULL", address: "", 
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
			full_name: {  },
			gender: {  },
			birth_date: {  },
			phone: {  },
			email: { email },
			address: {  }
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
			app.navigateTo(`/patients`);
		}

	}

	
	const {  saving, pageReady, } = toRefs(page.state);

	
	const { submitForm, getErrorClass, getFieldError, isFieldValid,  } = page.methods;
	
	onMounted(()=>{
		const pageTitle = "Add Patient";
		app.setPageTitle(props.routeName, pageTitle); // set browser page title
	});
	
	// expose page object for other components access
	defineExpose({
		page
	});
</script>
<style scoped>

</style>
