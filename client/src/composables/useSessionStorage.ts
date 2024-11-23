export const useSessionStorage = () => {
  const storagePrefix = 'scratchy__';

  const get = <T>(key: string): T | null => {
    const item = window.sessionStorage.getItem(storagePrefix + key);

    if (!item || item === 'null') {
      return null;
    }

    try {
      return JSON.parse(item);
    } catch (e) {
      const message = 'Ошибка парсинга значения из сессии: ';
      console.log(message);
      return null;
    }
  };

  const set = (key: string, value: any): boolean => {
    let stringifiedValue;

    if (value === undefined) {
      stringifiedValue = null;
    } else {
      stringifiedValue = JSON.stringify(value);
    }

    try {
      window.sessionStorage.setItem(storagePrefix + key, stringifiedValue ?? 'null');
      return true;
    } catch (e) {
      const message = 'Ошибка сохранения в сессии: ';
      console.log(message);
      return false;
    }
  };

  const remove = (key: string): void => {
    window.sessionStorage.removeItem(storagePrefix + key);
  };

  return {
    get,
    set,
    remove,
  };
};
