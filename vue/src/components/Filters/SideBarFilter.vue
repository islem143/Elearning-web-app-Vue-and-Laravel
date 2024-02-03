<template>
  <div class="p-input-icon-right col-4 surface-200 border-round-lg	  p-4">
    <InputText
      type="text"
      class="w-full"
      v-model="search"
      placeholder="Search"
      @input="getModules"
    />

    <Accordion :multiple="true" :activeIndex="[0,1]" class="mt-4">
      <AccordionTab header="Categories">
        <Categories></Categories>
      </AccordionTab>
      <AccordionTab header="Ratings">
        <Rating v-model="value" :cancel="false" />

      </AccordionTab>
    </Accordion>

 

  </div>
</template>

<script setup>
import { Module } from "../../api/Modules";
import Categories from "./Categories.vue";
import { ref } from "vue";
const props = defineProps(["page"]);
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
