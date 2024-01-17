<template>
  <div class="layout-topbar">
    <router-link to="/" class="layout-topbar-logo">

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
      <li v-for="item in items" :key="item.id">
        <router-link :to="item.to">
          <p class="p-link mt-2 hover:bg-gray-300 p-2">
            {{ item.label }}
          </p></router-link
        >
      </li>
    
      <li v-if="role">
        <p @click="logoutt" class="p-link mt-2 hover:bg-gray-300 p-2">Logout</p>
      </li>

       <li v-if="role">
        <Router-link :to="{ name: 'profile' }">
          <button class="p-link layout-topbar-button">
            <i class="pi pi-user"></i>

            <span>Profile</span>
          </button>
        </Router-link>
      </li> 
    </ul>
  </div>
</template>

<script>
import { useAuth } from "./store/authStore";
import { mapActions } from 'pinia'

export default {
  inject: ["role"],
  data() {
    return {
      items: [],
    };
  },
  methods: {
    ...mapActions(useAuth, ['logout']),
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
    logoutt() {
      this.logout().then((res) => {
        this.$router.replace({ name: "login" });
      });
    },
  },
  created() {
 
    if (this.role && this.role == "super-admin") {
     
      this.items = [
        {
          id: 1,
          label: "Dashbarod",
          roles: ["super-admin"],
          to: { name: "admin-dashboard" },
        },
        {
          id: 2,
          label: "Users",
          roles: ["super-admin"],
          to: { name: "users-list" },
        },
        {
          id: 3,
          label: "History",
          roles: ["teacher", "super-admin"],
          to: { name: "history-list" },
        },
      ];
    } else if (this.role && this.role == "teacher") {
      this.items = [
        {
          id: 1,
          label: "Modules",
          roles: ["teacher", "student"],
          to: { name: "module-list" },
        },
        {
          id: 2,
          label: "Chat",
          roles: ["teacher", "student", "super-admin"],
          to: { name: "chat" },
        },
        {
          id: 3,
          label: "History",
          roles: ["teacher", "super-admin"],
          to: { name: "history-list" },
        },
      ];
    } else if (this.role && this.role == "student") {
      this.items = [
        {
          id: 1,
          label: "Modules",
          roles: ["teacher", "student"],
          to: { name: "module-list" },
        },
        {
          id: 2,
          label: "My Modules",
          roles: ["student"],
          to: { name: "module-student-list" },
        },
        {
          id: 3,
          label: "Chat",
          roles: ["teacher", "student", "super-admin"],
          to: { name: "chat" },
        },
      ];
    } else {
      this.items = [
        
      ];
    }
  },
  computed: {
    darkTheme() {
      return this.$appState.darkTheme;
    },
  },
};
</script>
