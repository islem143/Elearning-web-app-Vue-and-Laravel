import axios from "axios";

import emitter from "./mitt";
let client = axios.create({
  baseURL: `http://${import.meta.env.VITE_HOST}:8081`,
  headers: {
    Accept: "application/json",
    "Content-Type": "application/json",
    Authorization: localStorage.getItem("token")
      ? "Bearer " + localStorage.getItem("token")
      : null,
  },
});
//axios.defaults.withCredentials = true;
client.interceptors.request.use((config) => {
  config.headers.Authorization = `Bearer ${localStorage.getItem("token")}`;
  return config;
});

client.interceptors.response.use(
  (res) => {
    return res;
  },
  (err) => {
    if (err.response.status == 403) {
      emitter.emit("error", {
        type: "error",
        message: err.response.data.message,
      });
    } else if (err.response.status == 404) {
      //window.location = "/404";
      //emitter.emit("error", { message: err.message });
    }

    return Promise.reject(err);
  }
);
export default client;
