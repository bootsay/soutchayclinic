<template>
    <div class="md:max-w-[60%] mx-auto">
        <div class="card">
            <div class="flex flex-col items-center">
                <div class="text-pink-500 font-bold text-5xl">404</div>
                <div class="text-gray-700 font-medium text-3xl mb-2">Page not found</div>
                <span class="text-gray-600">Requested resource is not available.</span>

                <div class="flex items-center py-5 mt-6 border-bottom-1">
                    <div class="flex justify-center items-center bg-cyan-400 rounded" style="height:3.5rem; width:3.5rem;">
                        <i class="pi pi-fw pi-table"  style="font-size: 30px"></i>
                    </div>
                    <div class="ml-4">
                        <router-link to="/">
                            <p class="text-gray-700 lg:text-xl font-medium mb-0">Frequently Asked Questions</p>
                        </router-link>
                        <span class="text-gray-600">Link to FAQs</span>
                    </div>
                </div>

                <div class="flex items-center py-5 border-b-1">
                    <div class="flex justify-center items-center bg-orange-400 rounded" style="height:3.5rem; width:3.5rem;">
                        <i class="pi pi-fw pi-question-circle"  style="font-size: 30px"></i>
                    </div>
                    <div class="ml-4">
                        <router-link to="/">
                            <p class="text-gray-700 lg:text-xl font-medium mb-0">Solution Center</p>
                        </router-link>
                        <span class="text-gray-600">Link to support center</span>
                    </div>
                </div>

                <div class="mt-5 text-center">
                    <router-link to="/" class="text-blue-500">
                        <Button icon="pi pi-arrow-left" class="" label="Go to Dashboard" />
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
</script>
