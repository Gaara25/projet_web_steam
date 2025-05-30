<template>
  <div class="add-comment">
    <h2>{{ $t('add_comment') }}</h2>
    <form @submit.prevent="submitComment">
      <textarea v-model="commentContent" placeholder="{{ $t('write_comment') }}" required></textarea>
      <button type="submit">{{ $t('submit') }}</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      commentContent: ''
    };
  },
  methods: {
    submitComment() {
      // Emit the comment content to the parent component
      this.$emit('comment-added', this.commentContent);
      this.commentContent = ''; // Clear the textarea after submission
    }
  }
};
</script>

<style scoped>
</style>