<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3">
    <div class="container-fluid">
      <RouterLink class="navbar-brand" to="/">Домой</RouterLink>

      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <RouterLink class="nav-link mx-2" to="/about">About</RouterLink>
          </li>

          <li class="nav-item">
            <a class="nav-link mx-2" href="javascript:void(0)" @click="logout">Выйти</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script setup lang="ts">
import { RouterLink } from 'vue-router';
import { useAuthStore } from '@/stores/authStore';

const { logout } = useAuthStore();
</script>

<style scoped></style>
