<template>
  <q-layout view="lHh Lpr lFf">

    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          @click="leftDrawerOpen = !leftDrawerOpen"
          icon="menu"
          aria-label="Menu"
        />

        <q-toolbar-title>
          Authentification OAuth et Roles
        </q-toolbar-title>

        <div>Quasar v{{ $q.version }}</div>
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      bordered
      content-class="bg-grey-2"
    >
      <q-list>
        <q-item-label header>Utilisateur {{ this.user }}</q-item-label>

        <q-item clickable tag="a" to="/">
          <q-item-section avatar>
            <q-icon name="first_page" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Accueil</q-item-label>
            <q-item-label caption></q-item-label>
          </q-item-section>
        </q-item>

        <q-item v-for="(item, index) in detMenu" :key="index" tag="a" :to="item.to">
          <q-item-section avatar>
            <q-icon :name="item.icon" />
          </q-item-section>
          <q-item-section>
            <q-item-label>{{ item.label }}</q-item-label>
            <q-item-label caption>{{ item.souslabel }}</q-item-label>
          </q-item-section>
        </q-item>

        <q-item clickable @click="logout">
          <q-item-section avatar>
            <q-icon name="exit_to_app" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Déconnexion</q-item-label>
          </q-item-section>
        </q-item>

      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import { Notify } from 'quasar';
import API from '../api/routes';

export default {
  name: 'MyLayout',

  data() {
    return {
      leftDrawerOpen: false,
      APIRoutes: API,
      user: '',
      detMenu: '',
    };
  },
  mounted() {
    (async () => {
      const response = await this.$oauth.getAPI(API.endpoints.MENU_URL);
      this.user = response.data.user;
      if (this.user === '') this.logout();

      this.detMenu = response.data.menu;
    })();
  },
  methods: {
    logout() {
      const timeout = 1500;
      Notify.create({
        message: 'Déconnexion en cours ...',
        icon: 'alarm_add',
        timeout,
      });
      setTimeout(() => {
        // [OAUTH] Déconnexion
        this.$oauth.logout();
        // [OAUTH] Redirection vers route Login
        this.$router.replace('/login');
      }, timeout);
    },
  },
};
</script>
