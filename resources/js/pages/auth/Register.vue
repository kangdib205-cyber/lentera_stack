<template>
  <div class="max-w-md w-full bg-zinc-800 border border-zinc-700 rounded-2xl p-6 shadow-md">
    <h2 class="text-xl font-bold mb-4">Create account</h2>

    <form @submit.prevent="onSubmit" class="space-y-3">
      <div>
        <label class="text-sm">Name</label>
        <input v-model="name" type="text" class="w-full mt-1 p-2 rounded bg-zinc-900 border border-zinc-700" />
      </div>

      <div>
        <label class="text-sm">Email</label>
        <input v-model="email" type="email" class="w-full mt-1 p-2 rounded bg-zinc-900 border border-zinc-700" />
      </div>

      <div>
        <label class="text-sm">Password</label>
        <input v-model="password" type="password" class="w-full mt-1 p-2 rounded bg-zinc-900 border border-zinc-700" />
      </div>

      <div>
        <label class="text-sm">Confirm Password</label>
        <input v-model="passwordConfirmation" type="password" class="w-full mt-1 p-2 rounded bg-zinc-900 border border-zinc-700" />
      </div>

      <div class="flex items-center justify-between">
        <button type="submit" class="px-4 py-2 bg-teal-500 rounded font-semibold">Register</button>
        <button type="button" @click="$emit('switch','login')" class="text-sm text-zinc-400">Already have account</button>
      </div>

      <div v-if="auth.state.error" class="text-sm text-red-400">{{ auth.state.error }}</div>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useAuth } from '@/core/useAuth';

const emit = defineEmits(['switch']);

const name = ref('');
const email = ref('');
const password = ref('');
const passwordConfirmation = ref('');

const auth = useAuth();

const onSubmit = async () => {
  await auth.register(name.value, email.value, password.value, passwordConfirmation.value);
  if (auth.state.user) {
    emit('switch','loggedin');
  }
};
</script>

<style scoped>
</style>
