export const useLocalStorage = () => {
  const storagePrefix = 'scratchy__';

  const get = <T>(key: string): T | null => {
    const item = window.localStorage.getItem(storagePrefix + key);

    if (!item || item === 'null') {
      return null;
    }

    try {
      return JSON.parse(item);
    } catch (e) {
      const message = 'Ошибка парсинга значения из локального хранилища: ';
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
      window.localStorage.setItem(storagePrefix + key, stringifiedValue ?? 'null');
      return true;
    } catch (e) {
      const message = 'Ошибка сохранения в локальное хранилище: ';
      console.log(message);
      return false;
    }
  };

  const remove = (key: string): void => {
    window.localStorage.removeItem(storagePrefix + key);
  };

  return {
    get,
    set,
    remove,
  };
};
