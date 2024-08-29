<script setup>
import Checkbox from "@/Components/Checkbox.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref, computed, watch } from "vue";

const props = defineProps({
  contacts: {
    type: Object,
    default: () => ({ data: [] }),
  },
  search: {
    type: String,
    default: "",
  },
});

const search = ref(props.search || "");

const contacts = computed(() => props.contacts.data);

watch(search, (newSearch) => {
  fetchContacts(newSearch);
});
const fetchContacts = async (searchQuery) => {
  const form = useForm({ search: searchQuery });

  form.get(route("dashboard"), {
    preserveState: true,
    replace: true,
    onSuccess: () => {
      console.log("Contatos atualizados com sucesso!");
    },
    onError: (errors) => {
      console.error("Erro ao buscar contatos:", errors);
    },
  });
};
const destroy = async (contactId) => {
  if (confirm("Tem certeza que deseja apagar este contato?")) {
    try {
      const form = useForm({});
      await form.delete(route("contacts.destroy", contactId), {
        preserveState: true,
        onSuccess: () => {
          console.log("Contato deletado com sucesso!");
          props.contacts = props.contacts.filter(
            (contact) => contact.id !== contactId
          );
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
const updateFavorite = async (contact) => {
  try {
    // Inclua todos os campos do contato
    const updatedContact = {
      ...contact, // Copie todos os campos do contato
      is_favorite: contact.is_favorite, // Atualize apenas o campo is_favorite
    };

    await axios.put(`/contacts/${contact.id}`, updatedContact);
    console.log("Contato atualizado com sucesso!");
  } catch (error) {
    console.error("Erro ao atualizar o contato:", error);
  }
};
</script>

<template>
  <Head title="Contatos" />

  <AuthenticatedLayout>
    <div class="py-6">
      <div class="max-w-5xl px-4 mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-4 sm:p-6 dark:text-gray-100">
            <div class="flex items-center justify-end mb-4">
              <Link
                href="/contacts/create"
                class="inline-block px-4 py-2 font-semibold text-white transition duration-150 ease-in-out bg-blue-500 rounded-lg shadow hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
              >
                Novo Contato
              </Link>
            </div>
            <div class="mb-4 text-gray-400">
              <input
                v-model="search"
                type="text"
                placeholder="Pesquisar contatos..."
                class="px-4 py-2 border border-gray-300 rounded-md"
              />
            </div>
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th
                      class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase"
                    >
                      Name
                    </th>
                    <th
                      class="hidden px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase sm:table-cell"
                    >
                      Email
                    </th>
                    <th
                      class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase"
                    >
                      Foto
                    </th>
                  </tr>
                </thead>
                <tbody
                  class="items-center text-gray-800 bg-white divide-y divide-gray-200"
                >
                  <tr
                    v-for="contact in contacts"
                    :key="contact.id"
                    class="hover:bg-stone-200"
                  >
                    <td class="px-6 py-4 whitespace-nowrap">
                      <Link :href="route('contacts.show', contact.id)">
                        {{ `${contact.first_name} ${contact.last_name}` }}
                      </Link>
                    </td>
                    <td
                      class="hidden px-6 py-4 whitespace-nowrap sm:table-cell"
                    >
                      {{ contact.email }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap sm:table-cell">
                      <img
                        v-if="contact.foto"
                        :src="`/storage/${contact.foto}`"
                        class="w-20 h-20 rounded-full"
                        :alt="`Foto de ${contact.first_name} ${contact.last_name}`"
                      />
                      <div
                        v-else
                        class="flex items-center justify-center w-16 h-16 text-gray-500 bg-gray-200 rounded-full"
                      >
                        {{ contact.first_name.charAt(0).toUpperCase() }}
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div class="mt-4 text-lg text-gray-600">
                <Link
                  v-for="link in props.contacts.links"
                  :key="link.label"
                  :href="link.url"
                  v-html="link.label"
                  :class="[
                    'px-2 py-1',
                    link.active ? 'text-stone-400 font-bold' : '',
                  ]"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
