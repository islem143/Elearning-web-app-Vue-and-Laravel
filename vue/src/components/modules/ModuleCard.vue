<template>
  <Card class="my-3">
    <template #title>
      <div class="flex justify-content-between">
        <h4>{{ module.title }}</h4>
        <ProgressBar
          v-if="
            role &&
            role == 'student' &&
            (mylist || (module.users && module.users[0]))
          "
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
      <Button
        v-if="role && (mylist || (module.users && module.users[0]))"
        @click="$emit('go-to', module)"
        label="Continue"
      />
      <Button
        v-else-if="role == 'student'"
        @click="$emit('enroll', module)"
        label="Enroll"
      />
      <Button
        v-else-if="role == 'teacher'"
        @click="$emit('go-to', module)"
        label="Edit Courses"
      />
    </template>
  </Card>
</template>

<script>
export default {
  name: "ModuleCard",
  inject: ["role"],
  props: ["module", "mylist"],
};
</script>
