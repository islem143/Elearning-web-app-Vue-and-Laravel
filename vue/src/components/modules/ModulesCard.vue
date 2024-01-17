<template>

    <module-card
      v-for="module in modules"
      :key="module.id"
      @confirm-delete-module="$emit('confirm-delete-module', module)"
      @edit-module="$emit('edit-module', module)"
      :mylist="mylist"
      @go-to="$emit('go-to', module)"
      @enroll="enroll"
      :module="module" 
    />
  

 
</template>

<script>
import ModuleCard from "./ModuleCard.vue";

export default {
  name: "ModulesCard",
  components: {
    ModuleCard,
  },

  props: ["modules", "mylist"],
  methods: {
    enroll(module) {
      this.$emit("enroll", module);
    },
  },
};
</script>
