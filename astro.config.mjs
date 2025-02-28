import { defineConfig } from "astro/config";

export default defineConfig({
  site: "https://isaacvc82.github.io/astro1", 
  //base: "/astro1/", 
  output: "static", // Para que genere archivos estáticos en /dist
  
  i18n: {
    defaultLocale: "es",
    locales: ["es", "en"],
  },

  vite: {
    server: {
      port: 4321, 
    },
    build: {
      outDir: "dist", 
    },
  },
});

