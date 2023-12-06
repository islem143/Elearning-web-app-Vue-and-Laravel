<template>
  <div
    class="pa-7 cursor-pointer m-4 border-round transition-all transition-duration-200 hover:bg-gray-100 shadow-4 hover:shadow-6"
  >
    <div class="flex justify-content-between">
      <div class="flex gap-2 align-items-center px-3 py-2">
        <i class="pi pi-check-square"></i>
        <h4>Learn</h4>
      </div>
      <div class="mt-2 p-3">
        <Button
          style="width: 150px"
          v-if="role == 'teacher'"
          label="Edit Course"
          icon="pi pi-pencil"
          class="p-button-rounded p-button-success mr-2"
          @click="editCourse"
        />
        <Button
          style="width: 150px"
          v-if="role == 'teacher'"
          label="Delete Course"
          icon="pi pi-pencil"
          class="p-button-rounded p-button-danger mr-2"
          @click="$emit('delete-course', course.id)"
        />
      </div>
    </div>

    <div class="flex px-5 pt-3">
      <div>
        <a href="" class="text-xl font-bold text-900">{{ course.title }}</a>
        <p class="mt-2">Description: {{ course.description }}</p>
      </div>
      <div></div>
    </div>
     <p v-for="content in course.courses_content" :key="content.id">
      <a
        class="text-900 text-lg hover:underline"
        @click="openDialogContent(content)"
      >
        Average atomic mass
      </a>
    </p> 
    <div class="p-5" v-if="course.is_taken == false && role != 'teacher'">
      <Button @click="startCourse">Start the course</Button>
    </div>
    <div v-else class="px-5 pb-3">
      <div>
        <h5>Learn:</h5>
      </div>

      <p v-for="media in course.media" :key="media.id">
        <i
          :class="
            icons[media.type] + ' mr-3 mt-2 border-1 p-1 surface-200 text-900'
          "
          style="font-size: 1rem"
        >
        </i>
        <a
          class="text-900 text-lg hover:underline"
          :href="'http://localhost:8081/' + media.url"
          >{{ media.name }}</a
        >
      </p>

      <Dialog class="p-2" :header="this.title" v-model:visible="visible">
        <iframe
          :src="'http://www.youtube.com/embed/' + this.url"
          width="560"
          height="315"
          frameborder="0"
          allowfullscreen
        ></iframe>
      </Dialog>
      <Dialog
        class="p-2 w-9"
        :header="this.title"
        v-model:visible="visibleContent"
      >
        <div v-html="html"></div>
      </Dialog>
    </div>
  </div>

  <CourseQuiz
     
    v-if="(role == 'teacher' && course.quizzes[0]) || 
    (role != 'teacher' && course.is_taken == true && course.quizzes)"
     
    
    @go-to-quiz="goToQuiz"
    @edit-quiz="editQuiz"
    @delete-quiz="deleteQuiz"
    :quiz="course.quizzes[0]"
    :course="course"
  />
</template>

<script>
import axios from "../../http";
import CourseQuiz from "./CourseQuiz.vue";
import { QuillDeltaToHtmlConverter } from "quill-delta-to-html";

export default {
  name: "CourseCard",
  inject: ["role"],
  components: {
    CourseQuiz,
  },
  props: {
    course: {
      type: Object,
    },
    moduleId: {
      type: Number,
    },
  },
  data() {
    return {
      quizzes: [],
      url: "",
      title: "",
      content: "",
      visibleContent: false,
      visible: false,
      html: "",
      icons: {
        video: "pi pi-video",
        image: "pi pi-image",
        file: "pi pi-file",
      },
    };
  },
  created() {},

  methods: {
    goToQuiz(quiz) {
      this.$router.push({
        name: "quiz",
        params: {
          courseId: this.course.id,
          quizId: quiz.id,
        },
      });
    },
    editQuiz(quiz) {
      console.log(quiz);
      this.$router.push({
        name: "quiz-edit",
        params: {
          courseId: this.course.id,
          quizId: quiz.id,
        },
      });
    },
    deleteQuiz(quiz) {
      axios
        .delete("/api/course/" + this.course.id + "/quiz/" + quiz.id)
        .then((res) => {
          console.log(res);
        });
    },
    courseDetail() {
      this.$router.push({
        name: "course-detail",
        params: {
          moduleId: this.$route.params.moduleId,
          courseId: this.course.id,
        },
      });
    },
    openDialogContent(content) {
      this.content = JSON.parse(content.content);

      this.visibleContent = true;
      var converter = new QuillDeltaToHtmlConverter(this.content.ops, {});

      var html = converter.convert();
      console.log(html);
      this.html = html;
    },
    openDialog(url, title) {
      this.visible = true;
      this.url = url;
      this.title = title;
    },
    startCourse() {
      axios
        .post(
          "/api/module/" +
            this.$route.params.moduleId +
            "/course/" +
            this.course.id +
            "/startCourse"
        )
        .then((res) => {
          console.log(res);
          this.$emit("get-course", this.course);
          this.$toast.add({
            severity: "success",
            summary: res.data.message,

            life: 3000,
          });
        })
        .catch((err) => {
          this.$toast.add({
            severity: "warn",
            summary: err.response.data.message,

            life: 3000,
          });
        });
    },
    // deleteCourse() {
    //    console.log(this.course.id)
    //   this.$emit("delete-course", this.course.id);
    // },
    editCourse() {
      this.$router.push({
        name: "course-edit",
        params: {
          moduleId: this.$route.params.moduleId,
          courseId: this.course.id,
        },
      });
    },
  },
};
</script>
