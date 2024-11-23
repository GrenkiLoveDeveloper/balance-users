<template>
  <div>
    <TheNavbar />

    <RouterView />
  </div>
</template>
<script setup lang="ts">
import { defineAsyncComponent } from 'vue';
const TheNavbar = defineAsyncComponent(() => import('@/components/TheNavbar.vue'));
import { RouterView } from 'vue-router';
</script>
<style scoped></style>
