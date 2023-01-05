<template>
  <Card class="my-3">
    <template #title>
      <div class="flex justify-content-between">
        <h4>{{ module.title }}</h4>
        <ProgressBar
          v-if="role == 'student'"
          class="w-3 text-center"
          :value="(module.completedCourses * 100) / module.totalCourses"
        >
        </ProgressBar>
        <div v-if="role == 'teacher'">
          <Button
            icon="pi pi-pencil"
            class="p-button-rounded p-button-success mr-2"
            @click="$emit('edit-module', module)"
            v-if="role == 'teacher'"
          />

          <Button
            icon="pi pi-trash"
            class="p-button-rounded p-button-danger"
            @click="$emit('confirm-delete-module', module)"
            v-if="role == 'teacher'"
          />
        </div>
      </div>
    </template>
    <template #content>
      {{ module.descprtion }}
      <hr />
      <a
        class="block mt-2 text-lg hover:underline cursor-pointer"
        v-for="course in module.courses"
        :key="course.id"
        >{{ course.title }}</a
      >
    </template>
    <template #footer>
      <Button @click="$emit('go-to', module)" :label="role=='student'?'Get Started':'Edit Courses'" />
    </template>
  </Card>
</template>

<script>
export default {
  name: "ModuleCard",
  inject: ["role"],
  props: ["module"],
};
</script>
