<template>
  <div class="col-12">
    <div class="card">
      <h3>My Modules</h3>
      <div class="flex align-items-center">
        <div class="p-input-icon-right col-4">
          <i class="pi pi-search" />
          <InputText
            type="text"
            class="w-full"
            v-model="search"
            placeholder="Search"
            @input="getModules"
          />
        </div>
      </div>
      <p class="mt-4 text-2xl" v-if="data.length == 0 && search">
        No match found for "{{ search }}".
      </p>
      <module-cards @go-to="goTo" :mylist="true" :modules="data" />
    <Paginator :rows="3" @page="list" :totalRecords="count"></Paginator>
    </div>
  </div>
</template>

<script>
import axios from "../../http";
import ModuleCards from "./ModulesCard.vue";
export default {
  components: {
    ModuleCards,
  },
  data() {
    return {
      selectedModule: null,
      deleteModuleDialog: false,
      data: [],
      search: "",
      layout: "grid",
      sortKey: null,
      sortOrder: null,
      page: 0,
      count:0,
      sortField: null,
      sortOptions: [
        { label: "Price High to Low", value: "!price" },
        { label: "Price Low to High", value: "price" },
      ],
    };
  },

  created() {
    this.getModules();
    axios.get("/api/module/count").then((res) => {
     this.count=res.data.count;

    });
  },

  methods: {
    list(e) {
      this.page = e.page;
      this.getModules();
    },
    getModules() {
      let params = { title: this.search,page:this.page+1 };
      axios.get("/api/module/myModules", { params }).then((res) => {
        this.data = res.data.data;

        this.data.forEach((d) => {
          axios.get("/api/module/" + d.id + "/completedCourses").then((res) => {
            d.totalCourses = res.data.totalCourse;
            d.completedCourses = res.data.completedCourses;
          });
        });
      });
    },
    src(info) {
      console.log(info);
      return info.img_url.split("/")[2];
    },
    goTo(data) {
      this.$router.push({
        name: "module-detail",
        params: { moduleId: data.id },
      });
    },

    onSortChange(event) {
      const value = event.value.value;
      const sortValue = event.value;

      if (value.indexOf("!") === 0) {
        this.sortOrder = -1;
        this.sortField = value.substring(1, value.length);
        this.sortKey = sortValue;
      } else {
        this.sortOrder = 1;
        this.sortField = value;
        this.sortKey = sortValue;
      }
    },
  },
};
</script>

<style scoped lang="scss">
//@import '../assets/demo/badges.scss';
</style>
