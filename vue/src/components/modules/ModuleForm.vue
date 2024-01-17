<template>
  <div class="card p-fluid">
    <h4>Add module</h4>
    <div class="flex justify-content-center">
      <div class="w-6 mt-5">
        <div class="field">
          <label for="name1">Title</label>
          <InputText v-model="info.title" type="text" />
        </div>
        <div class="field">
          <label for="Description">Description</label>
          <InputText v-model="info.description" type="text" />
        </div>
        <img width="200"  height="200" v-if="info.imgUrl" :src="info.imgUrl" alt="">
        <div class="field">
          <label for="age1">Image</label>
          <FileUpload
            ref="image"
            mode="basic"
            name="image"
            accept="image/*"
            :maxFileSize="1000000"
          />
        </div>
        <Button @click="submit" label="Submit" />
      </div>
    </div>
  </div>
</template>

<script>
import { required } from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import axios from "../../http";
export default {
  created() {
    let id = parseInt(this.$route.params.moduleId);
    this.id = id;
    if (id) {
      axios.get("/api/module/" + id).then((res) => {
        console.log(res.data);
        this.info.title = res.data.title;
        this.info.description = res.data.descprtion;
        this.info.imgUrl = res.data.img_url;
      });
    }
  },
  setup() {
    return { v$: useVuelidate() };
  },
  name: "ModuleForm",

  data() {
    return {
      id: null,
      info: {
        title: "",
        description: "",
      },
    };
  },
  validations() {
    return {
      info: {
        title: { required },
        description: { required },
      },
    };
  },
  methods: {
    errorMessages(key) {
      const errors = [];
      if (!this.v$.goal[key].$dirty) return errors;
      for (const err of this.v$.goal[key].$errors) {
        errors.push(err.$message);
      }
      return errors;
    },
    async submit() {
      const isFormCorrect = await this.v$.$validate();
      if (isFormCorrect) {
        if (this.id) {
          await axios
            .put("/api/module/" + this.id, this.info)
            .then(async (res) => {
              let file = this.$refs.image.files[0];
              this.$toast.add({
                severity: "success",
                summary: "Module  updated.",

                life: 3000,
              });
              if (file) {
                let formData = new FormData();
                formData.append("image", file);
                await axios
                  .post("/api/module/" + this.id + "/image", formData, {
                    headers: {
                      "Content-Type": "multipart/form-data",
                    },
                  })
                  .then((res) => {
                    this.$router.push({ name: "module-list" });
                  });
              }
            });
        } else {
          await axios.post("/api/module", this.info).then(async (res) => {
            const id = res.data.id;
            let file = this.$refs.image.files[0];
            let formData = new FormData();
            formData.append("image", file);
            await axios
              .post("/api/module/" + id + "/image", formData, {
                headers: {
                  "Content-Type": "multipart/form-data",
                },
              })
              .then((res) => {
                this.$router.push({ name: "module-list" });
              });
          });
        }
      }
    },
  },
};
</script>
