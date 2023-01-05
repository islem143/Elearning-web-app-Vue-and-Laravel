<template>
  <div class="col-12">
    <div class="card">
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
      <p class="mt-4 text-2xl" v-if="data.length == 0 && search">No match found for "{{ search }}".</p>
      <module-cards
        @edit-module="editModule"
        @confirm-delete-module="confirmDeleteModule"
        @go-to="goTo"
        :modules="data"
      />

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
    </div>
  </div>
</template>

<script>
import axios from "../../http";
import ModuleCards from "./ModulesCard.vue";
export default {
  inject: ["role"],
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
      sortField: null,
      sortOptions: [
        { label: "Price High to Low", value: "!price" },
        { label: "Price Low to High", value: "price" },
      ],
    };
  },

  created() {
    this.getModules();
  },

  methods: {
    getModules() {
      let params = { title: this.search };
      axios.get("/api/module", { params }).then((res) => {
        this.data = res.data;
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
