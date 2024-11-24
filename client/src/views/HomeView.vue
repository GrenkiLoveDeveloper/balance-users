<template>
  <main>
    <div class="container">
      <h1 class="text-center">Добро пожаловать, путник!</h1>
      <div class="row mt-4">
        <div class="col-md-6">
          <h3>Ваш баланс: <span id="balance"></span></h3>
        </div>
      </div>
      <div class="row mt-4">
        <table v-if="data" class="table table-dark">
          <thead>
            <tr>
              <th>Дата</th>
              <th>Описание</th>
              <th>Тип</th>
              <th>Сумма</th>
            </tr>
          </thead>
          <tbody id="transactions">
            <tr v-for="list in data.transactions" :key="list.id">
              <td>{{ dayjs(list.created_at).format('DD.MM.YYYY') }}</td>
              <td>{{ list.description }}</td>
              <td>{{ list.type === 1 ? 'Начисление' : 'Списание' }}</td>
              <td>{{ list.amount }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </main>
</template>

<script setup lang="ts">
import { ref, onMounted, Ref, onUnmounted } from 'vue';
import * as api from '@/api/transaction';
import dayjs from 'dayjs';
const intervalId: Ref<number | null> = ref(null);
const data = ref();

onMounted(async () => {
  data.value = await api.getBalance();

  intervalId.value = setInterval(async () => {
    data.value = await api.getBalance();
  }, 10000);
});

onUnmounted(() => {
  if (intervalId.value) {
    clearInterval(intervalId.value);
  }
});
</script>
