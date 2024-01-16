<template>
  <div
    class="surface-0 flex align-items-center justify-content-center min-h-screen min-w-screen overflow-hidden"
  >
    <div
      class="grid justify-content-center p-2 lg:p-0 align-items-center"
      style="min-width: 80%"
    >
      
      <div
        class="col-12 xl:col-6"
        style="
          border-radius: 56px;
          padding: 0.3rem;
          background: linear-gradient(
            180deg,
            var(--primary-color),
            rgba(33, 150, 243, 0) 30%
          );
        "
      >
        <div
          class="h-full w-full m-0 py-7 px-4"
          style="
            border-radius: 53px;
            background: linear-gradient(
              180deg,
              var(--surface-50) 38.9%,
              var(--surface-0)
            );
          "
        >
          <div class="w-full md:w-10 mx-auto">
            <label for="name" class="block text-900 text-xl font-medium mb-2"
              >Name</label
            >
            <InputText
              id="name"
              v-model="info.name"
              type="text"
              class="w-full mb-3"
              placeholder="Name"
              style="padding: 1rem"
            />
            <p class="p-error">{{ nameError }}</p>
            <label for="email1" class="block text-900 text-xl font-medium mb-2"
              >Email</label
            >
            <InputText
              id="email1"
              v-model="info.email"
              type="text"
              class="w-full mb-3"
              placeholder="Email"
              style="padding: 1rem"
            />
            <p class="p-error">{{ emailError }}</p>
            <label
              for="password1"
              class="block text-900 font-medium text-xl mb-2"
              >Password</label
            >
            <Password
              id="password1"
              v-model="info.password"
              placeholder="Password"
              :toggleMask="true"
              class="w-full mb-3"
              inputClass="w-full"
              inputStyle="padding:1rem"
            ></Password>
            <p class="p-error">{{ passwordError }}</p>
            <label
              for="password2"
              class="block text-900 font-medium text-xl mb-2"
              >Password Confirmation</label
            >
            <Password
              id="password2"
              v-model="info.password_confirmation"
              placeholder="Password Confirmation"
              :toggleMask="true"
              class="w-full mb-3"
              inputClass="w-full"
              inputStyle="padding:1rem"
            ></Password>

            <!-- <div class="flex align-items-center justify-content-between mb-5">
              <div class="flex align-items-center">
                <Checkbox
                  id="rememberme1"
                  v-model="checked"
                  :binary="true"
                  class="mr-2"
                ></Checkbox>
                <label for="rememberme1">Remember me</label>
              </div>
              <a
                class="font-medium no-underline ml-2 text-right cursor-pointer"
                style="color: var(--primary-color)"
                >Forgot password?</a
              >
            </div> -->
            <Button
              label="Sign In"
              class="w-full p-3 text-xl"
              @click="login"
            ></Button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import store from "../../store";
import { useAuth } from "../../store/authStore";
export default {
  name: "Register",
  data() {
    return {
      info: {
        name: "",
        email: "",
        password: "",
        password_confirmation: "",

        error: "",
      },
      nameError: "",
      emailError: "",
      passwordError: "",
    };
  },
  computed: {
    logoColor() {
      if (this.$appState.darkTheme) return "white";
      return "dark";
    },
  },
  methods: {
    ...mapActions(useAuth, ['register']),
    clearErrors() {
      this.emailError = "";
      this.nameError = "";
      this.passwordError = "";
    },
    login() {
      
     this.register(this.info)
        .then(() => {
          this.$toast.add({
            severity: "success",
            summary: "Account was created successfully.",

            life: 3000,
          });
          this.$router.push({ name: "login" });
        })
        .catch((err) => {
          for (const key in err.errors) {
            this[key + "Error"] = err.errors[key].toString();
          }
        });
    },
  },
};
</script>

<style scoped>
.st0 {
  opacity: 7e-2;
}
.st1 {
  fill: #2a94f4;
}
.st2 {
  opacity: 0.51;
}
.st3 {
  fill: #ffbe55;
}
.st4 {
  fill: #f7f7f7;
}
.st5 {
  opacity: 0.17;
  fill: #2a94f4;
}
.st6 {
  clip-path: url(#SVGID_2_);
  fill: #2a94f4;
}
.st7 {
  fill: #b97a59;
}
.st8 {
  fill: #0b4870;
}
.st9 {
  fill: #aa6b4f;
}
.st10 {
  fill: #d3d3d3;
}
</style>
