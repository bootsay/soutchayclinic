<template>
    <div class="uploader p-2 bg-surface-100 dark:bg-surface-700 rounded-border">
        <FileUpload
            :disabled="disableUpload"
            ref="uploader"
            name="file"
            :auto="true"
            :maxFileSize="maxFileSize"
            :accept="accept"
            :multiple="multiple"
            mode="advanced"
            :showUploadButton="false"
            :showCancelButton="false"
            :url="setUploadPath"
            @before-send="setHeaders"
            @select="validateUpload"
            @upload="uploadComplete"
            @error="uploadError"
            @progress="uploadProgress"
        >
            <template #empty>
                <div class="flex items-center gap-6 justify-center text-2xl text-surface-400 dark:text-surface-400">
                    <i class="pi pi-cloud-upload border-2 rounded-full p-2 border-surface-400 dark:border-surface-400 text-4xl" />
                    <strong>{{ label }}</strong>
                </div>
            </template>
            <template #content="{ files, uploadedFiles, onFileRemove, messages }">
                <div>
                    <Message v-for="msg of messages" severity="error" :key="msg">{{ msg }}</Message>
                    <div v-if="files.length > 0">
                        <ProgressBar :value="uploadPercent" />
                        <div class="flex justify-around flex-wrap gap-2">
                            <div v-for="(file, index) of files" :key="file.name + file.type + file.size">
                                <div :class="fileHolderClass" v-if="isImage(file.name)">
                                    <img alt="img" width="50px" height="50px" :src="file.objectURL" />
                                    <div class="text-sm text-surface-500 dark:text-surface-300">
                                        {{ utils.strEllipsis(file.name, 10) }} <br />
                                        <b>{{ utils.formatSize(file.size) }}</b>
                                    </div>
                                    <Button class="p-button-danger p-button-sm p-button-text" @click="onFileRemove(index)" icon="pi pi-times" />
                                </div>

                                <div :class="fileHolderClass" v-else>
                                    <Avatar size="large" icon="pi pi-file" class="bg-green-100 text-green-500" />
                                    <div class="text-sm text-surface-500 dark:text-surface-300">
                                        {{ utils.strEllipsis(file.name, 10) }} <br />
                                        <b>{{ utils.formatSize(file.size) }}</b>
                                    </div>

                                    <Button class="p-button-danger p-button-sm p-button-text" @click="onFileRemove(index)" icon="pi pi-times" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 font-bold" v-if="!disableUpload && uploadedFiles.length">{{ label }}</div>
                </div>
            </template>
        </FileUpload>
        <template v-if="showUploadedFiles && getUploadedFiles.length">
            <div class="flex items-center justify-evenly gap-2 flex-wrap mt-2">
                <div class="p-2 font-bold text-center text-surface-500 dark:text-surface-300">
                    <i class="pi pi-upload"></i>
                    {{ $t('uploadedFiles') }}
                </div>
                <template v-for="file in getUploadedFiles" :key="file.path">
                    <div :class="fileHolderClass" v-if="file.isImage">
                        <ImageViewer width="40px" height="40px" :src="file.path" />
                        <span class="text-sm text-surface-500 dark:text-surface-300">{{ file.shortName }}</span>
                        <Button class="p-button-danger p-button-sm p-button-text" @click="removeFile(file)" icon="pi pi-times" />
                    </div>
                    <div :class="fileHolderClass" v-else>
                        <a class="flex gap-2 items-center" target="_blank" :href="utils.getFileFullPath(file.path)">
                            <Avatar size="large" icon="pi pi-file" class="bg-green-100 text-green-500" />
                            <span class="text-sm text-surface-500 dark:text-surface-300">{{ file.shortName }}</span>
                        </a>
                        <Button class="p-button-danger p-button-sm p-button-text" @click="removeFile(file)" icon="pi pi-times" />
                    </div>
                </template>
            </div>
        </template>
    </div>
