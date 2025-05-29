<template>
  <footer>
    <p>{{ universityYear }}</p>
    <form method="get" action="">
      <select v-model="selectedLocale" @change="changeLocale">
        <option v-for="(language, locale) in locales" :key="locale" :value="locale">
          {{ language }}
        </option>
      </select>
    </form>
  </footer>
</template>

<script>
export default {
  data() {
    return {
      universityYear: '2025',
      selectedLocale: 'fr',
      locales: {
        ar: 'AR',
        de: 'DE',
        en: 'EN',
        es: 'ES',
        fr: 'FR',
        it: 'IT',
        ja: 'JA',
        ko: 'KO',
        ru: 'RU',
        sv: 'SV',
        uk: 'UK',
        zh: 'ZH',
      },
    };
  },
  methods: {
    changeLocale() {
      console.log(`Locale changed to: ${this.selectedLocale}`);
    },
  },
};
</script>

<style scoped>
</style>