import { defineConfig } from "astro/config";

export default defineConfig({
  output: "static", // Para que genere archivos estáticos en /dist
  
  i18n: {
    defaultLocale: "es",
    locales: ["es", "en"],
  }
});

