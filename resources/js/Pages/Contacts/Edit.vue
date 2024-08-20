<template>
    <Head title="Editar" />
  <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
      <h1 class="mb-6 text-2xl font-semibold text-gray-900 dark:text-gray-100">
        Editar Contato
      </h1>
      <form @submit.prevent="submit">
        <div class="mb-4">
          <label for="name" class="block mb-2 text-gray-700 dark:text-gray-300"
            >Nome</label
          >
          <input
            id="name"
            v-model="form.name"
            type="text"
            placeholder="Name"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-md dark:border-gray-700 focus:outline-none focus:ring focus:border-blue-300 dark:focus:border-blue-700"
          />
        </div>
        <div class="mb-4">
          <label for="email" class="block mb-2 text-gray-700 dark:text-gray-300"
            >Email</label
          >
          <input
            id="email"
            v-model="form.email"
            type="email"
            placeholder="Email"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-md dark:border-gray-700 focus:outline-none focus:ring focus:border-blue-300 dark:focus:border-blue-700"
          />
        </div>
        <div class="mb-4">
          <label for="phone" class="block mb-2 text-gray-700 dark:text-gray-300"
            >Celular</label
          >
          <input
            id="phone"
            v-model="form.phone"
            type="text"
            placeholder="Phone"
            @input="validatePhone"
            @keypress="filterNonNumeric"
            class="w-full px-4 py-2 border border-gray-300 rounded-md dark:border-gray-700 focus:outline-none focus:ring focus:border-blue-300 dark:focus:border-blue-700"
          />
          <p v-if="phoneError" class="mt-1 text-sm text-red-500">{{ phoneError }}</p>
        </div>
        <button
          type="submit"
          class="w-full px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-700"
        >
          Atualizar
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import {Head, Link, useForm } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";

const { props } = usePage();
const contact = props.contact;

const form = useForm({
  name: "",
  email: "",
  phone: "",
});

const phoneError = ref("");

onMounted(() => {
  form.name = contact.name;
  form.email = contact.email;
  form.phone = contact.phone;
});

const filterNonNumeric = (event) => {
  const keyCode = event.keyCode || event.which;
  const key = String.fromCharCode(keyCode);
  if (!/^\d$/.test(key)) {
    event.preventDefault();
  }
};

const validatePhone = () => {
  const numericPhone = form.phone.replace(/\D/g, "");
  if (numericPhone.length > 11) {
    phoneError.value = "O número de celular não pode exceder 11 caracteres.";
  } else {
    phoneError.value = "";
  }
  form.phone = numericPhone;
};

const submit = () => {
  if (phoneError.value) {
    return;
  }

  form.patch(route("contacts.update", contact.id), {
    onSuccess: () => {
      console.log("Contato atualizado com sucesso!");
    },
    onError: (errors) => {
      console.error("Erro ao atualizar contato:", errors);
    },
    preserveState: true,
  });
};
</script>

<style scoped>
body {
  font-family: "Inter", sans-serif;
}
</style>
