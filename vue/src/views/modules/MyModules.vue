<template>
  <div class="grid w-8 m-auto">
    <ModuleListVue />
  </div>
</template>

<script>
import ModuleListVue from "../../components/modules/ModuleListStudent.vue";
export default {
  name: "ModuleList",
  components: {
    ModuleListVue,
  },
};
</script>
