import axios from "../http";
import { useLoading } from "../store/loadingStore";
import { mapActions } from 'pinia'
import { ApiActions } from "./ApiActions";
import { log } from "console";
const loadingStore = useLoading();
export default class Module {
  static async GetModules(params) {

    loadingStore.setLoading(ApiActions.GetModules);
    return axios.get("/api/modules", { params }).then((res) => {
     
      loadingStore.setLoading(ApiActions.GetModules);
      return res.data.modules;
    });
  }
  static GetModulesAuth(params) {
    axios
      .get("/api/module", { params })
      .then((res) => {
        let data = res.data.data;
        if (this.role == "student") {
          this.data.forEach((d) => {
            axios
              .get("/api/module/" + d.id + "/completedCourses")
              .then((res) => {
                d.totalCourses = res.data.totalCourse;
                d.completedCourses = res.data.completedCourses;
              });
          });
        }
        return data;
      })
      .catch((err) => { });
  }
}
