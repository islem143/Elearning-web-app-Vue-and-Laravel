<template>
  <div>
    <h2>Student Log History:</h2>
    <DataTable class="mt-5" :value="logs" responsiveLayout="scroll">
      <Column field="user_id" header="id"></Column>
      <Column field="user_name" header="User Name"></Column>
      <Column field="role" header="Role"></Column>
      <Column field="created_at" header="Last Login"></Column>
    </DataTable>
  </div>
</template>

<script>
import axios from "../../http";
export default {
  name: "LogList",
  data() {
    return {
      logs: [],
    };
  },

  created() {
    axios.get("/api/logs").then((res) => {
      this.logs = res.data;
    });
  },
};
</script>
