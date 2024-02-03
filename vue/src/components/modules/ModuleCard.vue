<template>



        <Card  class="card  w-18rem surface-0  ">
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
              <span v-if="module.created_by" class="my-1">By: {{ module.created_by.name }}</span>
              <Rating v-if="role=='student'" style="margin-left: -8px"  class="my-2 " :cancel="false" />

            <ProgressBar
                  v-if="
                    role &&
                    role == 'student' &&
                    (mylist || (module.users && module.users[0]))
                  "
                  class="text-center flex  h-1rem	"
                  :value="(module.completedCourses * 100) / module.totalCourses"
          >
          </ProgressBar>
          
          <div v-else class="h-1rem	 w-full "></div>
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
.p-card .p-card-content{
  padding: 0;
}

</style>