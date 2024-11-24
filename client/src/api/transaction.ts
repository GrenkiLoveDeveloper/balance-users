import axios from '@/plugins/axios';
import { useLocalStorage } from '@/composables/useLocalStorage';
import { IBalance } from '@/types/transaction';
const { get } = useLocalStorage();
const userId = get('userId') ? get('userId') : null;

const getBalance = async (): Promise<IBalance> => {
  return await axios.get(`/api/balance/${userId}`);
};

const getHistory = async ($data: string) => {
  return await axios.get(`/api/history/`, {
    params: {
      id: userId,
      search: $data,
    },
  });
};

export { getBalance, getHistory };
