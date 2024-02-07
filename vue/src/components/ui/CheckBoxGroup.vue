<template>
  <div v-for="l of list" :key="l.id" class="flex align-items-center">

    <Checkbox
      class="m-2 text-xl"
      v-model="selectedCheckboxs"
      :inputId="l.id"
      name="list"
      :value="l.name"
    />
    <label :for="l.id">{{ l.name }}</label>
  </div>
</template>

<script setup>
import { ref, watch } from "vue";
const props = defineProps(["list"]);
defineEmits(["set-selected-checkboxs"]);
let selectedCheckboxs = ref([]);

watch(selectedCheckboxs, (val) => {
  //emit("set-selected-checkboxs");
});
</script>
