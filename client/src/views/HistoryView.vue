<template>
  <section>
    <div class="container">
      <h1>История операций</h1>
      <form class="mb-4" @submit.prevent="searchDescr">
        <div class="input-group">
          <input v-model="search" type="text" name="search" class="form-control" placeholder="Поиск по описанию" />
          <button type="submit" class="btn btn-primary">Поиск</button>
        </div>
      </form>
      <table class="table">
        <thead>
          <tr>
            <th>Дата</th>
            <th>Описание</th>
            <th>Тип</th>
            <th>Сумма</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="list in listData" :key="list.id">
            <td>{{ dayjs(list.created_at).format('DD.MM.YYYY') }}</td>
            <td>{{ list.description }}</td>
            <td>{{ list.type === 1 ? 'Начисление' : 'Списание' }}</td>
            <td>{{ list.amount }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import * as api from '@/api/transaction';
import dayjs from 'dayjs';
const listData = ref();
const search = ref('');

const searchDescr = async () => {
  const { data } = await api.getHistory(search.value);
  listData.value = data;
};

onMounted(async () => {
  const { data } = await api.getHistory(search.value);
  listData.value = data;
});
</script>
<style scoped></style>
