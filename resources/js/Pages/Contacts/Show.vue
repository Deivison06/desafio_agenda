<template>
  <GuestLayout>
    <div
      class="max-w-2xl p-8 mx-auto bg-white rounded-lg shadow-md"
    >
      <h1 class="mb-6 text-2xl font-semibold text-gray-900">
        Detalhes do Contato
      </h1>

      <div class="mb-4">
        <InputLabel for="name" value="Name" />
        <p
          class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md "
        >
          {{ contact.name }}
        </p>
      </div>

      <div class="mb-4">
        <InputLabel for="email" value="Email" />
        <p
          class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md "
        >
          {{ contact.email }}
        </p>
      </div>

      <div class="mb-4">
        <InputLabel for="phone" value="Phone" />
        <p
          class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md "
        >
          {{ contact.phone }}
        </p>
      </div>

      <div v-if="contact.foto" class="mb-4">
        <InputLabel for="foto" value="Photo" />
        <img
          :src="`/storage/${contact.foto}`"
          alt="Contact Photo"
          class="w-full rounded-lg"
        />
      </div>
    </div>
  </GuestLayout>
</template>

  <script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import { defineProps } from "vue";

const props = defineProps({
  contact: {
    type: Object,
    required: true,
  },
});
</script>
