import axios from "../http";
export class Module {
  static GetModules(params) {
    return axios.get("/api/modules", { params }).then((res) => {
      return res.data.data;
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
      .catch((err) => {});
  }
}
