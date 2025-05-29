import { createI18n } from 'vue-i18n';

const messages = {
  en: {
    project_title: 'My Project Title',
    steam_admin_page: 'Steam Admin Page',
    steam_user_page: 'Steam User Page',
    back_home_tooltip: 'Back to Home',
    home: 'Home',
    preview_tooltip: 'Preview Steam Profile',
    steam: 'Steam',
    logout: 'Logout',
    login: 'Login',
    crud_user: 'Manage Users',
    crud_game: 'Manage Games',
    crud_gamestat: 'Manage Game Stats',
    crud_comment: 'Manage Comments',
  },
  fr: {
    project_title: 'Mon Titre de Projet',
    steam_admin_page: 'Page Admin Steam',
    steam_user_page: 'Page Utilisateur Steam',
    back_home_tooltip: 'Retour à l\'accueil',
    home: 'Accueil',
    preview_tooltip: 'Aperçu du profil Steam',
    steam: 'Steam',
    logout: 'Déconnexion',
    login: 'Connexion',
    crud_user: 'Gérer les utilisateurs',
    crud_game: 'Gérer les jeux',
    crud_gamestat: 'Gérer les stats de jeu',
    crud_comment: 'Gérer les commentaires',
  }
};

const i18n = createI18n({
  legacy: false,
  locale: 'fr',
  fallbackLocale: 'fr',
  messages,
});

export default i18n;