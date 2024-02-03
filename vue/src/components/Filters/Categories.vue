<template>
  <div
    v-for="category of categories"
    :key="category.key"
    class="flex align-items-center"
  >
    <Checkbox
      class="m-2 text-xl"
      v-model="selectedCategories"
      :inputId="category.key"
      name="category"
      :value="category.name"
    />
    <label :for="category.key">{{ category.name }}</label>
  </div>
</template>

<script setup>
import { ref, watch } from "vue";
let categories = ref([
  { name: "cat1", key: "1" },
  { name: "cat2", key: "2" },
]);
let selectedCategories = ref([]);

watch(selectedCategories, (val) => {
  console.log(val);
});
</script>
