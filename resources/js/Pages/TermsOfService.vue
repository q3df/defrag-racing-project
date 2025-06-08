<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticationCardLogo from '@/Components/Laravel/AuthenticationCardLogo.vue';

defineProps({
    terms: String,
});
</script>

<template>
    <Head title="Terms of Service" />

    <div class="font-sans text-gray-900 dark:text-gray-100 antialiased pb-12">
        <div class="pt-4">
            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                <div>
                    <AuthenticationCardLogo />
                </div>

                <div class="max-w-8xl mx-auto mt-6 p-6 bg-white dark:bg-grayop-800 shadow-md overflow-hidden sm:rounded-lg">
                    <div class="prose dark:prose-invert max-w-none" v-html="terms" />
                </div>
            </div>
        </div>
    </div>
</template>
