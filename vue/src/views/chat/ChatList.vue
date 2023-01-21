<template>
  <div
    class="card pt-3 px-3 p-fluid bg-white"
    style="height: 700px; overflow: auto"
  >
    <h4>Users List</h4>
    <div
      @click="$emit('select-user', user)"
      :class="
        'card   cursor-pointer flex align-items-center hover:bg-blue-400 ' +
        (selectedUserId == user.id ? 'bg-blue-200' : '')
      "
      v-for="user in users"
      :key="user.id"
    >
      <img
        class="mr-2 max-w-2rem border-round-3xl"
        :src="'http://localhost:8081/images/' + user.profile.img_url"
        alt=""
      />
      <p>{{ user.name }}</p>
    </div>
  </div>
</template>

<script>
export default {
  name: "ChatList",
  data() {
    return {
      users: [],
    };
  },

  props: ["users", "selectedUserId"],
};
</script>
