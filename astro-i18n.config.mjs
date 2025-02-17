export default {
    defaultLang: "es", // Idioma por defecto
    supportedLangs: ["es", "en"], // Idiomas soportados
    translations: {
      es: () => import("./src/translations/es.json"), 
      en: () => import("./src/translations/en.json"),
    },
  };