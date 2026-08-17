<template>
  <div class="min-h-screen bg-zinc-900 text-zinc-100 flex items-center justify-center p-6 selection:bg-teal-500 selection:text-zinc-900">
    <div class="w-full max-w-3xl">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-bold">Lentera — Dev UI</h1>
        <div>
          <template v-if="auth.state.user">
            <span class="mr-4 text-sm">Hi, {{ auth.state.user.name }}</span>
            <button @click="onLogout" class="px-3 py-1 bg-zinc-800 rounded">Logout</button>
          </template>
          <template v-else>
            <button @click="view = 'login'" class="px-3 py-1 bg-teal-500 rounded mr-2">Login</button>
            <button @click="view = 'register'" class="px-3 py-1 bg-zinc-800 rounded">Register</button>
          </template>
        </div>
      </div>

      <div class="grid grid-cols-1 gap-6">
        <div v-if="view === 'home'" class="p-6 bg-zinc-800 rounded-lg border border-zinc-700">
          <h2 class="text-lg font-semibold mb-2">Welcome</h2>
          <p class="text-sm text-zinc-400">Use the buttons above to login or register.</p>
        </div>

        <div v-if="view === 'login'">
          <Login @switch="onSwitch" />
        </div>

        <div v-if="view === 'register'">
          <Register @switch="onSwitch" />
        </div>

        <div v-if="view === 'loggedin'" class="p-6 bg-zinc-800 rounded-lg border border-zinc-700">
          <h2 class="text-lg font-semibold">You are logged in</h2>
          <pre class="text-xs mt-2 text-zinc-300">{{ auth.state.user }}</pre>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import Login from './pages/auth/Login.vue';
import Register from './pages/auth/Register.vue';
import { useAuth } from './core/useAuth';

const view = ref('home');
const auth = useAuth();

const onSwitch = (to) => {
  if (to === 'loggedin') {
    view.value = 'loggedin';
  } else {
    view.value = to;
  }
};

const onLogout = async () => {
  await auth.logout();
  view.value = 'home';
};

onMounted(async () => {
  await auth.fetchUser();
  if (auth.state.user) view.value = 'loggedin';
});

defineProps({
  laravelVersion: {
    type: String,
    default: '11.x'
  },
  phpVersion: {
    type: String,
    default: '8.2'
  }
});
</script>
