import type { AuthResponse } from '~/types'

export class AuthService {
  private api: typeof $fetch;

  constructor(apiClient: typeof $fetch) {
    this.api = apiClient;
  }

  async login(credentials: any): Promise<AuthResponse> {
    const res: any = await this.api('/login', {
      method: 'POST',
      body: credentials
    });
    return res.data;
  }

  async register(data: any): Promise<AuthResponse> {
    const res: any = await this.api('/register', {
      method: 'POST',
      body: data
    });
    return res.data;
  }

  async logout(): Promise<void> {
    await this.api('/logout', { method: 'POST' });
  }
}
