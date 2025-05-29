<template>
  <header>
    <h1 v-if="isAdmin">{{ $t('steam_admin_page') }}</h1>
    <h1 v-else>{{ $t('steam_user_page') }}</h1>
    <nav>
      <ul>
        <li><router-link :to="{ name: 'home' }" class="tooltipped" :title="$t('back_home_tooltip')">{{ $t('home') }}</router-link></li>
        <li><router-link :to="{ name: 'profile' }" class="tooltipped" :title="$t('preview_tooltip')">{{ $t('steam') }}</router-link></li>
        <li v-if="user"><router-link :to="{ name: 'logout' }" class="btn right">{{ $t('logout') }}</router-link></li>
        <li v-else><router-link :to="{ name: 'login' }" class="btn right">{{ $t('login') }}</router-link></li>
      </ul>
      <ul v-if="isAdmin">
        <li><router-link :to="{ name: 'userIndex' }">{{ $t('crud_user') }}</router-link></li>
        <li><router-link :to="{ name: 'gameIndex' }">{{ $t('crud_game') }}</router-link></li>
        <li><router-link :to="{ name: 'gameStatIndex' }">{{ $t('crud_gamestat') }}</router-link></li>
        <li><router-link :to="{ name: 'commentIndex' }">{{ $t('crud_comment') }}</router-link></li>
      </ul>
    </nav>
  </header>
</template>

<script>
export default {
  computed: {
    isAdmin() {
      return this.$store.state.user && this.$store.state.user.role === 'USER_ADMIN';
    },
    user() {
      return this.$store.state.user;
    }
  }
}
</script>

<style scoped>
</style>