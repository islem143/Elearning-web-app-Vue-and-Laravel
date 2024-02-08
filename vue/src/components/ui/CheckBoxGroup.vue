<template>
  <div v-for="l of list" :key="l.id" class="flex align-items-center">
    <Checkbox
      class="m-2 text-xl"
      v-model="selectedCheckboxs"
      :inputId="l.id"
      name="list"
      @change="$emit('set-checkboxs', selectedCheckboxs, type)"
      :value="l.id"
    />
    <label :for="l.id">{{ l.name }}</label>
  </div>
</template>

<script setup>
import { ref, watch } from "vue";
const props = defineProps(["list", "type"]);
defineEmits(["set-selected-checkboxs"]);
let selectedCheckboxs = ref();

</script>
