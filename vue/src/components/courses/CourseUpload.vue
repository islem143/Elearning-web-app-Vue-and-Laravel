<template>
  
  <div v-if="progressInfos">
    <div
      class="mb-2"
      v-for="(progressInfo, index) in progressInfos"
      :key="index"
    >
      <span>{{ progressInfo.fileName }}</span>
      <div class="progress">
        <div
          class="progress-bar progress-bar-info"
          role="progressbar"
          :aria-valuenow="progressInfo.percentage"
          aria-valuemin="0"
          aria-valuemax="100"
          :style="{ width: progressInfo.percentage + '%' }"
        >
          {{ progressInfo.percentage }}%
        </div>
      </div>
    </div>
  </div>

  <div class="card relative surface-300 field mt-3">
    <h5>Attachement</h5>

    <!-- <Dropdown
      class="my-2"
      v-model="m.type"
      :options="types"
      placeholder="Select a type"
    /> -->
    <FileUpload
      name="demo[]"
      :customUpload="true"
      @select="selectFile"
      @uploader="uploader"
      :multiple="true"
    >
      <template #content="{ uploadedFiles, progress }">
        <ul v-if="uploadedFiles && uploadedFiles[0]">
          ds
          <li v-for="file of uploadedFiles[0]" :key="file">
            {{ file.name }} - {{ file.size }} bytes
          </li>
        </ul>
      </template>
      <template #empty>
        <p>Drag and drop files to here to upload.</p>
      </template>
    </FileUpload>
    <!-- <FileUpload
      :multiple="true"
      :customUpload="true"
      @uploader="selectFile"
      :ref="'file' + index"
      mode="basic"
      :name="m.type"
      :maxFileSize="1000000"
    /> -->
    <!-- <Button class="mt-5" @click="uploadFiles" label="Upload" /> -->
  </div>
</template>

<script>
export default {
  name: "CourseUpload",
  props: {
    media: {
      type: Array,
    },
    courseId: {
      type: String,
    },
  },
  data() {
    return {
      selectedFiles: undefined,
      progressInfos: [],
      message: "",

      fileInfos: [],
    };
  },
  methods: {
    selectFile(e) {
      // this.progressInfos = [];
      this.selectedFiles = e.files;
    },
    uploader() {
      this.$emit("upload-files",this.selectedFiles);
    
      
    },

    uploadFiles() {
      this.message = "";

      for (let i = 0; i < this.selectedFiles.length; i++) {
        this.upload(i, this.selectedFiles[i]);
      }
    },
    upload(idx, file) {
      this.progressInfos[idx] = { percentage: 0, fileName: file.name };

      UploadService.upload(
        file,
        { courseId: this.courseId },
        "/api/media",
        (event) => {
          this.progressInfos[idx].percentage = Math.round(
            (100 * event.loaded) / event.total
          );
        }
      ).then((response) => {
        let prevMessage = this.message ? this.message + "\n" : "";
        this.message = prevMessage + response.data.message;

        // return UploadService.getFiles();
      });
      // .then((files) => {
      //   this.fileInfos = files.data;
      // })
      // .catch(() => {
      //   this.progressInfos[idx].percentage = 0;
      //   this.message = "Could not upload the file:" + file.name;
      // });
    },
  },
};
</script>
