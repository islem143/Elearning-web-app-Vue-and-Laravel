<template>
  <div>
    <div class="grid">
      <Users @select-user="selectUser" class="md:col-2 col-12" :users="users" :selectedUserId="receiver.id" />
      <div class="md:col-10 col-12">
        <Messages :messages="messages" :userId="userId" />

        <div class="flex justify-content-end">
          <InputText class="mr-1" v-model="message" />
          <Button @click="sendMessage">Send</Button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "../../http";
import { useAuth } from "../../store/authStore";
import Messages from "../../components/chat/Messages.vue";
import Users from "./ChatList.vue";
export default {
  name: "Chat",
  components: {
    Messages,
    Users,
  },

  data() {
    return {
      messages: [],
      message: "",
      userId: null,
      receiver: 0,
    };
  },
  watch: {
    receiver(val) {
      axios.get("/api/messages", { params:{receiver_id: val.id} }).then((res) => {
        this.messages = res.data;
      });
    },
  },

  created() {
    const authStore=useAuth();
    axios.get("/api/users").then((res) => {
      this.users = res.data;
      this.receiver = this.users[0];
      axios
        .get("/api/messages", { params:{receiver_id: this.receiver.id} })
        .then((res) => {
          this.messages = res.data;
        });
    });

    this.userId = store.user.data.id;
    console.log(this.userId);
    window.Echo.private("chat." + this.userId).listen("MessageSent", (e) => {
      // console.log("message reciedv", e.message);
      let msg = { message: e.message, user_id: e.sender_id };
      this.messages.push(msg);
    });
  },

  methods: {
    selectUser(user) {
      console.log(user);
      this.receiver = user;
    },
    sendMessage() {
      axios
        .post("/api/messages", {
          message: this.message,
          receiver_id: this.receiver.id,
        })
        .then((res) => {
          this.messages.push({ message: this.message, user_id: this.userId });
          console.log(res.data);
          this.message="";
        });
    },
  },
};
</script>
