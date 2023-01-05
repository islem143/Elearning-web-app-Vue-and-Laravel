<template>
  <div class="grid w-8 m-auto">
   

    <ModuleListVue />
  </div>
</template>

<script>
import ModuleListVue from "../../components/modules/ModuleList.vue";
export default {
  name: "ModuleList",
  components: {
    ModuleListVue,
  },
};
</script>
