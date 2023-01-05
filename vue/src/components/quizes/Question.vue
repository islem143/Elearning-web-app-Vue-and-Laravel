<template>
  <div class="w-10 card bg-white py-4 px-6">
    <h4>Question:</h4>
    <p>
     {{question.text}}
    </p>
  </div>
</template>

<script>
export default {
  name: "Question",
  props: {
    question: {
      type: Object,
    },
  },
};
</script>
