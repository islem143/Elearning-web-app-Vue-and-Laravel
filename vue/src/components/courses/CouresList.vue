<template>
  <div>
    <Chip
      label="Completed"
      class="py-1 px-3 cursor-pointer font-bold text-900 hover:surface-400 mr-2 mb-3 custom-chip"
    />

    <CourseCardVue
      @get-course="$emit('get-course', course)"
      v-for="course in courses"
      :key="course.id"
      :course="course"
    />
  </div>
</template>

<script>
import CourseCardVue from "./CourseCard.vue";
import axios from "../../http";
export default {
  name: "CourseList",
  props: {
    courses: {
      type: Array,
    },
  },

  created() {},
  components: {
    CourseCardVue,
  },
  methods() {},
};
</script>

<style lang="scss" scoped>
// .p-chip.custom-chip {
//   background: var(--primary-color);
//   color: var(--primary-color-text);
// }
</style>
