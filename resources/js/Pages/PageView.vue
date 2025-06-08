<script setup>
    import { Head } from '@inertiajs/vue3';

    const props = defineProps({
        page: Object
    });

</script>

<template>
    <div>
        <Head :title="props.title" />

        <div class="font-sans text-gray-900 dark:text-gray-100 antialiased py-12">
            <div class="min-h-screen max-w-8xl mx-auto p-6 bg-white dark:bg-grayop-800 shadow-md overflow-hidden sm:rounded-lg">
                <h2 class="font-semibold text-3xl text-gray-800 dark:text-gray-200 leading-tight mb-2">
                    {{ page.title }}
                </h2>
                <div class="prose dark:prose-invert max-w-none" v-html="page.content"></div>
            </div>
        </div>
    </div>
</template>