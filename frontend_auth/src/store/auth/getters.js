// [OAUTH] Création getter pour identifier présence token ou vérifier group

export function existAccessToken(state) {
  if (state.access_token !== '') return true;
  return false;
}

export function groupAuth(state) {
  if (state.group === 'admin') return true;
  return false;
}
