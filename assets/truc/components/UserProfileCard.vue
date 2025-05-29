<template>
  <div class="user-profile-card">
    <img :src="avatarUrl" :alt="`Avatar of ${username}`" class="user-avatar" />
    <h1>{{ username }}</h1>
    <p>Email: {{ email }}</p>
  </div>
</template>

<script>
export default {
  props: {
    user: {
      type: Object,
      required: true
    }
  },
  computed: {
    avatarUrl() {
      return require(`@/assets/uploads/avatars/${this.user.avatar}`);
    },
    username() {
      return this.user.username;
    },
    email() {
      return this.user.email;
    }
  }
}
</script>

<style scoped>
</style>