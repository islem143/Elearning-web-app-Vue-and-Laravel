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
export const setUserData=(data)=>{
  const store=useAuth();
  store.user.data=data;
  localStorage.setItem("user", JSON.stringify(data));
}
export const setToken=(token)=> {
  const store=useAuth();
  state.user.token = token;
  localStorage.setItem("token", token);
}
export const setRoles=(roles)=> {
  state.user.roles = roles;
  localStorage.setItem("roles", JSON.stringify(roles));
}

export const setHasRoutes = () => {
  const store=useAuth();
  store.user.hasRoutes=true;
};
