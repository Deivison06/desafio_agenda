<template>
  <Head title="Editar Contato" />
  <AuthenticatedLayout>
    <div class="container mt-10">
      <div class="p-10 shadow-2xl bg-stone-200 rounded-xl">
        <h2 class="text-lg font-semibold leading-7 text-gray-900">
          Editar Contato
        </h2>
        <p class="mt-1 text-base leading-6 text-gray-600">
          Atualize as informações de contato abaixo.
        </p>

        <form @submit.prevent="submit">
          <div class="grid grid-cols-1 mt-10 gap-x-6 gap-y-8 sm:grid-cols-6">
            <!-- Nome -->
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
                <p
                  v-if="form.errors.first_name"
                  class="mt-1 text-sm text-red-500"
                >
                  {{ form.errors.first_name }}
                </p>
              </div>
            </div>

            <!-- Sobrenome -->
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
                <p
                  v-if="form.errors.last_name"
                  class="mt-1 text-sm text-red-500"
                >
                  {{ form.errors.last_name }}
                </p>
              </div>
            </div>

            <!-- Email -->
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
                <p v-if="form.errors.email" class="mt-1 text-sm text-red-500">
                  {{ form.errors.email }}
                </p>
              </div>
            </div>

            <!-- Celular -->
            <div class="sm:col-span-3">
              <label
                for="phone"
                class="block text-sm font-medium leading-6 text-gray-900"
                >Celular</label
              >
              <div class="mt-2">
                <input
                  id="phone"
                  v-model="form.phone"
                  type="text"
                  @input="validatePhone"
                  @keypress="filterNonNumeric"
                  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                />
                <p v-if="phoneError" class="mt-1 text-sm text-red-500">
                  {{ phoneError }}
                </p>
              </div>
            </div>

            <!-- Endereço -->
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
                <p v-if="form.errors.address" class="mt-1 text-sm text-red-500">
                  {{ form.errors.address }}
                </p>
              </div>
            </div>

            <!-- Notas -->
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
                <p v-if="form.errors.notes" class="mt-1 text-sm text-red-500">
                  {{ form.errors.notes }}
                </p>
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
import { ref, onMounted } from "vue";
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";

const { props } = usePage();
const contact = props.contact;

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

onMounted(() => {
  form.first_name = contact.first_name;
  form.last_name = contact.last_name;
  form.email = contact.email;
  form.phone = contact.phone;
  form.address = contact.address;
  form.notes = contact.notes;
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
  validatePhone();
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
