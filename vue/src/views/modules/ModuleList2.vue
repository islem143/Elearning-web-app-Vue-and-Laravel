<template>
  <div>
    <div class="card">
      <Toolbar class="mb-4">
        <template #start>
          <Button
            label="New"
            icon="pi pi-plus"
            class="p-button-success mr-2"
            @click="openNew"
          />
          <Button
            label="Delete"
            icon="pi pi-trash"
            class="p-button-danger"
            @click="confirmDeleteSelected"
            :disabled="!selectedItems || !selectedItems.length"
          />
        </template>

        <template #end>
          <!-- <FileUpload
              mode="basic"
              accept="image/*"
              :maxFileSize="1000000"
              label="Import"
              chooseLabel="Import"
              class="mr-2 inline-block"
            /> -->
          <Button
            label="Export"
            icon="pi pi-upload"
            class="p-button-help"
            @click="exportCSV($event)"
          />
        </template>
      </Toolbar>

      <DataTable
        ref="dt"
        :value="data"
       
        v-model:selection="selectedItems"
        dataKey="id"
        @page="list"
        :paginator="true"
        :rows="10"
        :filters="filters"
        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
        :rowsPerPageOptions="[5, 10, 25]"
        currentPageReportTemplate="Showing {first} to {last} of {totalRecords} users"
        responsiveLayout="scroll"
      >
        <template #header>
          <div
            class="table-header flex flex-column md:flex-row md:justiify-content-between"
          >
            <h5 class="mb-2 md:m-0 p-as-md-center">Manage modules</h5>
            <span class="p-input-icon-left">
              <i class="pi pi-search" />
              <InputText
                v-model="filters['global'].value"
                placeholder="Search..."
              />
            </span>
          </div>
        </template>

        <Column
          selectionMode="multiple"
          style="width: 3rem"
          :exportable="false"
        ></Column>

        <Column field="title" header="Title" style="min-width: 16rem"></Column>
        <Column
          field="descprtion"
          header="Description"
          style="min-width: 16rem"
        ></Column>
        <Column
          field="total_users"
          header="Enrolled students"
          style="min-width: 16rem"
        ></Column>
        <Column
          field="total_courses"
          header="Courses"
          style="min-width: 16rem"
        ></Column>

        <Column :exportable="false" style="min-width: 8rem">
          <template #body="slotProps">
            <Button
              icon="pi pi-pencil"
              class="p-button-rounded p-button-success mr-2"
              @click="editItem(slotProps.data)"
            />
            <Button
              icon="pi pi-trash"
              class="p-button-rounded p-button-warning"
              @click="confirmDeleteItem(slotProps.data)"
            />
          </template>
        </Column>
      </DataTable>
    </div>

    <Dialog
      v-model:visible="itemDialog"
      :style="{ width: '450px' }"
      header="Module Details"
      :modal="true"
      class="p-fluid"
    >
      <div class="w-full md:w-10 mx-auto">
        <label for="title" class="block text-900 text-xl font-medium mb-2"
          >Title</label
        >
        <InputText
          id="title"
          v-model="item.title"
          type="text"
          class="w-full mb-3"
          placeholder="Name"
          style="padding: 1rem"
          @input="v$.item.title.$touch()"
          @blur="v$.item.title.$touch()"
        />
        <p class="p-error" v-for="err in errorMessages('title')">{{ err }}</p>

        <label for="description" class="block text-900 text-xl font-medium mb-2"
          >Description</label
        >
        <InputText
          id="description"
          v-model="item.descprtion"
          type="text"
          class="w-full mb-3"
          placeholder="Description"
          style="padding: 1rem"
          @input="!editMode && v$.item.descprtion.$touch()"
          @blur="!editMode && v$.item.descprtion.$touch()"
        />

        <p class="p-error" v-for="err in errorMessages('descprtion')">
          {{ err }}
        </p>
      </div>
      <template #footer>
        <Button
          label="Cancel"
          icon="pi pi-times"
          class="p-button-text"
          @click="hideDialog"
        />
        <Button
          label="Save"
          icon="pi pi-check"
          class="p-button-text"
          @click="saveItem"
        />
      </template>
    </Dialog>

    <Dialog
      v-model:visible="deleteItemDialog"
      :style="{ width: '450px' }"
      header="Confirm"
      :modal="true"
    >
      <div class="confirmation-content">
        <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem" />
        <span v-if="item"
          >Are you sure you want to delete <b>{{ item.title }}</b
          >?</span
        >
      </div>
      <template #footer>
        <Button
          label="No"
          icon="pi pi-times"
          class="p-button-text"
          @click="deleteItemDialog = false"
        />
        <Button
          label="Yes"
          icon="pi pi-check"
          class="p-button-text"
          @click="deleteItem"
        />
      </template>
    </Dialog>

    <Dialog
      v-model:visible="deleteItemsDialog"
      :style="{ width: '450px' }"
      header="Confirm"
      :modal="true"
    >
      <div class="confirmation-content">
        <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem" />
        <span v-if="item"
          >Are you sure you want to delete the selected items?</span
        >
      </div>
      <template #footer>
        <Button
          label="No"
          icon="pi pi-times"
          class="p-button-text"
          @click="deleteItemsDialog = false"
        />
        <Button
          label="Yes"
          icon="pi pi-check"
          class="p-button-text"
          @click="deleteSelectedItems"
        />
      </template>
    </Dialog>
  </div>
