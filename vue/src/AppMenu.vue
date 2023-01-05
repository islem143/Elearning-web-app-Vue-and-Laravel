<template>
  <div class="layout-menu-container">
    <!-- <AppSubmenu :items="model" class="layout-menu" :root="true" @menuitem-click="onMenuItemClick" @keydown="onKeyDown" /> -->
    <div class="p-2">
      <h4 class="mb-5">Modules</h4>

      <!-- <div v-for="module in modules">
        <Router-link
          :to="{ name: 'module-detail', params: { moduleId: module.id } }"
        >
          <a href="#"> {{ module.title }}</a>
        </Router-link>

        <hr />
      </div> -->
    </div>
  </div>
</template>

<script>
import AppSubmenu from "./AppSubmenu.vue";
import axios from "./http";
export default {
  data() {
    return {
      modules: [],
    };
  },
  props: {
    model: Array,
  },
  async created() {
    // await axios.get("/api/module").then((res) => {
    //   this.modules = res.data;
    // });
  },
  methods: {
    moduleDetail(module) {
      this.$router.push({
        name: "module-detail",
        params: { moduleId: module.id },
      });
    },
    onMenuItemClick(event) {
      this.$emit("menuitem-click", event);
    },
    onKeyDown(event) {
      const nodeElement = event.target;
      if (event.code === "Enter" || event.code === "Space") {
        nodeElement.click();
        event.preventDefault();
      }
    },
    bannerImage() {
      return this.$appState.darkTheme
        ? "images/banner-primeblocks-dark.png"
        : "images/banner-primeblocks.png";
    },
  },
  computed: {
    darkTheme() {
      return this.$appState.darkTheme;
    },
  },
  components: {
    AppSubmenu: AppSubmenu,
  },
};
</script>
