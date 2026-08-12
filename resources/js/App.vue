<template>
  <div class="min-h-screen bg-zinc-900 text-zinc-100 flex flex-col items-center justify-center p-6 selection:bg-teal-500 selection:text-zinc-900">
    <div class="max-w-md w-full bg-zinc-800 border border-zinc-700 rounded-2xl p-8 shadow-2xl text-center space-y-6">
      <div class="flex justify-center space-x-6">
        <!-- Vue logo SVG -->
        <svg class="h-16 w-16 text-teal-400 drop-shadow-[0_0_15px_rgba(45,212,191,0.3)] animate-pulse" viewBox="0 0 128 128" width="100%" height="100%">
          <path fill="#42b883" d="M78.8,10L64,35.4L49.2,10H5.7L64,111L122.3,10H78.8z"></path>
          <path fill="#35495e" d="M78.8,10L64,35.4L49.2,10H25.6L64,76.5L102.4,10H78.8z"></path>
        </svg>
        <!-- Tailwind CSS logo SVG -->
        <svg class="h-16 w-16 text-sky-400 drop-shadow-[0_0_15px_rgba(56,189,248,0.3)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
        </svg>
      </div>

      <div class="space-y-2">
        <h1 class="text-3xl font-extrabold tracking-tight bg-gradient-to-r from-teal-400 to-sky-400 bg-clip-text text-transparent">
          Vue 3 + Vite + Tailwind
        </h1>
        <p class="text-zinc-400 text-sm">
          Successfully configured in your Laravel application!
        </p>
      </div>

      <div class="bg-zinc-900/50 rounded-xl p-4 border border-zinc-700/50 space-y-3">
        <span class="text-sm font-semibold text-teal-400">Interactive Counter State:</span>
        <div class="flex items-center justify-center space-x-4">
          <button 
            @click="decrement" 
            class="px-4 py-2 bg-zinc-800 hover:bg-zinc-700 text-zinc-300 font-bold rounded-lg border border-zinc-600 transition duration-200 cursor-pointer select-none"
          >
            -
          </button>
          <span class="text-2xl font-mono font-bold w-12 text-center text-white">
            {{ count }}
          </span>
          <button 
            @click="increment" 
            class="px-4 py-2 bg-teal-500 hover:bg-teal-400 text-zinc-950 font-bold rounded-lg transition duration-200 cursor-pointer select-none"
          >
            +
          </button>
        </div>
      </div>

      <div class="text-xs text-zinc-500 pt-2 border-t border-zinc-700/50">
        Environment: Laravel v{{ laravelVersion }} • PHP v{{ phpVersion }}
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const count = ref(0);
const increment = () => count.value++;
const decrement = () => count.value--;

// Hardcoded or can be passed as props/injected
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
