interface IBalance {
  balance: string | int;
  transactions: Record<string, string | number>;
}

export { IBalance };
