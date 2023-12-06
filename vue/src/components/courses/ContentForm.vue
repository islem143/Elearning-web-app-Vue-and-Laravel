<template>
  <div>
    <QuillEditor toolbar="full" v-model="content" theme="snow" />
    <Button @click="$emit('add-content', content)">Add content</Button>
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
