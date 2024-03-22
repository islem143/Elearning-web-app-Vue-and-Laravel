<template>
  <div
    class=" text-white flex align-items-center justify-content-center min-h-screen min-w-screen overflow-hidden"
  >
    <div class="grid justify-content-center p-2 lg:p-0 align-items-center" style="min-width: 80%">
      
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
            );"
          
        >
          <div class="w-full md:w-10 mx-auto">
            <label for="email1" class="block  text-xl font-medium mb-2"
              >Email</label
            >
            <InputText
              id="email1"
              v-model="email"
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
              v-model="password"
              placeholder="Password"
              :toggleMask="true"
              class="w-full mb-3"
              inputClass="w-full"
              inputStyle="padding:1rem"
            ></Password>
            <p class="p-error">{{ passwordError }}</p>
            <div class="flex align-items-center justify-content-between mb-5">
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
            </div>
            <Button
              label="Sign In"
              class="w-full p-3 text-xl"
              @click="loginn"
            ></Button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions } from 'pinia';
import { useAuth } from '../../store/authStore';
export default {
  name: "Login",
  data() {
    return {
      email: "",
      password: "",
      checked: false,

      emailError: "",
      passwordError: "",
      error: "",
    };
  },
  computed: {
    logoColor() {
      if (this.$appState.darkTheme) return "white";
      return "dark";
    },
  },
  methods: {
    ...mapActions(useAuth, ['login']),
    loginn() {
     
        this.login({ email: this.email, password: this.password })
        .then(() => {
          this.$router.push({name:"module-list"});
        })
        .catch((err) => {
          console.log(err);
          for (const key in err.errors) {
            this[key + "Error"] = err.errors[key].toString();
          }
        });
    },
  },
};
</script>

<style scoped>
.app {
  background: #000f42;
  font-family: "Poppins", sans-serif;  height: 100vh;
}
.st0{opacity:7.000000e-02;}
	.st1{fill:#2A94F4;}
	.st2{opacity:0.51;}
	.st3{fill:#FFBE55;}
	.st4{fill:#F7F7F7;}
	.st5{opacity:0.17;fill:#2A94F4;}
	.st6{clip-path:url(#SVGID_2_);fill:#2A94F4;}
	.st7{fill:#B97A59;}
	.st8{fill:#0B4870;}
	.st9{fill:#AA6B4F;}
	.st10{fill:#D3D3D3;}
</style>
