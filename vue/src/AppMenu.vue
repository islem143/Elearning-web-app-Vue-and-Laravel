<template>
  <div class="layout-menu-container">
    <AppSubmenu
      :items="items"
      class="layout-menu"
      :root="true"
      @menuitem-click="onMenuItemClick"
      @keydown="onKeyDown"
    />
    <!-- <div class="p-2">
      <Router-link
        :key="item.id"
        v-for="item in items"
        :to="item.to"
        @click="setCurrentItem(item)"
      >
        <a
          v-if="item.roles.includes(role)"
          :class="
            'block mb-2  hover:surface-200 p-2 ' +
            (currentItem == item.id ? 'text-blue-400' : 'text-900')
          "
          href="#"
        >
          {{ item.label }}</a
        >
      </Router-link>
    </div> -->
  </div>
</template>

<script>
import AppSubmenu from "./AppSubmenu.vue";
import { mapActions } from 'pinia'

import { useConfig } from "./store/configStore";
export default {
  inject: ["role"],
  data() {
    return {
      items: [],
      currentItem: null,
    };
  },
  created() {
    const configStore=useConfig();
    this.getMenuItems().then(() => {
      this.items = configStore.config.menuItems;
    });
  },

  props: {
    model: Array,
  },

  methods: {
    ...mapActions(useConfig, ['getMenuItems']),
    setCurrentItem(item) {
      this.currentItem = item.id;
    },
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
