<template>
  <Head title="Criar Contato" />
  <AuthenticatedLayout>
    <div class="container mt-10">
      <div class="p-10 shadow-2xl bg-stone-200 rounded-xl">
        <h2 class="text-lg font-semibold leading-7 text-gray-900">
          Criar Contato
        </h2>
        <p class="mt-1 text-base leading-6 text-gray-600">
          Preencha as informações de contato abaixo.
        </p>
        <form @submit.prevent="submit" enctype="multipart/form-data">
          <div class="grid grid-cols-1 mt-10 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-3">
              <label
                for="first_name"
                class="block text-sm font-medium leading-6 text-gray-900"
                >Nome</label
              >
              <div class="mt-2">
                <input
                  id="first_name"
                  v-model="form.first_name"
                  type="text"
                  required
                  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                />
              </div>
            </div>

            <div class="sm:col-span-3">
              <label
                for="last_name"
                class="block text-sm font-medium leading-6 text-gray-900"
                >Sobrenome</label
              >
              <div class="mt-2">
                <input
                  id="last_name"
                  v-model="form.last_name"
                  type="text"
                  required
                  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                />
              </div>
            </div>

            <div class="sm:col-span-3">
              <label
                for="email"
                class="block text-sm font-medium leading-6 text-gray-900"
                >Email</label
              >
              <div class="mt-2">
                <input
                  id="email"
                  v-model="form.email"
                  type="email"
                  required
                  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                />
              </div>
            </div>

            <div class="sm:col-span-3">
              <label
                for="phone"
                class="block text-sm font-medium leading-6 text-gray-900"
              >
                Celular
              </label>
              <div class="mt-2">
                <input
                  id="phone"
                  v-model="form.phone"
                  type="text"
                  required
                  @input="maskPhone"
                  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                />
              </div>
            </div>

            <div class="col-span-full">
              <label
                for="address"
                class="block text-sm font-medium leading-6 text-gray-900"
                >Endereço</label
              >
              <div class="mt-2">
                <input
                  id="address"
                  v-model="form.address"
                  type="text"
                  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                />
              </div>
            </div>

            <div class="col-span-full">
              <label
                for="foto"
                class="block text-sm font-medium leading-6 text-gray-900"
                >Foto</label
              >
              <div class="flex items-center mt-2 gap-x-3">
                <input
                  id="foto"
                  type="file"
                  accept="image/*"
                  @change="handleFileUpload"
                  class="block w-full text-sm text-gray-900 cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                />
              </div>
            </div>

            <div class="col-span-full">
              <label
                for="notes"
                class="block text-sm font-medium leading-6 text-gray-900"
                >Notas</label
              >
              <div class="mt-2">
                <textarea
                  id="notes"
                  v-model="form.notes"
                  rows="3"
                  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                ></textarea>
              </div>
            </div>
          </div>
          <div class="flex justify-end mt-8">
            <button
              type="submit"
              class="px-3 py-2 text-sm font-semibold text-white bg-blue-500 rounded-md shadow-sm hover:bg-blue-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
            >
              Salvar
            </button>
          </div>
        </form>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref } from "vue";
import { Head, useForm } from "@inertiajs/vue3";

const form = useForm({
  first_name: "",
  last_name: "",
  email: "",
  phone: "",
  address: "",
  notes: "",
  foto: null,
});

const phoneError = ref("");

const maskPhone = () => {
  let numericPhone = form.phone.replace(/\D/g, "");
  if (numericPhone.length > 11) numericPhone = numericPhone.slice(0, 11);

  const ddd = numericPhone.slice(0, 2);
  const part1 = numericPhone.slice(2, 7);
  const part2 = numericPhone.slice(7, 11);

  form.phone = `(${ddd}) ${part1}-${part2}`;
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
