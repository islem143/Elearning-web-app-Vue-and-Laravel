<template>
  <div class="card p-input-icon-right col-4 border-round-lg p-4">
    <h3><i class="pi pi-filter" style="font-size: 1.4rem"></i> Filters</h3>
    <InputText
      type="text"
      class="w-full"
      v-model="params.title"
      placeholder="Search"
      @input="$emit('search-modules', params)"
    />

    <Accordion :multiple="true" :activeIndex="[0, 1, 2]" class="mt-4">
      <AccordionTab header="Categories">
        <CheckBoxGroup
          @set-checkboxs="onSetCheckboxs"
          type="categories"
          :list="categories"
        ></CheckBoxGroup>
      </AccordionTab>
      <AccordionTab header="Ratings">
        <Rating v-model="value" :cancel="false" />
      </AccordionTab>
      <AccordionTab header="Difficulty">
        <CheckBoxGroup type="diff" :list="difficulties"></CheckBoxGroup>
      </AccordionTab>
    </Accordion>
  </div>
</template>

<script setup>
import CheckBoxGroup from "../ui/CheckBoxGroup.vue";
import Category from "../../api/Category";
import { onMounted, ref } from "vue";
const props = defineProps(["page"]);
const emit = defineEmits(["search-modules"]);
let categories = ref([]);
const params = ref({ title: "", categories: [] });
let difficulties = ref([
  { name: "Easy", id: "1" },
  { name: "Medium", id: "2" },
  { name: "Hard", id: "3" },
]);

let value = ref("");

Category.getList().then((res) => {
  categories.value = res;
});

const onSetCheckboxs = (categoriess, type) => {
  switch (type) {
    case "categories":
      params.value.categories = categoriess;
      emit("search-modules",params.value)
      break;
  }
};
</script>
