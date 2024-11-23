<template>
  <section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card bg-dark text-white" style="border-radius: 1rem">
            <div class="card-body p-5 text-center">
              <div class="mb-md-5 mt-md-4 pb-5">
                <h2 class="fw-bold mb-2 text-uppercase">Авторизация</h2>
                <p class="text-white-50 mb-5">Дальше дороги нет! Введите логин и пароль!</p>

                <form @submit.prevent="letsLogin">
                  <div data-mdb-input-init class="form-outline form-white mb-4">
                    <input
                      id="typeLoginX"
                      v-model="form.login"
                      type="text"
                      class="form-control form-control-lg"
                      :class="{ 'is-invalid': errors.login }"
                      @blur="
                        touched.login = true;
                        validateField('login');
                      "
                    />

                    <label class="form-label" for="typeLoginX">Логин</label>
                    <div v-if="errors.login" class="invalid-feedback">
                      {{ errors.login }}
                    </div>
                  </div>

                  <div data-mdb-input-init class="form-outline form-white mb-4">
                    <input
                      id="typePasswordX"
                      v-model="form.password"
                      type="password"
                      class="form-control form-control-lg"
                      :class="{ 'is-invalid': errors.password }"
                      @blur="
                        touched.password = true;
                        validateField('password');
                      "
                    />
                    <label class="form-label" for="typePasswordX">Пароль</label>
                    <div v-if="errors.password" class="invalid-feedback">
                      {{ errors.password }}
                    </div>
                  </div>

                  <button
                    data-mdb-button-init
                    data-mdb-ripple-init
                    class="btn btn-outline-light btn-lg px-5"
                    type="submit"
                    :disabled="!isFormValid"
                  >
                    Войти
                  </button>
                </form>
              </div>

              <div>
                <p class="mb-0">У вас нет аккаунта? <span class="text-white-50 fw-bold">Очень жаль...</span></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { reactive, computed } from 'vue';
import { useAuthStore } from '@/stores/authStore';
import { useFieldStore } from '@/helpers/field';

const authStore = useAuthStore();
const useField = useFieldStore();

const form = reactive<Record<string, string>>({
  login: '',
  password: '',
});

const touched = reactive<Record<string, boolean>>({
  login: false,
  password: false,
});

const errors = reactive<Record<string, string | boolean>>({
  login: '',
  password: '',
});

const validateField = (field: string): void => {
  const rules = useField.rules;
  const value = form[field];

  if (!touched[field]) {
    errors[field] = '';
    return;
  }

  switch (field) {
    case 'login': {
      const result = rules.required(value);
      errors[field] = result === true ? '' : result;
      break;
    }
    case 'password': {
      const result = rules.required(value) || rules.minLength(5)(value);
      errors[field] = result === true ? '' : result;
      break;
    }
    default:
      errors[field] = '';
  }
};

const validateForm = (): boolean => {
  touched.login = true;
  touched.password = true;

  validateField('login');
  validateField('password');

  return !errors.login && !errors.password;
};

const isFormValid = computed(() => !errors.login && !errors.password);

const letsLogin = () => {
  if (validateForm()) {
    authStore.login(form.login, form.password);
  }
};
</script>
