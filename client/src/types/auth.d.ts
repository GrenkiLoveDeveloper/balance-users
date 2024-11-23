interface IUser {
  token: string | null;
  message: string;
  user: {
    id: number;
    name: string;
    email: string;
  };
}

interface IAuthState {
  token: string | null;
  userId: number | null | string;

  error: {
    message: string;
    code: string;
  };
}

export { IUser, IAuthState };
