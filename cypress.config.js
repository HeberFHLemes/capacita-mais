import { defineConfig } from "cypress";

module.exports = defineConfig({
  allowCypressEnv: false,

  e2e: {
    baseUrl: "http://localhost:8080",
    setupNodeEvents(on, config) {},
  },
});
