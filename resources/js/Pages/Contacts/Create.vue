<template>
  <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
      <h1 class="mb-6 text-2xl font-semibold text-gray-900 dark:text-gray-100">
        Criar Contato
      </h1>
      <form @submit.prevent="submit" enctype="multipart/form-data">
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
          <p v-if="form.errors.email" class="mt-1 text-sm text-red-500">
            E-mail já existente.
          </p>
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
        <div class="mb-4">
          <label for="foto" class="block mb-2 text-gray-700 dark:text-gray-300"
            >Foto</label
          >
          <input
            id="foto"
            type="file"
            accept="image/*"
            @change="handleFileUpload"
            class="w-full px-4 py-2 border border-gray-300 rounded-md dark:border-gray-700 focus:outline-none focus:ring focus:border-blue-300 dark:focus:border-blue-700"
          />
        </div>
        <button
          type="submit"
          class="w-full px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-700"
        >
          Criar
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
  name: "",
  email: "",
  phone: "",
  foto: null,
});

const phoneError = ref("");

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

  form.post(route("contacts.store"), {
    onSuccess: () => {
      form.reset();
    },
    onError: (errors) => {
      if (errors.email) {
        form.errors.email = errors.email[0];
      }
    },
  });
};

const handleFileUpload = (event) => {
  form.foto = event.target.files[0];
};
</script>

<style scoped>
body {
  font-family: "Inter", sans-serif;
}
</style>
