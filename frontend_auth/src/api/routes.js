// [OAUTH] Configuration des routes vers API

import {
  BASE_TOKEN,
  API_URL,
} from '../config/auth';


export default {
  // TOKEN_URL: `${BASE_TOKEN}oauth/token`,
  TOKEN_URL: `${BASE_TOKEN}login`,
  endpoints: {
    MENU_URL: `${API_URL}menu`,
    USERS_URL: `${API_URL}user`,
    // ressource_url : API_URL + "ressource"
  },
};
