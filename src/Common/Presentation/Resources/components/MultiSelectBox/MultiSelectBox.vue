<script setup>
import { ref,watch } from "vue";
import { router } from "@inertiajs/core";
import { usePage } from "@inertiajs/vue3";
const auth = computed(() => usePage().props.auth);
let props = defineProps(['items']);
const search = ref('');
const selectedItems = ref(['Select Groups']);

const isAllSelected = computed(() => selectedItems.value.length === filteredItems.value.length);
const filteredItems = computed(() => {
  const searchTerm = search.value.toLowerCase().trim();
  return props.items.filter(item => item.name.toLowerCase().includes(searchTerm));
});

function toggleSelectAll() {
  if (!isAllSelected.value) {
    // If "Select All" is checked, select all items
    selectedItems.value = filteredItems.value.slice(); // Copy all items to selectedItems
  } else {
    // If "Select All" is unchecked, clear the selection
    selectedItems.value = [];
  }
}

function filterItems() {
  // Update the filtered items based on the search term
  // You can add more advanced filtering logic here if needed
  const searchTerm = search.value.toLowerCase().trim();
  filteredItems.value = props.items.filter(item => item.name.toLowerCase().includes(searchTerm));
}
</script>
<template>
    <VSelect
        class="blue-outline-field"
        variant="plain"
        density="compact"
        :items="filteredItems"
        multiple
        item-title="name"
        item-value="id"
        v-model="selectedItems"
    >
        <template v-slot:prepend-item>
        <v-text-field
            v-model="search"
            placeholder="Search Organisations"
            class="select-search"
            type="text"
            prepend-inner-icon="mdi-magnify"
            @input="filterItems"
            dense
        />
        <v-divider class="mt-2"></v-divider>
        <v-list-item
            title="Select All"
            @click="toggleSelectAll"
        >
            <template v-slot:prepend>
            <v-checkbox-btn :input-value="isAllSelected"></v-checkbox-btn>
            </template>
        </v-list-item>
        <v-divider class="mt-2"></v-divider>
        </template>
    </VSelect>
</template>

<style scoped>
.select-search{
    padding: 10px !important;
}
</style>
