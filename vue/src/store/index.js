import { createStore } from "vuex";
import AuthStore from "./authStore";
import ConfigStore from "./configStore";
const store = createStore({
  modules: {
    auth: AuthStore,
    config: ConfigStore,
  },
});

export default store;
