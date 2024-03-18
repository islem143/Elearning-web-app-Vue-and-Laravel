<template>
  <div class="card p-input-icon-right col-4 border-round-lg p-4">
    <h3><i class="pi pi-filter" style="font-size: 1.4rem"></i> Filters</h3>
    <InputText
      type="text"
      class="w-full"
      v-model="params.title"
      placeholder="Search"
      @input="emitSearch"
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
import { useWrapTimeout } from "../../composables/timeout";
const { wrapFunc } = useWrapTimeout();
const props = defineProps(["page"]);
const emit = defineEmits(["search-modules"]);
let categories = ref([]);
const params = ref({ title: "", categories: [] });
let difficulties = ref([
  { name: "Easy", id: "15" },
  { name: "Medium", id: "2" },
  { name: "Hard", id: "3" },
]);
let timeoutId = null;
let value = ref("");

Category.getList().then((res) => {
  categories.value = res;
});

const emitSearch = () => {
  wrapFunc(() => emit("search-modules", params.value), 200);

};
const onSetCheckboxs = (categoriess, type) => {
  switch (type) {
    case "categories":
      params.value.categories = categoriess;
      wrapFunc(() => emit("search-modules", params.value), 200);
     
      break;
  }
};
</script>
