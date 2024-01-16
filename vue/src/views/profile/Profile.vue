<template>
  <div class="card p-fluid bg-white">
    <h4>Profile</h4>
    <div class="flex justify-content-center">
      <div class="w-6 mt-5">
        <div class="field">
          <label for="name1">Name</label>
          <InputText v-model="user.name" type="text" />
        </div>

        <div class="field">
          <label for="age1">Image</label>
         
          <FileUpload
            ref="image"
            mode="basic"
            name="image"
            accept="image/*"
            :maxFileSize="1000000"
          />
          <img
            width="50"
            v-if="user"
            class="mt-4"
            :src="'http://api.localhost:8081/images/' + user.profile.img_url"
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
import { useAuth } from "../../store/authStore";
import {setUserData} from "../../utils/auth"
export default {
  created() {
    const authStore=useAuth();
    this.user = authStore.user.data;
    console.log(this.user);
  },
 
  setup() {
    return { v$: useVuelidate() };
  },
  name: "ModuleForm",

  data() {
    return {
      id: null,
      user: null,
    };
  },
  validations() {
    return {
      user: {
        name: { required },
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
        await axios.put("/api/users/"+this.user.id, this.user).then(async (res) => {
          let file = this.$refs.image.files[0];
          this.$toast.add({
            severity: "success",
            summary: "Profile  updated.",

            life: 3000,
          });
         
          setUserData(res.data);
      
          if (file) {
            let formData = new FormData();
            formData.append("image", file);
            await axios
              .post("/api/users/image" , formData, {
                headers: {
                  "Content-Type": "multipart/form-data",
                },
              })
              .then((res) => {
               setUserData(res.data)
               const authStore=useAuth();
         this.user = authStore.user.data;
              });
          }
        });
      }
    },
  },
};
</script>
