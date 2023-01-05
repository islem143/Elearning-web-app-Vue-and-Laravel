<template>
  <Dialog header="Header" v-model:visible="visible">
    <iframe
      :src="'http://www.youtube.com/embed/' + url"
      width="560"
      height="315"
      frameborder="0"
      allowfullscreen
    ></iframe>
  </Dialog>
</template>


<script>
export default {
  name: "Dialog",
  props: ["url", "display"],
};
</script>