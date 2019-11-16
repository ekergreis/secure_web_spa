// [OAUTH] Configuration url et param authentification

export const STATUS = 'local';

// [OAUTH] Prendre id/clé dans table oauth_clients avec "password_client" = 1
const secrets = {
  API_LOCAL: {
    id: 3,
    cle: 'Alm3kOnR4NAO4RrnbEAyZ9bCyAg3D3kXyY16cMTn',
  },
  API_DEV: {
    id: 2,
    cle: 'mysecretindev',
  },
  API_PRODUCTION: {
    id: 1,
    cle: 'mysecretinproduction',
  },
};

export const BASE_URL = {
  local: 'http://www.laravel_auth.local/api/',
  dev: 'http://www.laravel_auth.dev/api/',
  production: 'http://www.laravel_auth.com/api/',
};

export const API_URL = `${BASE_URL[STATUS]}`;
export const BASE_TOKEN = BASE_URL[STATUS];

function getSecret(value = '') {
  return `API_${value.toUpperCase()}`;
}

const secret = getSecret(STATUS);
const CLIENT_ID = secrets[secret].id;
const CLIENT_SECRET = secrets[secret].cle;


export default {
  oauth: {
    grant_type: 'password',
    client_id: CLIENT_ID,
    client_secret: CLIENT_SECRET,
    scope: '*',
  },
  oauth_type: 'Bearer',
};
