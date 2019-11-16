import Vue from 'vue';
import axios from 'axios';

Vue.prototype.$axios = axios;

export default () => {
  const self = Vue.prototype;

  // [OAUTH] Fonctions interceptions reqûete et réponse Axios

  axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

  // [OAUTH] Ajout requête intercepteur
  axios.interceptors.request.use(
    (config) => {
      // [OAUTH] Recherche oauth token à passer à la requête
      config.headers.Authorization = self.$oauth.getAuthHeader();
      return config;
    },
    error => Promise.reject(error),
  );

  // [OAUTH] Ajout réponse intercepteur
  axios.interceptors.response.use(
    response => (response),
    (error) => {
      // [OAUTH] Traitement du résultat de la requête si pb auth redirection
      if (error.response && (error.response.status === 401 || error.response.status === 403)) {
        self.$oauth.logout();
        window.location.href = '/#/login';
      }
      return Promise.reject(error);
    },
  );
};
