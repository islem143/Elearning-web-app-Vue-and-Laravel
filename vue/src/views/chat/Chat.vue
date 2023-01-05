<template>
  <div class="card pt-5 px-5 p-fluid bg-white">

    <div v-for="msg in messages" :key="msg.id">
      <div
        :class="'flex ' + (msg.user_id == userId ? 'justify-content-end' : ' ')"
      >
        <img
          height="40"
          v-if="msg.user_id != userId"
          class="border-round-3xl mr-2"
          src="http://localhost:8081/public/images/profile1.jpg"
          alt=""
        />
        <div
          :class="
            'card p-3 text-md ' +
            (msg.user_id == userId ? 'bg-blue-500' : 'bg-blue-200')
          "
        >
          {{ msg.message }}
        </div>
      </div>
    </div>
  </div>
  <input type="text" v-model="message" />
  <button @click="sendMessage">btn</button>
</template>

<script>
import axios from "../../http";
import store from "../../store";
export default {
  name: "Chat",

  data() {
    return {
      messages: [],
      message: "",
      userId: null,
    };
  },

  created() {
    axios.get("/api/messages").then((res) => {
      console.log(res.data);
      this.messages = res.data;
    });
    this.userId = store.state.auth.user.data.id;
    console.log(this.userId);
    window.Echo.private("chat." + this.userId).listen("MessageSent", (e) => {
     // console.log("message reciedv", e.message);
      let msg = { message: e.message, user_id: e.sender_id };
      this.messages.push(msg);
    });
  },

  methods: {
    sendMessage() {
      axios
        .post("/api/messages", { message: this.message, receiver_id: 7 })
        .then((res) => {
          this.messages.push({ message: this.message, user_id: this.userId });
          console.log(res.data);
        });
    },
  },
};
</script>
