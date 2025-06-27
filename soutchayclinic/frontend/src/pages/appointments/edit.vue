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
                                <Avatar size="large" class="" icon="pi pi-pencil" />
                                    <div class="text-2xl text-primary font-bold flex-1">
                                        Edit Appointment
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
                                    <form ref="observer"  tag="form" @submit.prevent="submitForm()"  class="card ">
                                        <!--[form-content-start]-->
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
                                        <!--[form-content-end]-->
                                        <div v-if="showSubmitButton" class="text-center my-3">
                                            <Button type="submit" label="Update" icon="pi pi-send" :loading="saving" />
                                        </div>
                                    </form>
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
	import {  computed, reactive, toRefs, onMounted } from 'vue';
	import { required } from 'src/services/validators';
	import { useApp } from 'src/composables/app.js';
	import { useEditPage } from 'src/composables/editpage.js';
	import { usePageStore } from 'src/store/page';
	const props = defineProps({
		id: [String, Number],
		pageStoreKey: {
			type: String,
			default: 'APPOINTMENTS',
		},
		pageName: {
			type: String,
			default: 'appointments',
		},

		routeName: {
			type: String,
			default: 'appointmentsedit',
		},
		pagePath: {
			type : String,
			default : 'appointments/edit',
		},
		apiPath: {
			type: String,
			default: 'appointments/edit',
		},
		submitButtonLabel: {
			type: String,
			default: "Update",
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
			default: "Update Record",
		},
		msgBeforeSave: {
			type: String,
			default: "",
		},
		msgAfterSave: {
			type: String,
			default: "Record updated successfully",
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
	});

	
	const store = usePageStore(props.pageStoreKey);
	const app = useApp();
	
	const formDefaultValues = Object.assign({
		patient_id: "", service_id: "", staff_id: "", appointment_date: "NULL", status: "", notes: "", 
	}, props.pageData);
	
	const formData = reactive({ ...formDefaultValues });
	
	function afterSubmit(response) {
		app.flashMsg(props.msgTitle, props.msgAfterSave);
		if(app.isDialogOpen()){
			app.closeDialogs(); // if page is open as dialog, close dialog
		}
		else if(props.redirect) {
			app.navigateTo(`/appointments`);
		}

	}
	
	// form validation rules
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
	
	const page = useEditPage({store, props, formData, rules, afterSubmit });
	
	const {  currentRecord: editRecord } = toRefs(store.state);
	const {  pageReady, saving, loading, } = toRefs(page.state);
	
	const { apiUrl } = page.computedProps;
	
	const { load, submitForm, getErrorClass, getFieldError, isFieldValid,  } = page.methods;
	
	onMounted(()=>{
		const pageTitle = "Edit Appointment";
		app.setPageTitle(props.routeName, pageTitle); // set browser page title
	});
</script>
<style scoped>

</style>
