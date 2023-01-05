import store from "../store";
export const hasToken = () => {
  return localStorage.getItem("token") ? localStorage.getItem("token") : false;
};
export const hasRoutes = () => {
  return store.state.auth.user.hasRoutes;
};
export const getRoles = () => {
  return store.state.auth.user.roles;
};
export const setHasRoutes = () => {
  store.commit("auth/setHasRoutes", true);
};
