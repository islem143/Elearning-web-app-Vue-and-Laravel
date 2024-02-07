<template>
  <div class="p-input-icon-right col-4 surface-100 border-round-lg	  p-4">
    <InputText
      type="text"
      class="w-full"
      v-model="search"
      placeholder="Search"
      @input="getModules"
    />

    <Accordion :multiple="true" :activeIndex="[0,1,2]" class="mt-4">
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
import { Module } from "../../api/Modules";
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
let modules = ref([]);
let search = ref("");
let value = ref("");
const getModules = async () => {
  let params = { title: search.value, page: props.page + 1 };

  const res = await Module.GetModules(params);
  console.log(res);
  modules.value = res;
};
</script>
