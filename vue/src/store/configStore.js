import axios from "../http";
import store from "./index";
import { TEACHER_MENU, ADMIN_MENU, STUDENT_MENU } from "./MENU_ITEMS";
const configStore = {
  namespaced: true,
  state: {
    config: {
      menuItems: [],
    },
  },
  getters: {
    getMenus(state) {
      return !!state.config.menuItems;
    },
  },
  mutations: {
    setMenuItems(state, items) {
      state.config.menuItems = items;
    },
  },

  actions: {
    async getMenuItems({ commit }) {
      let d = {
        super_admin: ADMIN_MENU,
        teacher: TEACHER_MENU,
        student: STUDENT_MENU,
      };
      commit("setMenuItems", d[store.state.auth.user.roles[0]]);

      return Promise.resolve();
    },
  },
  modules: {},
};

export default configStore;
