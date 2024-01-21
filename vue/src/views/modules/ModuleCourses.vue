<template>
  <div class="card pt-0 px-0 p-fluid bg-white w-10 mx-auto">
    <div class="p-4 text-white border-round-top m-0 bg-blue-300">
      <h3>Module: {{ info.title }}</h3>
    </div>
    <div class="p-5">
      <div class="flex justify-content-between mb-5">
        <h3>Courses</h3>
        <router-link
          v-if="role == 'teacher'"
          :to="{ name: 'course-create', params: { moduleId: id } }"
        >
          <Button
            style="width: 145px"
            icon="pi pi-plus"
            class="ml-5"
            label="Add Course"
          />
        </router-link>
      </div>
      <Toast />
    <ConfirmDialog></ConfirmDialog>
      <CouresListVue
        @get-course="getCourse"
        @get-courses="getCourses"
        @delete-course="confirmDelete"
        :courses="courses"
      />
    </div>
  </div>
</template>

<script>
import ModuleInfoVue from "../../components/modules/ModuleInfo.vue";
import CouresListVue from "../../components/courses/CouresList.vue";
import axios from "../../http";
import Course from "../../api/Course";
export default {
  inject: ["role"],
  name: "ModuleCourses",
  components: {
    ModuleInfoVue,
    CouresListVue,
  },
  data() {
    return {
      id: null,
      info: {
        title: "",
        description: "",
        img_url: "",
      },
      courses: [],
    };
  },
  beforeRouteUpdate(to, from) {
    let id = this.$route.params.moduleId;
    this.id = id;
    axios.get("/api/module/" + id).then((res) => {
      this.info.title = res.data.title;
      this.info.description = res.data.descprtion;
      this.info.img_url = res.data.img_url;

      axios.get("/api/module/" + id + "/course").then((res) => {
        this.courses = res.data;
      });
    });
  },
  async created() {
    let id = this.$route.params.moduleId;
    this.id = id;
    await this.getModule();
    this.getCourses();
  },
  methods: {
    confirmDelete(id) {
            this.$confirm.require({
                message: 'Are you sure you want to delete the course?',
                header: 'Confirmation',
                icon: 'pi pi-exclamation-triangle',
                accept: async() => {
                  try{
                    await this.deleteCourse(id);
                    this.$toast.add({ severity: 'info', summary: 'Confirmed', detail: 'CourseDeleted', life: 3000 });

                  }catch(err){
                    this.$toast.add({ severity: 'error', summary: 'Error', detail: 'An error occured', life: 3000 });
                  }
                },

            });
        },
    deleteCourse(id) {
     
      return axios
        .delete("/api/module/" + this.$route.params.moduleId + "/course/" + id)
        .then((res) => {
          console.log("yes");
     
          let index = this.courses.findIndex((val) => val.id == id);
          this.courses.splice(index, 1);
          return Promise.resolve();
        }).catch(err=>{
          return Promise.reject(err);
        });
    },
    async getCourses() {
      let courses = await Course.getCourses(this.id);
      this.courses = courses;
    },
    getCourse(course) {
      axios
        .get("/api/module/" + this.id + "/course/" + course.id)
        .then((res) => {
          console.log(res);
          let index = this.courses.findIndex((c) => c.id == course.id);
          this.courses.splice(index, 1, res.data);
        });
    },
    async getModule() {
      return axios.get("/api/module/" + this.id).then((res) => {
        this.info.title = res.data.title;
        this.info.description = res.data.descprtion;
        this.info.img_url = res.data.img_url;
      });
    },
  },
};
</script>
