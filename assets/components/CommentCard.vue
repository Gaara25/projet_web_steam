<template>
  <div class="comment-card">
    <p>{{ comment.content }}</p>
    <small>{{ 'created_at' | translate }}: {{ formatDate(comment.createdAt) }}</small>
  </div>
</template>

<script>
export default {
  props: {
    comment: {
      type: Object,
      required: true
    }
  },
  methods: {
    formatDate(date) {
      return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit'
      });
    }
  }
}
</script>

<style scoped>
</style>