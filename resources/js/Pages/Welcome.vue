<template>
  <div
    class="min-h-screen bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center p-6"
  >
    <div class="bg-white rounded-lg shadow-xl p-8 max-w-md w-full text-center">
      <h1 class="text-4xl font-bold mb-4 text-gray-800">Agenda Inteligente</h1>
      <p class="text-xl mb-8 text-gray-600">
        Organize seu dia com facilidade e estilo
      </p>

      <div class="space-y-4">
        <Link
          v-if="$page.props.auth.user"
          :href="route('dashboard')"
          class="btn-primary block"
        >
          Acessar Minha Agenda
        </Link>
        <template v-else>
          <Link :href="route('login')" class="btn-primary block mb-4"
            >Entrar</Link
          >
          <Link
            v-if="canRegister"
            :href="route('register')"
            class="btn-secondary block"
            >Criar Conta</Link
          >
        </template>
      </div>
    </div>
  </div>
</template>

  <script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
});
</script>

  <style scoped>
.btn-primary {
  @apply bg-blue-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-600 transition duration-300;
}
.btn-secondary {
  @apply bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition duration-300;
}
</style>
