<template>
  <q-page class="flex flex-center">
    <q-card>
        <q-card-section>
          <div class="text-h2">Informations requête utilisateur</div>
        </q-card-section>
        <q-card-section>
          {{ this.infosCompUser}}
        </q-card-section>

         <q-card-section>
          <button @click="getAPI(APIRoutes.endpoints.USERS_URL)">
              Rappel API pour affichage dans Dialog
          </button>
        </q-card-section>
      </q-card>

      <q-dialog v-model="msgInfosComp">
        <q-card>
          <q-card-section>
            <div class="text-h6">Informations requête utilisateur</div>
          </q-card-section>

          <q-card-section>
            {{ this.infosCompUser}}
          </q-card-section>

          <q-card-actions align="right">
            <q-btn flat label="OK" color="primary" v-close-popup />
          </q-card-actions>
      </q-card>
    </q-dialog>
  </q-page>
</template>

<script>
import API from '../api/routes';

export default {
  name: 'User',
  data() {
    return {
      APIRoutes: API,
      infosCompUser: '',
      msgInfosComp: false,
    };
  },
  // A l'affichage de la page chargement appel API Laravel infos utilisateurs
  mounted() {
    (async () => {
      const resultReq = await this.$oauth.getAPI(this.APIRoutes.endpoints.USERS_URL);
      this.infosCompUser = resultReq.data;
    })();
  },
  methods: {
    // Pour tests appel fonction chargement infos utilisateurs dans dialog
    async getAPI(cheminAPI) {
      const resultReq = await this.$oauth.getAPI(cheminAPI);
      this.infosCompUser = resultReq.data;
      this.msgInfosComp = true;
    },
  },
};
</script>
