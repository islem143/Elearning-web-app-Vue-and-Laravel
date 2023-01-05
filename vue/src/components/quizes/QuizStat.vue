<template>
  <div
    class="w-7 pa-7 bg-white text-xl cursor-pointer p-5 m-4 border-round transition-all transition-duration-200 hover:bg-gray-100 shadow-4 hover:shadow-6"
  >
    <h3 class="text-center mb-5">Result</h3>
    <div class="flex justify-content-between">
      <p>Total points:</p>
      <p>{{ totalPoints }}</p>
    </div>
    <div class="flex justify-content-between">
      <p>Duration:</p>
      <p>
        {{ parseInt(duration / 1000 / 60) + "mn" }}
        {{ ((duration / 1000) % 60) + "s" }}
      </p>
    </div>
  </div>
</template>

<script>
export default {
  name: "QuizStat",
  props: {
    totalPoints: {
      type: Number,
    },
    duration: {
      type: Number,
    },
  },
};
</script>
