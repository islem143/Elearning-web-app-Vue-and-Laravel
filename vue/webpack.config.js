const path = require("path");

console.log(__dirname);
module.exports = {
 
  resolve: {
    extensions: [".js", ".vue", ".json"],
    alias: {
      vue$: "vue/dist/vue.esm.js",
      "@": path.join(__dirname, "/src"),
    },
    module: {
      rules: [
        {
          test: /\.svg$/,
          loader: "svg-sprite-loader",
          include: [resolve("icons")],
          options: {
            symbolId: "icon-[name]",
          },
        },
      ],
    },
  },
};
Footer
