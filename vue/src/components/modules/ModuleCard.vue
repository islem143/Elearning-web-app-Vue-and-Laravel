<template>
  <Card
    class="p-2 flex bg-white m-4 border-round-xl transition-all transition-duration-200 shadow-4 hover:shadow-6"
  >
    <template #header>
      <img
        alt="user header"
        class="border-round-md"
        width="220"
        height="250"
        :src="module.img_url"
      />
    </template>
    <template #title>
      <div class="flex justify-content-between w-full">
        <h4 class="flex mb-0">{{ module.title }}</h4>

        <div class="w-6">
          <ProgressBar
            v-if="
              role &&
              role == 'student' &&
              (mylist || (module.users && module.users[0]))
            "
            class="text-center flex h-1rem my-2"
            :value="(completedCourses * 100) / module.total_courses"
          >
          </ProgressBar>
        </div>
        <div class="flex ml-4" v-if="role == 'teacher'">
          <Button
            size="small"
            style="width: 30px; height: 30px"
            icon="pi pi-pencil"
            class="p-button-rounded p-button-success mr-2"
            @click="$emit('edit-module', module)"
            v-if="role == 'teacher'"
          />

          <Button
            size="small"
            style="width: 30px; height: 30px"
            icon="pi pi-trash"
            class="p-button-rounded p-button-danger"
            @click="$emit('confirm-delete-module', module)"
            v-if="role == 'teacher'"
          />
        </div>
      </div>
    </template>

    <template #content class="p-0 flex-1">
      <p class="m-0">{{ module.descprtion }}</p>

      <Rating style="margin-left: -8px" class="my-2" :cancel="false" />

      <hr />
      <div class="flex gap-3">
        <p>
          <i class="pi pi-book mr-2 mb-1 p-0" style="font-size: 1.2rem"></i>
          <span>{{ module.total_courses }} Courses</span>
        </p>
        <p v-if="role == 'teacher'">
          <i class="pi pi-user mr-2 mb-1 p-0" style="font-size: 1.2rem"></i>
          <span>{{ module.total_users }} Students</span>
        </p>
      </div>

      <div class="flex gap-1 mt-1" v-if="module.category">
        <p class="m-0">
          <i class="pi pi-tag p-0 mb-0" style="font-size: 1.2rem"></i>
          Category:
        </p>
        <div class="flex align-items-center gap-1 ml-2">
          {{ module.category.name }}
        </div>
      </div>
      <p v-if="module.created_by" class="mt-1 font-light">
        {{ module.created_by.name }}
      </p>
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
        size="small"
      />
    </template>
  </Card>
</template>

<script>
export default {
  name: "ModuleCard",
  inject: ["role"],
  props: ["module", "mylist", "completedCourses", "id"],
};
</script>

<style>
.p-card .p-card-content {
  padding: 0;
}
.p-card-body {
  width: 100%;
}
</style>
