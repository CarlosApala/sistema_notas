<template>
  <div class="flex flex-wrap justify-center mt-4">
    <template v-for="(link, index) in links" :key="index">
      <component
        :is="link.url ? 'Link' : 'span'"
        :href="link.url"
        v-html="link.label"
        class="px-3 py-1 mx-1 rounded border text-sm"
        :class="{
          'bg-blue-500 text-white': link.active,
          'text-gray-700 hover:bg-gray-200': !link.active && link.url,
          'text-gray-400': !link.url,
        }"
      />
    </template>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  links: Array
})
</script>
