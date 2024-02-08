import axios from "../http";

class Category {
  static getList() {
    return axios.get("/api/categories").then((res) => {
      return res.data.categories;
    });
  }
}

export default Category;
