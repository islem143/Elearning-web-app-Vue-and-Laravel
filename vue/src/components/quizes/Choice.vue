<template>
  <div
    :class="
      'w-9 card py-4 px-6 cursor-pointer hover:surface-400 ' +
      classes +
      ' ' +
      correctChoice
    "
    @click="$emit('selectAnswer', choice)"
  >
    <p>
      {{ choice.text }}
    </p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      classes: null,
    };
  },
  props: {
    choice: {
      type: Object,
    },
    selectedChoice: {
      type: Object,
    },
    correctChoice: {
      type: Object,
    },
  },

  watch: {
    selectedChoice: {
      handler(val) {
        this.classes =
          this.selectedChoice && this.selectedChoice.id == this.choice.id
            ? "surface-300 "
            : "bg-white";
      },
      immediate: true,
    },
  },
  computed: {
    correctChoice() {
      if (this.correctChoice && this.correctChoice.id == this.choice.id) {
        this.classes = null;
        return "bg-green-500";
      } else if (
        this.correctChoice &&
        this.correctChoice.id != this.choice.id &&
        this.selectedChoice.id == this.choice.id
      ) {
        this.classes = null;
        return "bg-red-500";
      } else {
        return "";
      }
    },
  },
  name: "Choice",
};
</script>
