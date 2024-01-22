<template>



        <Card  class="card col-6  flex ">
            <template #header  >
              <img alt="user header" class="w-full" height="150" :src="module.img_url" />
            </template>
            <template #title > 
              <div class=" flex justify-content-between w-full">
        <h4 class="flex h-2rem">{{ module.title }}</h4>
       
        <div class="flex ml-4" v-if="role == 'teacher'">
          <Button
           size="small"
           style="width: 30px;height: 30px;"
            icon="pi pi-pencil"
            class="p-button-rounded p-button-success mr-2"
            @click="$emit('edit-module', module)"
            v-if="role == 'teacher'"
          />

          <Button
           size="small"
           style="width: 30px;height: 30px;"
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
                  class="text-center flex mb-4 h-1rem	"
                  :value="(module.completedCourses * 100) / module.totalCourses"
          >
          </ProgressBar>
          <div v-else class="h-1rem	 w-full mb-4"></div>
              {{ module.descprtion }}
      <hr />
    
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
  padding: 0.8rem;
}
</style>