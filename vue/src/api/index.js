import axios from "axios";

let client = axios.create({
  baseURL: "http://localhost:8081",
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


export default client;
