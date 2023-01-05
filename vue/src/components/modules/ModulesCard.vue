<template>
  <div v-for="module in modules" :key="module.id">
    <module-card
      @confirm-delete-module="$emit('confirm-delete-module', module)"
      @edit-module="$emit('edit-module', module)"
      @go-to="$emit('go-to', module)"
      :module="module"
    />
  </div>
</template>

<script>
import ModuleCard from "./ModuleCard.vue";

export default {
  name: "ModulesCard",
  components: {
    ModuleCard,
  },

  props: ["modules"],
};
</script>
