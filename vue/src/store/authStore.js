import axios from "../http";
const authStore = {
  namespaced: true,
  state: {
    user: {
      data: localStorage.getItem("token")
        ? JSON.parse(localStorage.getItem("user"))
        : "",
      token: localStorage.getItem("token") ? localStorage.getItem("token") : "",
      roles: localStorage.getItem("roles")
        ? JSON.parse(localStorage.getItem("roles"))
        : [],
      hasRoutes: false,
    },
  },
  getters: {
    isAuth(state) {
      return !!state.user.token;
    },
    getUserId(state) {
      return state.user.data.id;
    },
  },
  mutations: {
    setUser(state, user) {
      state.user.data = user;
      localStorage.setItem("user", JSON.stringify(user));
    },
    setToken(state, token) {
      state.user.token = token;
      localStorage.setItem("token", token);
    },
    setRoles(state, roles) {
      state.user.roles = roles;
      localStorage.setItem("roles", JSON.stringify(roles));
    },
    setHasRoutes(state, cond) {
      state.user.hasRoutes = true;
    },

    logout(state) {
      state.user = {
        data: null,
        token: "",
        roles: null,
      };

      localStorage.removeItem("token");
      localStorage.removeItem("user");
      localStorage.removeItem("roles");
    },
  },

  actions: {
    async login({ commit }, user) {
      return await axios
        .post("/api/login", user)
        .then((res) => {
          const user = res.data.user;
          const token = res.data.token;
          const roles = res.data.roles;
          console.log(roles);
          commit("setUser", user);
          commit("setToken", token);
          commit("setRoles", roles);

          return res;
        })
        .catch((err) => {
          return Promise.reject(err.response.data);
        });
    },
    async register({ commit }, user) {
      return await axios
        .post("/api/register", user)
        .then((res) => {
          // const user = res.data.user;
          // const token = res.data.token;
          // commit("setUser", user);
          // commit("setToken", token);

          return res;
        })
        .catch((err) => {
          return Promise.reject(err.response.data);
        });
    },
    async logout({ commit }, user) {
      return await axios
        .post("/api/logout")
        .then((res) => {
          commit("logout");

          return res;
        })
        .catch((err) => {
          console.log(err.response.data);
        });
    },
  },
  modules: {},
};

export default authStore;
