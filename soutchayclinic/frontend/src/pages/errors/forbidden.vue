<template>
    <div class="md:max-w-[50%] mx-auto">
        <div class="card">
            <div class="flex gap-4 flex-col gap-5">
                <div class="flex gap-4 items-center">
                    <Avatar class="bg-pink-500 text-white" size="xlarge" icon="pi pi-lock" />
                    <div class="text-pink-500 font-bold text-5xl">403</div>
                    <div class="text-900 font-medium text-4xl mb-2">Access Denied</div>
                </div>

                <span class="text-gray-600">You do not have the necessary permissions. Please contact your administrator.</span>
                <div class="flex items-center gap-3">
                    <Avatar class="bg-cyan-400" size="large" icon="pi pi-table" />
                    <div>
                        <router-link to="/">
                            <p class="text-900 lg:text-xl font-medium mb-0">Frequently Asked Questions</p>
                        </router-link>
                        <span class="text-gray-600">Link to FAQs</span>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <Avatar class="bg-orange-400" size="large" icon="pi pi-question-circle" />
                    <div>
                        <router-link to="/">
                            <p class="text-900 lg:text-xl font-medium">Solution Center</p>
                        </router-link>
                        <span class="text-gray-600">Link to support center</span>
                    </div>
                </div>
                <div class="text-center">
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
