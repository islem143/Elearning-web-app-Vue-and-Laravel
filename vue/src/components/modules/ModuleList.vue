<template>
  <div class="flex">
    <SideBarFilter
      @search-modules="getModules"
      class="w-2"
      :page="page"
    ></SideBarFilter>
    <div class="card w-9 mx-auto">
      <ProgressBar
        v-if="loading[ApiActions.GetModules]"
        mode="indeterminate"
        style="height: 6px"
      ></ProgressBar>

      <h3>Modules</h3>

      <div class="flex align-items-center">
        <router-link v-if="role == 'teacher'" :to="{ name: 'module-create' }">
          <Button
            label="New Module"
            icon="pi pi-plus"
            class="p-button-success mr-2"
            @click="openNew"
          />
        </router-link>
      </div>

      <p class="mt-4 text-2xl" v-if="data.length == 0 && search">
        No match found for "{{ search }}".
      </p>

      <div class="gap-3 mt-4">
        <module-cards
          :mylist="false"
          @edit-module="editModule"
          @confirm-delete-module="confirmDeleteModule"
          :completedCourses="completedCourses"
          @go-to="goTo"
          @enroll="enroll"
          :modules="data"
        />
      </div>
      <Dialog
        v-model:visible="deleteModuleDialog"
        :style="{ width: '450px' }"
        header="Confirm"
        :modal="true"
      >
        <div class="confirmation-content">
          <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem" />
          <span>Are you sure you want to delete the selected module?</span>
        </div>
        <template #footer>
          <Button
            label="No"
            icon="pi pi-times"
            class="p-button-text"
            @click="deleteModuleDialog = false"
          />
          <Button
            label="Yes"
            icon="pi pi-check"
            class="p-button-text"
            @click="deleteModule"
          />
        </template>
      </Dialog>

      <Paginator :rows="10" @page="list" :totalRecords="count"></Paginator>
    </div>
  </div>
</template>

<script lang="ts">
import axios from "../../http";
import ModuleCards from "./ModulesCard.vue";
import SideBarFilter from "../Filters/SideBarFilter.vue";
import Module from "../../api/Module";
import { mapState } from "pinia";
import { useLoading } from "../../store/loadingStore";
import { ApiActions } from "../../api/ApiActions";
export default {
  inject: ["role"],
  components: {
    ModuleCards,
    SideBarFilter,
  },
  data() {
    return {
      ApiActions: ApiActions,
      selectedModule: null,
      deleteModuleDialog: false,
      data: [],
      search: "",
      layout: "grid",
      sortKey: null,
      sortOrder: null,
      sortField: null,
      page: 0,
      completedCourses: [],
      count: 0,
      sortOptions: [
        { label: "Price High to Low", value: "!price" },
        { label: "Price Low to High", value: "price" },
      ],
    };
  },

  created() {
    this.getModules({ title: "", categories: [] });
    axios.get("/api/module/count").then((res) => {
      this.count = res.data.count;
    });
  },
  computed: {
    ...mapState(useLoading, ["loading"]),
  },
  methods: {
    list(e) {
      this.page = e.page;
      this.getModules({ title: "", categories: [] });
    },
    enroll(module) {
      axios.post("/api/module/join", { moduleId: module.id }).then((res) => {
        this.$toast.add({
          severity: "success",
          summary: "you have been entrolled to this module ",

          life: 3000,
        });
        this.getModules({ title: "", categories: [] });
      });
    },
    async getModules(params = {}) {
      params = { ...params, page: this.page + 1 };

      let res = await Module.GetModules(params);
      this.data = res.data;

      if (this.role == "student") {
        this.completedCourses = res.data.completed_courses;
      }
    },
    src(info) {
      return info.img_url.split("/")[2];
    },
    goTo(data) {
      this.$router.push({
        name: "module-detail",
        params: { moduleId: data.id },
      });
    },
    editModule(data) {
      if (this.role == "teacher") {
        this.$router.push({
          name: "module-edit",
          params: { moduleId: data.id },
        });
      }
    },
    async deleteModule() {
      await axios
        .delete("/api/module/" + this.selectedModule.id)
        .then((res) => {
          this.deleteModuleDialog = false;
          let index = this.data.findIndex(
            (d) => d.id == this.selectedModule.id
          );
          this.data.splice(index, 1);
        });
    },

    confirmDeleteModule(data) {
      this.deleteModuleDialog = true;
      this.selectedModule = data;
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
../../api/Module
