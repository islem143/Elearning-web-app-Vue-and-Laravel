<template>
  <div :class="containerClass" @click="onWrapperClick">
    <Toast />

    <AppTopBar @menu-toggle="onMenuToggle" />
    <div class="layout-sidebar" @click="onSidebarClick">
      <AppMenu :model="menu" @menuitem-click="onMenuItemClick" />
    </div>

    <div class="layout-main-container">
      <div class="layout-main">
        <router-view />
      </div>
      <AppFooter />
    </div>

    <!-- <AppConfig :layoutMode="layoutMode" @layout-change="onLayoutChange" /> -->
    <transition name="layout-mask">
      <div
        class="layout-mask p-component-overlay"
        v-if="mobileMenuActive"
      ></div>
    </transition>
  </div>
</template>

<script>
import AppTopBar from "./AppTopbar.vue";
import AppMenu from "./AppMenu.vue";
//import AppConfig from "./AppConfig.vue";
import AppFooter from "./AppFooter.vue";
import emitter from "./mitt";

export default {
  mounted() {
    emitter.on("*", (type, data) => {
      if (type == "error") {
        console.log(data);
        this.$toast.add({
          severity: "error",
          summary: data.message,

          life: 3000,
        });
      }
    });
  },
  emits: ["change-theme"],

  data() {
    return {
      layoutMode: "static",
      staticMenuInactive: false,
      overlayMenuActive: false,
      mobileMenuActive: false,
      menu: [
        {
          items: [
            {
              label: "Dashboard",
              icon: "pi pi-fw pi-home",
              to: "/",
            },
            {
              label: "Modules",
              icon: "pi pi-stop",
              to: "/modules",
            },
          ],
        },
      ],
    };
  },
  created(){
    if (this.$route.name == "module-list") {

this.staticMenuInactive = true;
} 
  },
  watch: {
    $route() {
      this.menuActive = false;
      this.$toast.removeAllGroups();
      
      if (this.$route.name == "module-list") {

        this.staticMenuInactive = true;
      } else {
        this.staticMenuInactive = false;
      }
    },
  },
  methods: {
    onWrapperClick() {
      if (!this.menuClick) {
        this.overlayMenuActive = false;
        this.mobileMenuActive = false;
      }

      this.menuClick = false;
    },
    onMenuToggle() {
      this.menuClick = true;

      if (this.isDesktop()) {
        if (this.layoutMode === "overlay") {
          if (this.mobileMenuActive === true) {
            this.overlayMenuActive = true;
          }

          this.overlayMenuActive = !this.overlayMenuActive;
          this.mobileMenuActive = false;
        } else if (this.layoutMode === "static") {
          this.staticMenuInactive = !this.staticMenuInactive;
        }
      } else {
        this.mobileMenuActive = !this.mobileMenuActive;
      }

      event.preventDefault();
    },
    onSidebarClick() {
      this.menuClick = true;
    },
    onMenuItemClick(event) {
      if (event.item && !event.item.items) {
        this.overlayMenuActive = false;
        this.mobileMenuActive = false;
      }
    },
    onLayoutChange(layoutMode) {
      this.layoutMode = layoutMode;
    },
    addClass(element, className) {
      if (element.classList) element.classList.add(className);
      else element.className += " " + className;
    },
    removeClass(element, className) {
      if (element.classList) element.classList.remove(className);
      else
        element.className = element.className.replace(
          new RegExp(
            "(^|\\b)" + className.split(" ").join("|") + "(\\b|$)",
            "gi"
          ),
          " "
        );
    },
    isDesktop() {
      return window.innerWidth >= 992;
    },
    isSidebarVisible() {
      if (this.isDesktop()) {
        if (this.layoutMode === "static") return !this.staticMenuInactive;
        else if (this.layoutMode === "overlay") return this.overlayMenuActive;
      }

      return true;
    },
  },
  computed: {
    containerClass() {
      return [
        "layout-wrapper",
        {
          "layout-overlay": this.layoutMode === "overlay",
          "layout-static": this.layoutMode === "static",
          "layout-static-sidebar-inactive":
            this.staticMenuInactive && this.layoutMode === "static",
          "layout-overlay-sidebar-active":
            this.overlayMenuActive && this.layoutMode === "overlay",
          "layout-mobile-sidebar-active": this.mobileMenuActive,
          "p-input-filled": this.$primevue.config.inputStyle === "filled",
          "p-ripple-disabled": this.$primevue.config.ripple === false,
        },
      ];
    },
    logo() {
      return this.$appState.darkTheme
        ? "images/logo-white.svg"
        : "images/logo.svg";
    },
  },
  beforeUpdate() {
    if (this.mobileMenuActive)
      this.addClass(document.body, "body-overflow-hidden");
    else this.removeClass(document.body, "body-overflow-hidden");
  },
  components: {
    AppTopBar: AppTopBar,
    AppMenu: AppMenu,
    //AppConfig: AppConfig,
    AppFooter: AppFooter,
  },
};
</script>

<style lang="scss">
@import "./App.scss";
@import url("https://fonts.googleapis.com/css2?family=Montserrat&display=swap");
@import url("https://fonts.googleapis.com/css2?family=Roboto:wght@400&display=swap");
@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto&display=swap');
body {
  font-family: "Poppins", sans-serif;
  background-color: #f9f9fa;


}
:root {
  --surface-card: surface-200;
}
</style>
