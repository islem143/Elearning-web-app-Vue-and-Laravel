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
            :disabled="!selectedUsers || !selectedUsers.length"
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
        :value="users"
        v-model:selection="selectedUsers"
        dataKey="id"
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
            <h5 class="mb-2 md:m-0 p-as-md-center">Manage users</h5>
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
        <Column header="Image">
          <template #body="slotProps">
            <img
            v-if="slotProps.data.profile"
              :src="
                'http://localhost:8081/images/' + slotProps.data.profile.img_url
              "
              class="user-image"
            />
          </template>
        </Column>
        <Column
          field="id"
          header="Id"
          :sortable="true"
          style="min-width: 12rem"
        ></Column>
        <Column field="email" header="Email" style="min-width: 16rem"></Column>
        <Column field="name" header="Name" style="min-width: 16rem"></Column>

        <Column field="role" header="Role" style="min-width: 10rem"></Column>

        <Column :exportable="false" style="min-width: 8rem">
          <template #body="slotProps">
            <Button
              icon="pi pi-pencil"
              class="p-button-rounded p-button-success mr-2"
              @click="editUser(slotProps.data)"
            />
            <Button
              icon="pi pi-trash"
              class="p-button-rounded p-button-warning"
              @click="confirmDeleteuser(slotProps.data)"
            />
          </template>
        </Column>
      </DataTable>
    </div>

    <Dialog
      v-model:visible="userDialog"
      :style="{ width: '450px' }"
      header="user Details"
      :modal="true"
      class="p-fluid"
    >
      <div class="w-full md:w-10 mx-auto">
        <label for="name" class="block text-900 text-xl font-medium mb-2"
          >Name</label
        >
        <InputText
          id="name"
          v-model="user.name"
          type="text"
          class="w-full mb-3"
          placeholder="Name"
          style="padding: 1rem"
          @input="v$.user.name.$touch()"
          @blur="v$.user.name.$touch()"
        />
        <p class="p-error" v-for="err in errorMessages('name')">{{ err }}</p>

        <label for="email1" class="block text-900 text-xl font-medium mb-2"
          >Email</label
        >
        <InputText
          :disabled="editMode"
          id="email1"
          v-model="user.email"
          type="text"
          class="w-full mb-3"
          placeholder="Email"
          style="padding: 1rem"
          @input="!editMode && v$.user.email.$touch()"
          @blur="!editMode && v$.user.email.$touch()"
        />
        <p
          class="p-error"
          v-if="!editMode"
          v-for="err in errorMessages('email')"
        >
          {{ err }}
        </p>
        <label for="password1" class="block text-900 font-medium text-xl mb-2"
          >Role</label
        >
        <Dropdown
          :disabled="editMode"
          @change="setRole"
          v-model="user.role"
          :options="roles"
          class="mt-2"
          optionLabel="name"
          placeholder="Select an Answer"
        />
        <label for="password1" class="block text-900 font-medium text-xl mb-2"
          >Password</label
        >
        <Password
          id="password1"
          v-model="user.password"
          placeholder="Password"
          :toggleMask="true"
          class="w-full mb-3"
          inputClass="w-full"
          inputStyle="padding:1rem"
          @input="v$.user.password.$touch()"
          @blur="v$.user.password.$touch()"
        ></Password>
        <p class="p-error" v-for="err in errorMessages('password')">
          {{ err }}
        </p>

        <label for="password2" class="block text-900 font-medium text-xl mb-2"
          >Password Confirmation</label
        >
        <Password
          id="password2"
          v-model="user.password_confirmation"
          placeholder="Password Confirmation"
          :toggleMask="true"
          class="w-full mb-3"
          inputClass="w-full"
          inputStyle="padding:1rem"
          @input="v$.user.password_confirmation.$touch()"
          @blur="v$.user.password_confirmation.$touch()"
        ></Password>
        <p
          class="p-error"
          v-for="err in errorMessages('password_confirmation')"
        >
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
          @click="saveUser"
        />
      </template>
    </Dialog>

    <Dialog
      v-model:visible="deleteUserDialog"
      :style="{ width: '450px' }"
      header="Confirm"
      :modal="true"
    >
      <div class="confirmation-content">
        <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem" />
        <span v-if="user"
          >Are you sure you want to delete <b>{{ user.name }}</b
          >?</span
        >
      </div>
      <template #footer>
        <Button
          label="No"
          icon="pi pi-times"
          class="p-button-text"
          @click="deleteUserDialog = false"
        />
        <Button
          label="Yes"
          icon="pi pi-check"
          class="p-button-text"
          @click="deleteUser"
        />
      </template>
    </Dialog>

    <Dialog
      v-model:visible="deleteUsersDialog"
      :style="{ width: '450px' }"
      header="Confirm"
      :modal="true"
    >
      <div class="confirmation-content">
        <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem" />
        <span v-if="user"
          >Are you sure you want to delete the selected users?</span
        >
      </div>
      <template #footer>
        <Button
          label="No"
          icon="pi pi-times"
          class="p-button-text"
          @click="deleteUsersDialog = false"
        />
        <Button
          label="Yes"
          icon="pi pi-check"
          class="p-button-text"
          @click="deleteSelectedUsers"
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
      users: [],
      userDialog: false,
      deleteUserDialog: false,
      deleteUsersDialog: false,
      user: {
        name: null,
        email: null,
        role: null,
        password: null,
        password_confirmation: null,
      },
      selectedUsers: null,
      filters: {},
      submitted: false,
      editMode: false,
      statuses: [
        { label: "INSTOCK", value: "instock" },
        { label: "LOWSTOCK", value: "lowstock" },
        { label: "OUTOFSTOCK", value: "outofstock" },
      ],
    };
  },
  userService: null,
  created() {
    axios.get("/api/users").then((res) => {
      this.users = res.data;
    });
    this.initFilters();
  },
  validations() {
    let validation = {};

    if (this.editMode) {
      validation = {
        user: {
          name: { required },

          password: {
            minLength: !this.user.password ? {} : minLength(5),
            checkPasswodrd: !this.user.password
              ? {}
              : helpers.withMessage(
                  "No Matching Passwordrs",
                  (val) => val && val === this.user.password_confirmation
                ),
          },
          password_confirmation: {
            minLength: !this.user.password_confirmation ? {} : minLength(5),
            checkPasswodrd: !this.user.password
              ? {}
              : helpers.withMessage(
                  "No Matching Passwordrs",
                  (val) => val && val === this.user.password
                ),
          },
        },
      };
    } else {
      validation = {
        user: {
          name: { required },
          email: { required },
          password: {
            minLength: minLength(5),
            checkPasswodrd: helpers.withMessage(
              "No Matching Passwordrs",
              (val) => val && val === this.user.password_confirmation
            ),
          },
          password_confirmation: {
            minLength: minLength(5),
            checkPasswodrd: helpers.withMessage(
              "No Matching Passwordrs",
              (val) => val && val === this.user.password
            ),
          },
        },
      };
    }
    return validation;
  },

  methods: {
    setRole(e) {
      this.user.role = e.value;
    },
    errorMessages(key) {
      const errors = [];

      if (!this.v$.user[key].$dirty) return errors;
      for (const err of this.v$.user[key].$errors) {
        errors.push(err.$message);
      }

      return errors;
    },
    openNew() {
      this.user = {};
      this.submitted = false;
      this.userDialog = true;
    },
    hideDialog() {
      this.userDialog = false;
      this.submitted = false;
    },
    async saveUser() {
      this.submitted = true;
      const isFormCorrect = await this.v$.$validate();
      if (!isFormCorrect) {
        return;
      }
      if (this.editMode) {
        axios.put("/api/users/" + this.user.id, this.user).then((res) => {
          let index = this.users.findIndex((val) => val.id == this.user.id);
          console.log(res.data);
          this.users.splice(index, 1, res.data);
          this.editMode = false;
          this.$toast.add({
            severity: "success",
            summary: "Successful",
            detail: "user updated",
            life: 3000,
          });
        });
      } else {
        let user = { ...this.user, role: this.user.role.name };
        axios.post("/api/users", user).then((res) => {
          this.users.push(res.data);
          this.$toast.add({
            severity: "success",
            summary: "Successful",
            detail: "user creatd",
            life: 3000,
          });
        });
      }
      this.userDialog = false;
    },
    editUser(user) {
      this.user = { ...user };
      this.editMode = true;
      this.userDialog = true;
    },
    confirmDeleteuser(user) {
      this.user = user;
      this.deleteUserDialog = true;
    },
    deleteUser() {
      axios.delete("/api/users/" + this.user.id).then((res) => {
        this.users = this.users.filter((val) => val.id !== this.user.id);
        this.deleteUserDialog = false;
        this.user = {};
        this.$toast.add({
          severity: "success",
          summary: "Successful",
          detail: "user Deleted",
          life: 3000,
        });
        this.deleteUserDialog = false;
      });
    },
    findIndexById(id) {
      let index = -1;
      for (let i = 0; i < this.users.length; i++) {
        if (this.users[i].id === id) {
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
      this.deleteUsersDialog = true;
    },
    deleteSelectedUsers() {
      // this.users = this.users.filter(
      //   (val) => !this.selectedUsers.includes(val)
      // );
      for (const user of this.selectedUsers) {
        axios
          .delete("/api/users/" + this.user.id)
          .then((res) => {
            this.users = this.users.filter((val) => val.id !== user.id);
            this.deleteUserDialog = false;
            this.user = {};

            this.deleteUserDialog = false;
          })
          .catch((err) => {
            return;
          });
        this.$toast.add({
          severity: "success",
          summary: "Successful",
          detail: "users Deleted successfully",
          life: 3000,
        });
      }

      this.deleteUsersDialog = false;
      this.selectedUsers = null;
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
