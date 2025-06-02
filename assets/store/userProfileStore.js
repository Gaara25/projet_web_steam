// filepath: c:\Users\axelj\Documents\Informatique\License\L2\web\projet_web_steam\assets\stores\userProfileStore.js
// ...

// Example: exporting the actions object for use in a store or component
export const actions = {
  async fetchUsers() {
    console.log('Attempting to fetch users...');
    this.isLoading = true;
    this.error = null;
    try {
      const response = await axios.get('/api/users'); 
      console.log('Users fetched:', response.data);
      this.users = response.data;
    } catch (error) {
      console.error('Error fetching users:', error);
      this.error = 'Failed to load users.';
    } finally {
      console.log('fetchUsers finished, isLoading set to false.');
      this.isLoading = false;
    }
  },
  async fetchUserProfile(userId) {
    if (!userId) {
      console.log('fetchUserProfile called with no userId, clearing current user.');
      this.currentUser = null;
      return;
    }
    console.log(`Attempting to fetch user profile for ID: ${userId}`);
    this.isLoading = true;
    this.error = null;
    this.currentUser = null;
    try {
      const response = await axios.get(`/api/users/${userId}`);
      console.log('User profile fetched:', response.data);
      this.currentUser = response.data;
    } catch (error) {
      console.error(`Error fetching user profile for ID ${userId}:`, error);
      this.error = 'Failed to load user profile.';
      if (error.response && error.response.status === 404) {
        this.error = 'User not found.';
      }
    } finally {
      console.log(`fetchUserProfile for ID ${userId} finished, isLoading set to false.`);
      this.isLoading = false;
    }
  },
  // ... addComment action
};

// ...