</template>
<script setup>
import { ref, computed, onMounted } from 'vue';
import { utils } from 'src/utils';
import { useStorageService } from 'src/services/storage';
import { useApiService } from 'src/services/api';
import { $t } from 'src/services/i18n';

const localStore = useStorageService();
const apiService = useApiService();

const props = defineProps({
    fileHolderClass: { type: String, default: 'flex justify-between gap-6 items-center p-1 card text-green-500' },
    accept: { type: String, default: '.png,.gif,.jpg,.jpg' },
    extensions: { type: String, default: '' },
    fileLimit: { type: Number, default: 5 },
    maxFileSize: { type: Number, default: 10000000 },
    multiple: { type: Boolean, default: true },
    uploadPath: { type: String, required: true },
    fieldName: { type: String, default: 'photo' },
    label: { type: String, default: 'Choose files or Drop files here' },
    showUploadedFiles: { type: Boolean, default: true },
    modelValue: null
});

const emit = defineEmits(['update:modelValue', 'uploadComplete', 'uploadError', 'toast']);

const files = ref([]);
const uploadedFilePaths = ref([]);
const uploadPercent = ref(0);
const uploader = ref(null);

const uploadProgress = (event) => {
    uploadPercent.value = event.progress;
};

const validateUpload = (event) => {
    const selectedFilesCount = event.files.length;
    const uploadedFileCount = uploadedFilePaths.value.length;
    const totalFiles = selectedFilesCount + uploadedFileCount;
    if (totalFiles > props.fileLimit) {
        uploader.value.clear();
        emit('toast', { severity: 'error', summary: 'Upload Failed', detail: `Max file limit: ${props.fileLimit}`, life: 3000 });
    }
};

const updateValue = () => {
    emit('update:modelValue', uploadedFilePaths.value.toString());
};

const setHeaders = (event) => {
    const token = localStore.getToken();
    event.xhr.setRequestHeader('Authorization', `Bearer ${token}`);
};

const uploadComplete = (event) => {
    uploadPercent.value = 0;
    const uploadedPaths = (event.xhr.response || '').toString().split(',');
    uploadedFilePaths.value.push(...uploadedPaths);
    updateValue();
    emit('uploadComplete', uploadedPaths);
};

const uploadError = (event) => {
    emit('uploadError', event.xhr.responseText);
};

const openFile = (file) => {
    if (file.path) {
        let fullPath = utils.getFileFullPath(file.path);
        window.open(fullPath, '_blank');
    }
};

const removeFile = (file) => {
    let index = uploadedFilePaths.value.indexOf(file.path);
    if (index !== -1) {
        uploadedFilePaths.value.splice(index, 1);
        uploader.value.uploadedFileCount--;
        apiService.post('fileuploader/remove_temp_file', { temp_file: file.path });
    }
    updateValue();
};

const isImage = (fileName) => {
    let ext = fileName.split('.').pop().toLowerCase();
    return ['jpg', 'png', 'gif', 'jpeg', 'bmp'].includes(ext);
};

const maxFileSizeInKB = computed(() => props.maxFileSize * 1024 * 1024);

const setUploadPath = computed(() => utils.setApiPath(props.uploadPath));

const getUploadedFiles = computed(() => {
    return uploadedFilePaths.value.map((path) => {
        let fileName = path.split(/[\\/]/).pop();
        return {
            name: fileName,
            shortName: utils.strEllipsis(fileName, 10),
            isImage: isImage(fileName),
            size: path.includes('temp/') ? '' : 'small',
            path
        };
    });
});

const disableUpload = computed(() => uploadedFilePaths.value.length >= props.fileLimit);

onMounted(() => {
    if (props.modelValue) {
        uploadedFilePaths.value = utils.toArray(props.modelValue);
        uploader.value.uploadedFileCount = uploadedFilePaths.value.length;
    }
});
</script>

<style>
.p-fileupload .p-fileupload-content,
.p-fileupload .p-fileupload-buttonbar {
    padding: 10px;
}
</style>
