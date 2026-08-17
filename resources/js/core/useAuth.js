import { reactive } from 'vue';

const state = reactive({
  user: null,
  loading: false,
  error: null,
});

export function useAuth() {
  const fetchUser = async () => {
    try {
      const res = await fetch('/api/auth/user', { credentials: 'include' });
      if (!res.ok) {
        state.user = null;
        return null;
      }
      const data = await res.json();
      state.user = data.user;
      return data.user;
    } catch (e) {
      state.user = null;
      return null;
    }
  };

  const login = async (email, password) => {
    state.loading = true;
    state.error = null;
    try {
      const res = await fetch('/api/auth/login', {
        method: 'POST',
        credentials: 'include',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email, password }),
      });

      const data = await res.json();
      if (!res.ok) {
        state.error = data.message || 'Login failed';
        state.loading = false;
        return null;
      }
      state.user = data.user;
      state.loading = false;
      return data.user;
    } catch (e) {
      state.error = e.message;
      state.loading = false;
      return null;
    }
  };

  const register = async (name, email, password, password_confirmation) => {
    state.loading = true;
    state.error = null;
    try {
      const res = await fetch('/api/auth/register', {
        method: 'POST',
        credentials: 'include',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ name, email, password, password_confirmation }),
      });

      const data = await res.json();
      if (!res.ok) {
        state.error = data.message || (data.errors && Object.values(data.errors).flat().join(', ')) || 'Register failed';
        state.loading = false;
        return null;
      }
      state.user = data.user;
      state.loading = false;
      return data.user;
    } catch (e) {
      state.error = e.message;
      state.loading = false;
      return null;
    }
  };

  const logout = async () => {
    try {
      await fetch('/api/auth/logout', { method: 'POST', credentials: 'include' });
    } finally {
      state.user = null;
    }
  };

  return { state, fetchUser, login, register, logout };
}
