import { defineStore } from 'pinia';

export const useFieldStore = defineStore('field', {
  state: () => ({
    rules: {
      required: (v: unknown) =>
        (Array.isArray(v) && !!v.length) || (!Array.isArray(v) && !!v) || 'Поле обязательно к заполнению',
      minLength: (min: number) => (v: unknown) => !v || v.toString().length >= min || `Минимум ${min} символов`,
    },
  }),
});
