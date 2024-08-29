<template>
  <Head title="Home" />
  <div class="flex items-center justify-center min-h-screen p-6 bg-gray-50">
    <div class="w-full max-w-md p-8 text-center rounded-lg shadow-2xl bg-stone-200">
      <h1 class="mb-4 text-3xl font-black text-gray-900">Agenda de Contatos</h1>
      <p class="mb-8 text-lg text-gray-600">
        Organize seus contatos de maneira simples e eficiente.
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
          <Link :href="route('login')" class="block btn-primary"> Entrar </Link>
          <Link
            v-if="canRegister"
            :href="route('register')"
            class="block btn-secondary"
          >
            Criar Conta
          </Link>
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
  @apply bg-blue-500 text-white px-4 py-2 rounded-md font-semibold shadow-sm hover:bg-blue-600 transition duration-200;
}
.btn-secondary {
  @apply bg-white text-gray-800 px-4 py-2 rounded-md font-semibold shadow-sm hover:bg-gray-100 transition duration-200;
}
</style>
