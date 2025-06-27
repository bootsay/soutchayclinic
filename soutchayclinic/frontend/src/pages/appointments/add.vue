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
                                        Add Appointment
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
                                                        Patient Id 
                                                    </div>
                                                    <div class="col-span-full md:col-span-3">
                                                        <api-data-source :enable-cache="true"   api-path="components_data/patient_id_option_list" >
                                                            <template v-slot="req">
                                                                <Dropdown  class="w-full" :class="getErrorClass('patient_id')"   :loading="req.loading"   optionLabel="label" optionValue="value" v-model="formData.patient_id" :options="req.response" label="Patient Id"  placeholder="Select a value ..." >
                                                                </Dropdown> 
                                                                <small v-if="isFieldValid('patient_id')" class="p-error">{{ getFieldError('patient_id') }}</small> 
                                                            </template>
                                                        </api-data-source>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-span-full">
                                                <div class="grid grid-cols-4 md:gap-3">
                                                    <div class="col-span-full md:col-span-1">
                                                        Service Id 
                                                    </div>
                                                    <div class="col-span-full md:col-span-3">
                                                        <api-data-source :enable-cache="true"   api-path="components_data/service_id_option_list" >
                                                            <template v-slot="req">
                                                                <Dropdown  class="w-full" :class="getErrorClass('service_id')"   :loading="req.loading"   optionLabel="label" optionValue="value" v-model="formData.service_id" :options="req.response" label="Service Id"  placeholder="Select a value ..." >
                                                                </Dropdown> 
                                                                <small v-if="isFieldValid('service_id')" class="p-error">{{ getFieldError('service_id') }}</small> 
                                                            </template>
                                                        </api-data-source>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-span-full">
                                                <div class="grid grid-cols-4 md:gap-3">
                                                    <div class="col-span-full md:col-span-1">
                                                        Staff Id 
                                                    </div>
                                                    <div class="col-span-full md:col-span-3">
                                                        <api-data-source :enable-cache="true"   api-path="components_data/staff_id_option_list" >
                                                            <template v-slot="req">
                                                                <Dropdown  class="w-full" :class="getErrorClass('staff_id')"   :loading="req.loading"   optionLabel="label" optionValue="value" v-model="formData.staff_id" :options="req.response" label="Staff Id"  placeholder="Select a value ..." >
                                                                </Dropdown> 
                                                                <small v-if="isFieldValid('staff_id')" class="p-error">{{ getFieldError('staff_id') }}</small> 
                                                            </template>
                                                        </api-data-source>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-span-full">
                                                <div class="grid grid-cols-4 md:gap-3">
                                                    <div class="col-span-full md:col-span-1">
                                                        Appointment Date 
                                                    </div>
                                                    <div class="col-span-full md:col-span-3">
                                                        <Calendar  :showButtonBar="true" class="w-full" :class="getErrorClass('appointment_date')" dateFormat="yy-mm-dd" v-model="formData.appointment_date" :showIcon="true"     mask="YYYY-MM-DD"      />
                                                        <small v-if="isFieldValid('appointment_date')" class="p-error">{{ getFieldError('appointment_date') }}</small> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-span-full">
                                                <div class="grid grid-cols-4 md:gap-3">
                                                    <div class="col-span-full md:col-span-1">
                                                        Status 
                                                    </div>
                                                    <div class="col-span-full md:col-span-3">
                                                        <Dropdown  class="w-full" :class="getErrorClass('status')"      optionLabel="label" optionValue="value" v-model="formData.status" :options="app.menus.status" label="Status"  placeholder="Select a value ..." >
                                                        </Dropdown> 
                                                        <small v-if="isFieldValid('status')" class="p-error">{{ getFieldError('status') }}</small> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-span-full">
                                                <div class="grid grid-cols-4 md:gap-3">
                                                    <div class="col-span-full md:col-span-1">
                                                        Notes 
                                                    </div>
                                                    <div class="col-span-full md:col-span-3">
                                                        <Textarea :class="getErrorClass('notes')" class="w-full" rows="5"  v-model="formData.notes" placeholder="Enter Notes"    type="textarea">
                                                        </Textarea>
                                                        <small v-if="isFieldValid('notes')" class="p-error">{{ getFieldError('notes') }}</small> 
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
	import { required } from 'src/services/validators';
	import { useApp } from 'src/composables/app.js';
	import { useAddPage } from 'src/composables/addpage.js';
	import { usePageStore } from 'src/store/page';
	const props = defineProps({
		pageStoreKey: {
			type: String,
			default: 'APPOINTMENTS',
		},
		pageName : {
			type : String,
			default : 'appointments',
		},
		routeName : {
			type : String,
			default : 'appointmentsadd',
		},
		apiPath : {
			type : String,
			default : 'appointments/add',
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
				patient_id: "", service_id: "", staff_id: "", appointment_date: "NULL", status: "", notes: "", 
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
			patient_id: {  },
			service_id: {  },
			staff_id: {  },
			appointment_date: {  },
			status: {  },
			notes: {  }
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
			app.navigateTo(`/appointments`);
		}

	}

	
	const {  saving, pageReady, } = toRefs(page.state);

	
	const { submitForm, getErrorClass, getFieldError, isFieldValid,  } = page.methods;
	
	onMounted(()=>{
		const pageTitle = "Add Appointment";
		app.setPageTitle(props.routeName, pageTitle); // set browser page title
	});
	
	// expose page object for other components access
	defineExpose({
		page
	});
</script>
<style scoped>

</style>
