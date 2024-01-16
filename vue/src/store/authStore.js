import axios from "../http";
import { defineStore } from 'pinia'

export const useAuth=defineStore('auth',{
state:()=>({
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
}),
getters: {
  isAuth(state) {
    return !!state.user.token;
  },
  getUserId(state) {
    return state.user.data.id;
  },
},
actions: {
    
    async login(user) {
    
      return await axios
        .post("/api/login", user)
        .then((res) => {
          const user = res.data.user;
          const token = res.data.token;
          const roles = res.data.roles;
          this.user.data=user;
          this.user.token=token;
          this.user.roles = roles
          localStorage.setItem("user", JSON.stringify(user));
          localStorage.setItem("token", token);
          localStorage.setItem("roles", JSON.stringify(roles));

          return res;
        })
        .catch((err) => {
          return Promise.reject(err.response.data);
        });
    },
    async register(user) {
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
    async logout() {
      return await axios
        .post("/api/logout")
        .then((res) => {
          this.user = {
            data: null,
            token: "",
            roles: null,
          };
          localStorage.removeItem("token");
          localStorage.removeItem("user");
          localStorage.removeItem("roles");
          return res;
        })
        .catch((err) => {
          console.log(err,"eeeeee");
          console.log(err.response.data);
        });
    },
  },

});