</template>

<script>
import { FilterMatchMode } from "primevue/api";
import axios from "../../http";
import {
  required,
  integer,
  minValue,
  minLength,
  email,
} from "@vuelidate/validators";
import { helpers } from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";

export default {
  setup() {
    return { v$: useVuelidate() };
  },
  data() {
    return {
      roles: [{ name: "teacher" }, { name: "student" }],
      data: [],
      itemDialog: false,
      deleteItemDialog: false,
      deleteItemsDialog: false,
      item: {
        title: null,
        descprtion: null,
      },
      page: 0,
      search: "",
      count: 5,
      selectedItems: null,
      filters: {},
      submitted: false,
      editMode: false,
    };
  },
  userService: null,
  created() {
    this.getModules();
    axios.get("/api/module/count").then((res) => {
      this.count = res.data.count;
    });
    this.initFilters();
  },
  validations() {
    let validation = {};

    if (this.editMode) {
      validation = {
        item: {
          title: { required },
          descprtion: { required },
        },
      };
    } else {
      validation = {
        item: {
          title: { required },
          descprtion: { required },
        },
      };
    }
    return validation;
  },

  methods: {
    list(e) {
      this.page = e.page;
      this.getModules();
    },
    errorMessages(key) {
      const errors = [];

      if (!this.v$.item[key].$dirty) return errors;
      for (const err of this.v$.item[key].$errors) {
        errors.push(err.$message);
      }

      return errors;
    },
    getModules() {
      let params = { title: this.search, page: this.page + 1 };
      if (!this.role) {
        axios.get("/api/module", { params }).then((res) => {
          this.data = res.data.data;
        });
        return;
      }
    },
    openNew() {
      this.item = {};
      this.submitted = false;
      this.itemDialog = true;
    },
    hideDialog() {
      this.itemDialog = false;
      this.submitted = false;
    },
    async saveItem() {
      this.submitted = true;
      const isFormCorrect = await this.v$.$validate();
      if (!isFormCorrect) {
        return;
      }
      if (this.editMode) {
        axios.put("/api/module/" + this.item.id, this.item).then((res) => {
          let index = this.data.findIndex((val) => val.id == this.item.id);
   
          this.data.splice(index, 1, this.item);
          this.editMode = false;
          this.$toast.add({
            severity: "success",
            summary: "Successful",
            detail: "item updated",
            life: 3000,
          });
        });
      } else {
        axios.post("/api/module", this.item).then((res) => {
          this.data.push(res.data);
          this.$toast.add({
            severity: "success",
            summary: "Successful",
            detail: "item created",
            life: 3000,
          });
        });
      }
      this.itemDialog = false;
    },
    editItem(item) {
      this.item = { ...item };
      this.editMode = true;
      this.itemDialog = true;
    },
    confirmDeleteItem(item) {
      this.item = item;
      this.deleteItemDialog = true;
    },
    deleteItem() {
      axios.delete("/api/module/" + this.item.id).then((res) => {
        this.data = this.data.filter((val) => val.id !== this.data.id);
        this.deleteItemDialog = false;
        this.item = {};
        this.$toast.add({
          severity: "success",
          summary: "Successful",
          detail: "item Deleted",
          life: 3000,
        });
        this.deleteitemDialog = false;
      });
    },
    findIndexById(id) {
      let index = -1;
      for (let i = 0; i < this.data.length; i++) {
        if (this.data[i].id === id) {
          index = i;
          break;
        }
      }

      return index;
    },
    createId() {
      let id = "";
      var chars =
        "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
      for (var i = 0; i < 5; i++) {
        id += chars.charAt(Math.floor(Math.random() * chars.length));
      }
      return id;
    },
    exportCSV() {
      this.$refs.dt.exportCSV();
    },
    confirmDeleteSelected() {
      this.deleteItemsDialog = true;
    },
    deleteSelectedItems() {
      // this.users = this.users.filter(
      //   (val) => !this.selectedUsers.includes(val)
      // );
      for (const item of this.selectedItems) {
        axios
          .delete("/api/module/" + item.id)
          .then((res) => {
            this.data = this.data.filter((val) => val.id !== item.id);

            this.item = {};
          })
          .catch((err) => {
            console.log(err);
          });
      }

      this.$toast.add({
        severity: "success",
        summary: "Successful",
        detail: "items Deleted successfully",
        life: 3000,
      });
      this.deleteItemsDialog = false;
      this.selectedItems = null;
    },
    initFilters() {
      this.filters = {
        global: { value: null, matchMode: FilterMatchMode.CONTAINS },
      };
    },
  },
};
</script>

<style lang="scss" scoped>
.table-header {
  display: flex;
  align-items: center;
  justify-content: space-between;

  @media screen and (max-width: 960px) {
    align-items: start;
  }
}

.user-image {
  width: 50px;
  box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
}

.p-dialog .user-image {
  width: 50px;
  margin: 0 auto 2rem auto;
  display: block;
}

.confirmation-content {
  display: flex;
  align-items: center;
  justify-content: center;
}
@media screen and (max-width: 960px) {
  ::v-deep(.p-toolbar) {
    flex-wrap: wrap;

    .p-button {
      margin-bottom: 0.25rem;
    }
  }
}
</style>
