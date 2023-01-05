<template>
  <div class="layout-topbar">
    <router-link to="/" class="layout-topbar-logo">
      <img alt="Logo" :src="topbarImage()" />
      <span>ELEARNING</span>
    </router-link>
    <button
      class="p-link layout-menu-button layout-topbar-button"
      @click="onMenuToggle"
    >
      <i class="pi pi-bars"></i>
    </button>

    <button
      class="p-link layout-topbar-menu-button layout-topbar-button"
      v-styleclass="{
        selector: '@next',
        enterClass: 'hidden',
        enterActiveClass: 'scalein',
        leaveToClass: 'hidden',
        leaveActiveClass: 'fadeout',
        hideOnOutsideClick: true,
      }"
    >
      <i class="pi pi-ellipsis-v"></i>
    </button>
    <ul class="layout-topbar-menu hidden lg:flex origin-top">

      <li>
        <router-link :to="{ name: 'dashboard' }">
          <p class="p-link mt-2 hover:bg-gray-300 p-2">Dashboard</p></router-link>
    
      </li>
      <li>
        <router-link :to="{ name: 'module-list' }">
          <p class="p-link mt-2 hover:bg-gray-300 p-2">Modules</p></router-link
        >
      </li>
      <li v-if="role=='teacher'">
        <router-link :to="{ name: 'history-list' }">
          <p class="p-link mt-2 hover:bg-gray-300 p-2">History</p></router-link
        >
      </li>
      <li>
        <p @click="logout" class="p-link mt-2 hover:bg-gray-300 p-2">Logout</p>
      </li>
      <!-- <li>
				<button class="p-link layout-topbar-button">
					<i class="pi pi-calendar"></i>
					<span>Events</span>
				</button>
			</li>
			<li>
				<button class="p-link layout-topbar-button">
					<i class="pi pi-cog"></i>
					<span>Settings</span>
				</button>
			</li> -->
      <li>
        <button class="p-link layout-topbar-button">
          <i class="pi pi-user"></i>
          <span>Profile</span>
        </button>
      </li>
    </ul>
  </div>
</template>

<script>
import store from "./store";
export default {
  inject:['role'],
  methods: {
    onMenuToggle(event) {
      this.$emit("menu-toggle", event);
    },
    onTopbarMenuToggle(event) {
      this.$emit("topbar-menu-toggle", event);
    },
    topbarImage() {
      return this.$appState.darkTheme
        ? "/images/logo-white.svg"
        : "/images/logo-dark.svg";
    },
    logout() {
      store.dispatch("auth/logout").then((res) => {
        this.$router.replace({ name: "login" });
      });
    },
  },
  computed: {
    darkTheme() {
      return this.$appState.darkTheme;
    },
  },
};
</script>
