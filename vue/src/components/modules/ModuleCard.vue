<template>



        <Card  class="card w-2 ">
            <template #header >
              <img alt="user header" class="w-full" height="120" :src="module.img_url" /></template>
            <template #title > 
              <div class=" flex justify-content-between">
        <h4 class="flex">{{ module.title }}</h4>
       
        <div class="flex ml-4" v-if="role == 'teacher'">
          <Button
           size="small"
            icon="pi pi-pencil"
            class="p-button-rounded p-button-success mr-2"
            @click="$emit('edit-module', module)"
            v-if="role == 'teacher'"
          />

          <Button
          size="small"
            icon="pi pi-trash"
            class="p-button-rounded p-button-danger"
            @click="$emit('confirm-delete-module', module)"
            v-if="role == 'teacher'"
          />
        </div>
      </div> </template>
           
            <template #content class="p-0">
            <ProgressBar
                  v-if="
                    role &&
                    role == 'student' &&
                    (mylist || (module.users && module.users[0]))
                  "
                  class="text-center flex mb-4"
                  :value="(module.completedCourses * 100) / module.totalCourses"
          >
          </ProgressBar>
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

<style>
.p-card{
  padding: 0;
}
.p-card-header	{
  padding: 1rem;
}
.p-card-body{
  padding: 0;
}
.p-card .p-card-content{
  padding: 0;
}
</style>