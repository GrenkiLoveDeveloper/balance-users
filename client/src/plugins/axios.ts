import axios from 'axios';
import { useLocalStorage } from '@/composables/useLocalStorage';

const { get, remove } = useLocalStorage();
const UNAUTHORIZED = 401;
const UNAUTHENTICATED = 419;

// axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*'
axios.defaults.baseURL = import.meta.env.VITE_BACKEND;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.post['Content-Type'] = 'application/json';
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

axios.interceptors.request.use(
  config => {
    const token = get('token');

    if (token) {
      config.headers['Authorization'] = `Bearer ${token}`;
    }
    return config;
  },
  error => {
    return Promise.reject(error);
  },
);

axios.interceptors.response.use(
  response => {
    const message = response.data?.message;
    console.log(message);

    return response.data;
  },
  error => {
    const status = error?.response?.status;
    const message = error?.response?.data?.message ? error.response.data.message : ' Ошибка запроса';

    console.log(message);

    if (status == UNAUTHORIZED || status == UNAUTHENTICATED) {
      remove('token');
      // window.location.reload();
    }

    throw error;
  },
);

export default axios;
