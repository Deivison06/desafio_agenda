<template>
  <Head title="Editar Contato" />
  <AuthenticatedLayout>
    <div class="container mt-10">
      <div class="p-8 shadow-2xl bg-stone-200 rounded-xl">
        <div class="mb-8">
          <h2 class="text-2xl font-semibold leading-7 text-gray-900">
            Detalhes do Contato
          </h2>
          <p class="mt-1 text-lg leading-6 text-gray-600">
            Confira abaixo as informações detalhadas do contato. Você pode visualizar e editar os dados conforme necessário.
          </p>
        </div>
        <div class="flex flex-col items-center p-6 rounded-lg md:flex-row">
          <div class="w-40 h-40 mb-6 md:mb-0 md:mr-10">
            <img
              v-if="contact.foto"
              :src="`/storage/${contact.foto}`"
              alt="Foto do contato"
              class="object-cover w-full h-full transition-transform duration-300 rounded-full shadow-xl hover:scale-105"
              style="object-fit: cover"
            />
            <div
              v-else
              class="flex items-center justify-center w-full h-full bg-gray-400 rounded-full shadow-md"
            >
              <span class="text-3xl text-gray-600">
                {{ contact.first_name.charAt(0).toUpperCase() }}
              </span>
            </div>
          </div>
          <div class="ms:text-center md:text-left">
            <h3 class="mb-2 text-3xl font-bold text-gray-800">
              {{ contact.first_name }} {{ contact.last_name }}
            </h3>
            <p class="mb-1 text-lg text-gray-700">
              <span class="font-semibold">Telefone:</span> {{ contact.phone }}
            </p>
            <p class="mb-1 text-lg text-gray-700">
              <span class="font-semibold">Email:</span> {{ contact.email }}
            </p>
            <p class="mb-1 text-lg text-gray-700">
              <span class="font-semibold">Endereço:</span>
              {{ contact.address || "Não informado" }}
            </p>
            <p class="mb-4 text-lg text-gray-700">
              <span class="font-semibold">Notas:</span>
              {{ contact.notes || "Nenhuma nota" }}
            </p>
          </div>
        </div>

        <div
          class="flex justify-center gap-2 p-6 mt-8 border-t border-gray-300 sm:justify-end"
        >
          <Link
            :href="route('dashboard')"
            class="inline-flex items-center px-4 py-2 text-white transition duration-200 ease-in-out bg-blue-500 rounded-md shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
            aria-label="Voltar ao dashboard"
          >
            <svg
              class="w-6 h-6"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 12H5m7 7l-7-7 7-7"
              />
            </svg>

            Voltar
          </Link>
          <Link
            :href="`/contacts/${contact.id}/edit`"
            class="inline-flex items-center px-4 py-2 text-white transition duration-200 ease-in-out bg-yellow-500 rounded-md shadow-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50"
            aria-label="Editar contato"
          >
            <svg
              class="w-4 h-4 mr-2"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
              ></path>
            </svg>
            Editar
          </Link>
          <button
            @click="destroy(contact.id)"
            class="inline-flex items-center px-4 py-2 text-white transition duration-200 ease-in-out bg-red-600 rounded-md shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"
            aria-label="Apagar contato"
          >
            <svg
              class="w-4 h-4 mr-2"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
              ></path>
            </svg>
            Apagar
          </button>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>



  <script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { defineProps } from "vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const props = defineProps({
  contact: {
    type: Object,
    required: true,
  },
});

const destroy = async (contactId) => {
  if (confirm("Tem certeza que deseja apagar este contato?")) {
    try {
      const form = useForm({});

      await form.delete(route("contacts.destroy", contactId), {
        preserveState: true,
        onSuccess: () => {
          console.log("Contato deletado com sucesso!");
          const updatedContacts = contacts.value.filter(
            (contact) => contact.id !== contactId
          );
          props.contacts = updatedContacts;
        },
        onError: (errors) => {
          console.error("Erro ao deletar o contato:", errors);
        },
      });
    } catch (error) {
      console.error("Erro ao executar a operação de deleção:", error);
    }
  }
};
</script>
