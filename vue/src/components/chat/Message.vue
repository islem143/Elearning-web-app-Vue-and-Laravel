<template>
  <div :class="'flex ' + (message.user_id == userId ? 'justify-content-end' : ' ')">
    <img
      height="40"
      v-if="message.user_id != userId"
      class="border-round-3xl mr-2"
      src="http://localhost:8081/public/images/profile1.jpg"
      alt=""
    />
    <div
      :class="
        'card p-3 text-md ' +
        (message.user_id == userId ? 'bg-blue-500' : 'bg-blue-200')"
      
    >
      {{ message.message }}
    </div>
  </div>
</template>

<script>
export default {
  name: "Message",
  props: {
    message: {
      type: Object,
    },
    userId:{
        type:String
    }
  },
};
</script>
