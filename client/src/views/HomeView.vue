<template>
  <main>
    <div class="container">
      <h1 class="text-center">Добро пожаловать, путник!</h1>
      <div class="row mt-4">
        <div class="col-md-6">
          <h3>
            Ваш баланс: <span id="balance">{{ data?.balance ?? 'Загрузка' }}</span>
          </h3>
        </div>
      </div>
      <div class="row mt-4">
        <table v-if="data?.transactions" class="table table-dark">
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
import { useLocalStorage } from '@/composables/useLocalStorage';
const { get } = useLocalStorage();

const intervalId: Ref<number | null> = ref(null);
const data = ref();

const userId = ref(get('userId') ? get('userId') : null);

onMounted(async () => {
  if (userId.value) {
    data.value = await api.getBalance(userId.value);

    intervalId.value = setInterval(async () => {
      data.value = await api.getBalance(userId.value);
    }, 10000);
  }
});

onUnmounted(() => {
  if (intervalId.value) {
    clearInterval(intervalId.value);
  }
});
</script>
