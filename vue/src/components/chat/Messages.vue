<template>
  <div
    class="card pt-5 px-5 p-fluid bg-white"
    style="height: 700px; overflow: auto"
  >
    <div v-for="msg in messages" :key="msg.id">
      <Message :message="msg" :userId="userId" />
    </div>
    <ScrollTop target="parent" :threshold="200" />
  </div>
</template>

<script>
import Message from "./Message.vue";
export default {
  name: "Messages",
  props: {
    messages: {
      type: Array,
    },
    userId: {
      type: String,
    },
  },
  components: {
    Message,
  },
};
</script>
