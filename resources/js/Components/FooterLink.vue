<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  href: String,
  text: String,
})
</script>

<template>
  <Link :href="href" class="text-sm text-gray-500 hover:underline">
    {{ text }}
  </Link>
</template>