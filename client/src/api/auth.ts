import axios from '@/plugins/axios';
import { IUser } from '@/types/auth';
/**
 * Авторизация логин
 *
 * @param login
 * @param password
 * @returns
 */
const login = async (login: string, password: string): Promise<IUser> => {
  await axios.get('/sanctum/csrf-cookie');
  return await axios.post('/api/login', {
    login: login,
    password: password,
  });
};

/**
 * Разлогирование
 *
 * @returns
 */
const logout = async () => {
  return await axios.post('/api/logout');
};

export { login, logout };
