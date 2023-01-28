<template>
  <div v-if="loading">Verifing email...</div>
</template>

<script>
import axios from "../../http";
export default {
  name: "Login",
  data() {
    loading: true;
  },
  created() {
    
    this.verify();
  },

  methods: {
    verify() {
      let params = { id: this.$route.query.id, hash: this.$route.query.hash };
      axios
        .get("/api/email-verification", {
          params,
        })
        .then((res) => {
          
          console.log(res);
        });
    },
  },
};
</script>
