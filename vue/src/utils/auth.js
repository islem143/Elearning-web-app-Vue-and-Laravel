import { useAuth } from "../store/authStore";

export const hasToken = () => {

  return localStorage.getItem("token") ? localStorage.getItem("token") : false;
};
export const hasRoutes = () => {
  const store=useAuth();
  return store.user.hasRoutes;
};
export const getRoles = () => {
  const store=useAuth();
  let roles=store.user.roles;
  if(!roles){
    return '';
  }
  return roles;
};
export const setHasRoutes = () => {
  const store=useAuth();
  store.user.hasRoutes=true;
};
