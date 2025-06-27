import { useAppStore } from 'src/store/app';
import { useRoute, useRouter } from 'vue-router';
import { useToast } from 'primevue/usetoast';

import { useAppMenus } from 'src/menus';
import { useApiService } from 'src/services/api';
import { useStorageService } from 'src/services/storage';
import { $t } from 'src/services/i18n';

const basePath = import.meta.env.VITE_PUBLIC_URL || '/';

export function useApp() {

    const store = useAppStore();
    const route = useRoute();
    const router = useRouter();
    const toast = useToast();
    const menus = useAppMenus();
    const localStore = useStorageService();
    const apiService = useApiService();

    function isDialogOpen() {
        return store.isDialogOpen;
    }

    function isDesktop() {
        return window.innerWidth >= 992;
    }

    function openImageDialog(pageData) {
        store.openImageDialog(pageData);
    }

    function openFullScreenLoading(msg) {
        store.openFullScreenLoading(msg);
    }

    function openPageDialog(pageData) {
        store.openPageDialog(pageData);
    }

    function openPageDrawer(pageData) {
        store.openPageDrawer(pageData);
    }

    function closeDialogs() {
        store.closeDialogs();
    }

    function closeFullScreenLoading() {
        store.closeFullScreenLoading();
    }

    function setPageTitle(pageName, title) {
        if (pageName === route.name && title) {
            document.title = title;
        }
    }

    function flashMsg(title, detail, type) {
        if (title || detail) {
            let severity = type || 'success';
            toast.add({ severity, summary: title, detail, life: 3000 });
        }
    }

    function navigateTo(path) {
        if (path && route.path !== path) {
            router.push(path);
        }
    }

    function showPageRequestError(error, title, autoLogout = true) {
        console.error(error);
        const xhrRequest = error?.request;
        const defaultMsg = error || $t('errorProcessingRequest'); // if error is not a api request error.
        let errorList = [defaultMsg];
        if (xhrRequest) {
            let errorData = xhrRequest.response;
            if (typeof errorData === 'string') {
                try {
                    // if error message is valid json data
                    errorData = JSON.parse(errorData);
                } catch (ex) {
                    //not a valid json. Display as simple message
                    //console.error(ex);
                }
            }
            if (Array.isArray(errorData)) {
                errorList = errorData;
            } else if (typeof errorData === 'object') {
                errorList = Object.values(errorData);
            } else {
                errorList = [errorData.toString()];
            }
        }

        const detail = errorList.join('\n');
        const summary = title || $t('requestError');
        const severity = 'error';
        const duration = 5000;
        toast.add({ severity, summary, detail, life: duration });

        if (autoLogout && xhrRequest?.status === 401) {
            //token might have expired
            //logout user and navigate to login page
            localStore.removeLoginData();
            location.href = basePath;
        }
    }

    async function downloadReport(reportUrl, downloadFileName) {
        try {
            openFullScreenLoading('Exporting...');
            const response = await apiService.download(reportUrl);
            closeFullScreenLoading();
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', downloadFileName);
            document.body.appendChild(link);
            link.click();
            link.remove();
        } catch (ex) {
            closeFullScreenLoading();
            console.error(ex);
            flashMsg('Download file', 'Unable to download file', 'error');
        }
    }

    async function printReport(reportUrl) {
        try {
            openFullScreenLoading('Exporting...');
            const response = await apiService.get(reportUrl);
            closeFullScreenLoading();
            let w = window.open(window.location.href, '_blank');
            w.document.open();
            w.document.write(response.data);
            w.document.close();
            w.window.onload = function () {
                w.window.print();
            };
        } catch (ex) {
            closeFullScreenLoading();
            console.error(ex);
            flashMsg('Print Report', 'Unable to print report', 'error');
        }
    }

    return {
        $t,
        menus,
        basePath,
        localStore,
        isDialogOpen,
        isDesktop,
        openFullScreenLoading,
        openImageDialog,
        openPageDialog,
        openPageDrawer,
        closeDialogs,
        closeFullScreenLoading,
        setPageTitle,
        flashMsg,
        navigateTo,
        showPageRequestError,
        printReport,
        downloadReport
    };
}
