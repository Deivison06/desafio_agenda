<template>
  <Head title="Home" />
  <div
    class="flex items-center justify-center min-h-screen p-6 bg-gradient-to-r from-blue-400 to-purple-500"
  >
    <div class="w-full max-w-md p-8 text-center bg-white rounded-lg shadow-xl">
      <h1 class="mb-4 text-4xl font-bold text-gray-800">Agenda Inteligente</h1>
      <p class="mb-8 text-xl text-gray-600">
        Organize seu dia com facilidade e estilo
      </p>

      <div class="space-y-4">
        <Link
          v-if="$page.props.auth.user"
          :href="route('dashboard')"
          class="block btn-primary"
        >
          Acessar Minha Agenda
        </Link>
        <template v-else>
          <Link :href="route('login')" class="block mb-4 btn-primary"
            >Entrar</Link
          >
          <Link
            v-if="canRegister"
            :href="route('register')"
            class="block btn-secondary"
            >Criar Conta</Link
          >
        </template>
      </div>
    </div>
  </div>
</template>

  <script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";

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
