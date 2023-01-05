<template>
  <div class="card pt-0 px-0 p-fluid bg-white">
    <div class="p-4 text-white border-round-top m-0 bg-blue-300">
      <h3>Course: {{ info.title }}</h3>
      <p>{{ info.description }}</p>
    </div>
    <div class="p-5">
      <div class="">
        <h4>Attachments:</h4>

        <p v-for="attachment in attachments">
          <a :href="'http://localhost:8081/' + attachment.url">{{
            attachment.name
          }}</a>
        </p>
      </div>
    </div>
    <div class="p-5">
      <div class="">
        <h4>Quiz:</h4>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "../../http";

export default {
  name: "CourseDetail",

  data() {
    return {
      id: null,
      courseId: null,
      moduleId: null,
      info: {
        title: "",
        description: "",
        img_url: "",
      },
      attachments: [],
    };
  },
  created() {
    let moduleId = this.$route.params.moduleId;
    let courseId = this.$route.params.courseId;
    this.courseId = courseId;
    this.moduleId = moduleId;
  },
  methods: {
    getCourse() {
      axios
        .get("/api/module/" + this.moduleId + "/course/" + this.courseId)
        .then((res) => {
          this.info = res.data;
          axios.get("/api/media/" + courseId).then((res) => {
            this.attachments = res.data;
          });
        });
    },
  },
};
</script>
