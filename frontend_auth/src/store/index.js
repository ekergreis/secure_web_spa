import Vue from 'vue';
import Vuex from 'vuex';
// [OAUTH] Importation vuex-persistedstate pour enregistrement vuex dans LocalStorage
import createPersistedState from 'vuex-persistedstate';
// [OAUTH] Importation store auth
import auth from './auth';

Vue.use(Vuex);
/*
 * If not building with SSR mode, you can
 * directly export the Store instantiation
 */

export default function (/* { ssrContext } */) {
  const store = new Vuex.Store({
    // [OAUTH] Chargement store auth
    modules: {
      // example
      auth,
    },

    // enable strict mode (adds overhead!)
    // for dev mode only
    strict: process.env.DEV,

    // [OAUTH] plugin à appeler pour déclencher vuex-persistedstate
    plugins: [createPersistedState()],
  });
  return store;
}
