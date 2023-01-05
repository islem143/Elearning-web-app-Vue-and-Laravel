<template>
  <Choice
    :selectedChoice="selectedChoice"
    :correctChoice="correctChoice"
    @selectAnswer="$emit('selectAnswer', choice)"
    v-for="choice in choices"
    :choice="choice"
  />
</template>

<script>
import Choice from "./Choice.vue";
export default {
  name: "Choices",
  props: {
    choices: {
      type: Array,
    },
    selectedChoice: {
      type: Object,
    },
    correctChoice: {
      type: Object,
    },
  },

  components: {
    Choice,
  },
};
</script>
