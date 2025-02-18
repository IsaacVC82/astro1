import { defineConfig } from "astro/config";

const isGitHubPages = process.env.NODE_ENV === "production";

export default defineConfig({
  i18n: {
    defaultLocale: "es",
    locales: ["es", "en"],
  },
  base: isGitHubPages ? "/astro1/" : "/", 
});

