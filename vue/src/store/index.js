import { createStore } from "vuex";
import AuthStore from "./authStore";

const store = createStore({
  modules: {
    auth: AuthStore,
  },
});

export default store;
