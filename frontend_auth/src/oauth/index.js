// [OAUTH] Classe gestion OAuth

import AuthService from './service';
import ConfigAuth from '../config/auth';

class OAuth {
  constructor(store) {
    this.store = store;
  }

  logout() {
    this.store.commit('auth/setToken', '');
    this.store.commit('auth/setGroup', '');
  }

  isAuthenticated() {
    return this.store.getters['auth/existAccessToken'];
  }

  // [ROLE] Verification si "admin" pour route Vue.js
  isAdmin() {
    return this.store.getters['auth/groupAuth'];
  }

  // [OAUTH] Changement en (username, password) si route Passport Laravel active AuthServiceProvider
  login(username, password) {
    const data = {
      username,
      password,
    };
    // [OAUTH] Les objets data et les paramètres configués sont compactés (merge)
    Object.assign(data, ConfigAuth.oauth);
    return new Promise((resolve, reject) => {
      AuthService.attemptLogin(data).then((response) => {
        this.storeSession(response.data);
        this.addAuthHeaders();
        resolve(response);
      }).catch((error) => {
        reject(error);
      });
    });
  }

  getAPI(urlAPI) {
    if (this.isAuthenticated()) {
      return new Promise((resolve, reject) => {
        AuthService
          .requestAPI(urlAPI)
          .then((response) => {
            resolve(response);
          }).catch((error) => {
            reject(error);
          });
      });
    }
    return new Promise(resolve => resolve(null));
  }

  getAuthHeader() {
    if (this.store.getters['auth/existAccessToken']) {
      return `${ConfigAuth.oauth_type} ${this.store.state.auth.access_token}`; // [OAUTH] Exemple : Bearer xk8dfwv8783dxddjk232xjshoqpx
    }
    return null;
  }

  addAuthHeaders() {
    const header = this.getAuthHeader();
    AuthService.addAuthorizationHeader(header);
  }

  storeSession(data) {
    this.store.commit('auth/setToken', data.access_token);
    this.store.commit('auth/setGroup', data.group);
  }
}

export default OAuth;
