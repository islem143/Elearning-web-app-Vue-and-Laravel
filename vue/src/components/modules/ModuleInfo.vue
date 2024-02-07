<template>
  <div
    class="card surface-100 transition-all transition-duration-200 shadow-2 hover:bg-gray-100 hover:shadow-4"
  >
    <div class="">
      <h5>Module</h5>
      <img
        width="250"
        class="border-round"
        :src="'http://localhost:8081/images/' + src"
        alt=""
      />
    </div>
    <div class="p-2">
      <h3 class="mt-2">{{ info.title }}</h3>
      <p>
        {{ info.description }} Lorem ipsum dolor sit amet consectetur
        adipisicing elit. Quisquam asperiores placeat, fuga hic impedit deserunt
        tempore odio repudiandae ratione aperiam
      </p>
    </div>
    <Button
      style="width: 150px"
      @click="emit('add-course')"
      label="Add Course"
    />
    
  </div>
</template>

<script>
export default {
  name: "ModuleInfo",
  props: {
    info: {
      type: Object,
    },
  },
  computed: {
    src() {
      return this.info.img_url.split("/")[2];
    },
  },
};
</script>
