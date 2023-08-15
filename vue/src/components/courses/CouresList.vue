<template>
  <div>
    <Chip
      label="Completed"
      class="py-1 px-3 cursor-pointer font-bold text-900 hover:surface-400 mr-2 mb-3 custom-chip"
    />
     
      <Card v-if="courses.length==0" class="text-center"> 
    <template #title>There are no courses for this module. </template>
    
</Card>
    <CourseCardVue
     v-else
      @get-course="$emit('get-course', course)"
      @delete-course="deleteCourse"
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
  methods: {
    deleteCourse(id) {
      this.$emit("delete-course", id);
    },
  },
};
</script>

<style lang="scss" scoped>
// .p-chip.custom-chip {
//   background: var(--primary-color);
//   color: var(--primary-color-text);
// }
</style>
