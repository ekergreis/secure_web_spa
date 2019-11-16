// [OAUTH] Gestion axios OAuth

import Http from 'axios';
import API from '../api/routes'; // [OAUTH] Appel fichier config des urls

export default {
  async requestAPI(urlAPI) {
    try {
      const result = await Http.get(urlAPI);
      return new Promise(resolve => resolve(result));
    } catch (error) {
      return new Promise(reject => reject(error));
    }
  },
  async attemptLogin(credentials) {
    try {
      const response = await Http.post(API.TOKEN_URL, credentials);
      return new Promise(resolve => resolve(response));
    } catch (error) {
      return new Promise(reject => reject(error));
    }
  },
  addAuthorizationHeader(header) {
    Http.defaults.headers.common.Authorization = header;
  },
};
