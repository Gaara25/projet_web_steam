<template>
  <div class="user-profile-card">
    <img :src="avatarUrl" :alt="`Avatar of ${user.username}`" class="user-avatar" />
    <h1>{{ user.username }}</h1>
    <p>Email: {{ user.email }}</p>
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
      if (this.user && this.user.avatar) {
        return `/uploads/avatars/${this.user.avatar}`;
      }
      return '/path/to/default-avatar.png';
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
.user-avatar {
  max-width: 100px;
  max-height: 100px;
  border-radius: 50%;
}

</style>