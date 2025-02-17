import esTranslations from './translations/es.json';
import enTranslations from './translations/en.json';

export const translationsData = {
  es: esTranslations,
  en: enTranslations,
};

export const loadTranslations = (lang) => {
  return translationsData[lang] || translationsData['es'];
};
