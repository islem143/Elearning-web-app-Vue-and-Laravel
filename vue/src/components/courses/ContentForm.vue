<template>
  <div>
    <QuillEditor toolbar="full" v-model:content="content" theme="snow" />
    <button @click="$emit('add-content', content)">add content</button>
  </div>
</template>

<script>
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
export default {
  name: "ContentForm",
  components: {
    QuillEditor,
  },
  data() {
    return {
      content: {},
    };
  },
};
</script>
