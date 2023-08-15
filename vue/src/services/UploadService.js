import axios from "../http";
// const IMAGES_EXTENSIONS=["png","jpeg","jpg"]
// const FILE_EXTENSIONS=["pdf","ppt","doc","docx"]
// const VIDEO_EXTENSIONS=["mp4"]
const dict = {
  image: ["png", "jpeg", "jpg"],
  file: ["pdf", "ppt", "doc", "docx"],
  video: ["mp4","webm"],
};

class UplaodFileService {
  upload(file, data, url, onUploadProgress) {
    let formData = new FormData();
    let type = "file";
    let extension = file.name.split(".")[1];
    for (const key in dict) {
      if (dict[key].includes(extension)) {
        type = key;
        break;
      }
    }

    formData.append("file", file);
    formData.append("type", type);
    for (const key in data) {
      formData.append(key, data[key]);
    }

    return axios.post(url, formData, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
      onUploadProgress,
    });
  }
}
export default new UplaodFileService();
