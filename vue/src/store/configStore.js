
import { useAuth } from "./authStore";
import { defineStore } from "pinia";
import { TEACHER_MENU, ADMIN_MENU, STUDENT_MENU } from "./MENU_ITEMS";
export const useConfig=defineStore("config",{
state:()=>({
  
    config: {
      menuItems: [],
    },
  
}),
getters: {
  getMenus(state) {
    return !!state.config.menuItems;
  },
},
actions: {
  async getMenuItems() {
    const authStore=useAuth();
    let d = {
      super_admin: ADMIN_MENU,
      teacher: TEACHER_MENU,
      student: STUDENT_MENU,
    };
  
    this.config.menuItems=d[authStore.user.roles[0]];

    return Promise.resolve();
  },
},
});

