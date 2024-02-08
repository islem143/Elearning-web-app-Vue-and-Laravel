<template>
  <div class="p-input-icon-right col-4 surface-100 border-round-lg p-4">
    <InputText
      type="text"
      class="w-full"
      v-model="search"
      placeholder="Search"
      @input="$emit('search-modules', search);"
    />

    <Accordion :multiple="true" :activeIndex="[0, 1, 2]" class="mt-4">
      <AccordionTab header="Categories">
        <!-- <Categories></Categories> -->
        <CheckBoxGroup :list="categories"></CheckBoxGroup>
      </AccordionTab>
      <AccordionTab header="Ratings">
        <Rating v-model="value" :cancel="false" />
      </AccordionTab>
      <AccordionTab header="Difficulty">
        <CheckBoxGroup :list="difficulties"></CheckBoxGroup>
      </AccordionTab>
    </Accordion>
  </div>
</template>

<script setup>
import CheckBoxGroup from "../ui/CheckBoxGroup.vue";
import { ref } from "vue";
const props = defineProps(["page"]);

let categories = ref([
  { name: "Cat1", id: "1" },
  { name: "Cat2", id: "2" },
]);
let difficulties = ref([
  { name: "Easy", id: "1" },
  { name: "Medium", id: "2" },
  { name: "Hard", id: "3" },
]);

let search = ref("");
let value = ref("");

</script>
