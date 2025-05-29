<template>
  <div class="game-card">
    <img :src="game.image" :alt="game.title" class="game-image" />
    <h3>{{ game.title }}</h3>
    <p>Developer: {{ game.developer }}</p>
    <p>Release Date: {{ formatDate(game.releaseDate) }}</p>
    <p>Hours Played: {{ game.hoursPlayed }}</p>
    <p>Last Played: {{ formatDate(game.lastPlayed) }}</p>
  </div>
</template>

<script>
export default {
  name: 'GameCard',
  props: {
    game: {
      type: Object,
      required: true
    }
  },
  methods: {
    formatDate(date) {
      return new Date(date).toLocaleDateString('en-US');
    }
  }
}
</script>

<style scoped>
</style>