import { reactive, computed } from 'vue';
import router from '@/router';
import * as api from '@/api/auth';
import { useLocalStorage } from '@/composables/useLocalStorage';
import { IAuthState } from '@/types/auth';

export const useAuthStore = () => {
  const { get, set, remove } = useLocalStorage();

  const state = reactive<IAuthState>({
    token: get('token') || null,
    userId: get('userId') || null,
    error: {
      message: '',
      code: '',
    },
  });

  const isAuthenticated = computed(() => !!state.token);

  const clearToken = () => {
    state.token = null;
    state.userId = null;
    remove('token');
    remove('userId');
  };

  /**
   * Логин
   *
   * @param login
   * @param password
   */
  const login = async (login: string, password: string) => {
    try {
      const user = await api.login(login, password);
      state.token = user.token;
      state.userId = user.user.id;
      set('token', user.token);
      set('userId', user.user.id.toString());
      await router.push('/');
    } catch (error) {
      console.log(error);
      clearToken();
    }
  };

  const logout = async () => {
    await api.logout();
    clearToken();
    await router.push('/login');
  };

  return {
    state,
    isAuthenticated,
    login,
    logout,
    clearToken,
  };
};
