import axios from '@/plugins/axios';
import { IBalance } from '@/types/transaction';

const getBalance = async (userId: number | string): Promise<IBalance> => {
  return await axios.get(`/api/balance/${userId}`);
};

const getHistory = async ($data: string, userId: number | string) => {
  return await axios.get(`/api/history/`, {
    params: {
      id: userId,
      search: $data,
    },
  });
};

export { getBalance, getHistory };
