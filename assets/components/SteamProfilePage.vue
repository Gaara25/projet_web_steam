// filepath: c:\Users\axelj\Documents\Informatique\License\L2\web\projet_web_steam\assets\SteamProfilePage.vue
<template>
  <div class="steam-profile-vue">
    <!-- User Selector -->
    <div v-if="userStore.users.length > 0" class="user-selector section">
      <label for="user-select">Select User:</label>
      <select id="user-select" v-model="selectedUserId" @change="navigateToUser">
        <option v-for="user in userStore.users" :key="user.id" :value="user.id">
          {{ user.username }}
        </option>
      </select>
    </div>

    <div v-if="userStore.isLoading" class="loading">Loading...</div>
    <div v-if="userStore.error" class="error-message">{{ userStore.error }}</div>

    <div v-if="userStore.currentUser && !userStore.isLoading">
      <!-- User Profile Section -->
      <UserProfileCard :user="userStore.currentUser" />

      <!-- Games Section -->
      <div class="user-games section">
        <h2>Games</h2>
        <div v-if="userStore.currentUser.gameStats && userStore.currentUser.gameStats.length > 0" class="games-list">
          <GameCard v-for="gameStat in userStore.currentUser.gameStats" :key="gameStat.game.id" :gameStat="gameStat" />
        </div>
        <p v-else>No games found for this user.</p>
      </div>

      <!-- Comments Section -->
      <div class="user-comments section">
        <h2>Comments</h2>
        <div v-if="userStore.currentUser.comments && userStore.currentUser.comments.length > 0" class="comments-list">
          <CommentCard v-for="comment in userStore.currentUser.comments" :key="comment.id" :comment="comment" />
        </div>
        <p v-else>No comments found for this user.</p>
      </div>

      <!-- Add Comment Section -->
      <div class="user-add-comments section">
        <h2>Add Comment</h2>
        <AddCommentForm :user-id="userStore.currentUser.id" @comment-submitted="handleCommentSubmitted" />
      </div>
    </div>
    <div v-else-if="!userStore.isLoading && !userStore.error">
      <p>Select a user to see their profile.</p>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useUserProfileStore } from '../store/userProfileStore';

import UserProfileCard from './UserProfileCard.vue';
import GameCard from './GameCard.vue';
import CommentCard from './CommentCard.vue';
import AddCommentForm from './AddCommentForm.vue';

const props = defineProps({
  id: {
    type: [String, Number],
    required: false, // Becomes required due to redirect, or handle no ID case
  },
});

const userStore = useUserProfileStore();
const route = useRoute();
const router = useRouter();

const selectedUserId = ref(null);

const loadProfileData = (userId) => {
  if (userId) {
    userStore.fetchUserProfile(userId);
    selectedUserId.value = parseInt(userId);
  }
};

onMounted(() => {
  userStore.fetchUsers(); // Load all users for the selector
  if (props.id) {
    loadProfileData(props.id);
  } else if (route.params.id) { // Fallback if props not immediately available, though props:true should work
    loadProfileData(route.params.id);
  }
});

// Watch for changes in route parameter 'id'
watch(() => route.params.id, (newId) => {
  if (newId) {
    loadProfileData(newId);
  } else {
    userStore.currentUser = null; // Clear user if no ID
  }
});

// Watch for changes in the prop 'id' (if using props:true effectively)
 watch(() => props.id, (newId) => {
  if (newId) {
    loadProfileData(newId);
  }
});


const navigateToUser = () => {
  if (selectedUserId.value) {
    router.push({ name: 'SteamProfile', params: { id: selectedUserId.value } });
  }
};

const handleCommentSubmitted = async () => {
  // Optionally re-fetch user data to show the new comment immediately
  // or the store action can update the currentUser.comments array
  if (userStore.currentUser) {
    await userStore.fetchUserProfile(userStore.currentUser.id); // Re-fetch to get updated comments
  }
};
</script>

<style scoped>
.steam-profile-vue {
  font-family: Arial, sans-serif;
  max-width: 900px;
  margin: 0 auto;
  padding: 20px;
}
.section {
  margin-bottom: 30px;
  padding: 15px;
  border: 1px solid #ddd;
  border-radius: 5px;
  background-color: #f9f9f9;
}
.user-selector {
  margin-bottom: 20px;
}
.user-selector label {
  margin-right: 10px;
}
.loading {
  text-align: center;
  padding: 20px;
  font-size: 1.2em;
}
.error-message {
  color: red;
  text-align: center;
  padding: 10px;
  border: 1px solid red;
  border-radius: 4px;
  margin-bottom: 20px;
}
.games-list, .comments-list {
  display: flex;
  flex-direction: column;
  gap: 15px;
}
/* Basic styling for cards - you'll have more in your components */
.user-profile-card, .game-card, .comment-card, .add-comment-form {
  border: 1px solid #ccc;
  padding: 10px;
  border-radius: 4px;
}
h2 {
  border-bottom: 2px solid #eee;
  padding-bottom: 10px;
  margin-bottom: 15px;
}
</style>