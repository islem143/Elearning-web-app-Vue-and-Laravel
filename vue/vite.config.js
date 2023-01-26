import { defineConfig, loadEnv } from "vite";
import vue from "@vitejs/plugin-vue";

// https://vitejs.dev/config/

// export default defineConfig({
//   server: {

//     host: "0.0.0.0",
//     port: 3000,

//   },
//   plugins: [vue()],
// });



export default ({ mode }) => {
  // Load app-level env vars to node-level env vars.
  process.env = { ...process.env, ...loadEnv(mode, process.cwd()) };

  return defineConfig({
    server: {
      host: "0.0.0.0",
      port: process.env.VITE_PORT,
    },
    plugins: [vue()],
  });
};
