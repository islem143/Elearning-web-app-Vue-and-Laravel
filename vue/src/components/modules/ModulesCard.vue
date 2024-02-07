<template>

  <module-card
    v-for="module in modules"
    :completedCourses="modulesMap[module.id]"
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
  data() {
    return { modulesMap: {} };
  },
  props: ["modules", "mylist", "completedCourses"],
  methods: {
    enroll(module) {
      this.$emit("enroll", module);
    },
  },

  watch: {
    completedCourses(val) {
      if (val && val.length != 0) {
        val.forEach((v) => {
          this.modulesMap[v.module_id] = v.completed_courses;
        });

        
      }
    },
  },
};
</script>
