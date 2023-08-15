import axios from "../http";
import store from "./index";
import { TEACHER_MENU,ADMIN_MENU,STUDENT_MENU } from "./MENU_ITEMS";
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
     
        if(store.state.auth.user.roles[0]=="super-admin"){
           commit('setMenuItems',ADMIN_MENU);
        }else if(store.state.auth.user.roles[0]=="teacher"){
            commit('setMenuItems',TEACHER_MENU);
           
        }else{
            commit('setMenuItems',STUDENT_MENU);
        }
        return Promise.resolve();
    },
 
  
  },
  modules: {},
};

export default configStore;
