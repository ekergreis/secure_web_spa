<template>
  <div class="login-view layout-padding">
     <q-card class="bg-white card" inline>

      <q-card-section>
        <div class="text-h3">Connexion</div>
        <div class="text-subtitle2"></div>
      </q-card-section>

      <q-separator inset />

      <q-card-section>
            <form @submit.prevent="authenticate">
              <div class="q-gutter-y-md">
                <q-input outlined v-model="form.username"
                        label="Utilisateur" />

                <q-input outlined v-model="form.password" type="password"
                        label="Mot de passe" />
                <q-btn type="submit" class="bg-primary text-white">Login</q-btn>
              </div>
            </form>
      </q-card-section>

    </q-card>
  </div>
</template>

<script>
import { Notify } from 'quasar';

export default
{
  data() {
    return {
      form: {
        username: '',
        password: '',
      },
    };
  },
  methods: {
    loginError() {
      Notify.create({
        message: 'Utilisateur ou mot de passe incorrect',
        icon: 'lock',
        timeout: 2500,
      });
    },
    async authenticate() {
      try {
        // [OAUTH] Authentification avec user et mot de passe
        await this.$oauth.login(this.form.username, this.form.password);
        // [OAUTH] Succès Authentification
        this.$router.replace('/');
      } catch (error) {
        // [OAUTH] Erreur Authentification
        this.loginError();
      }
    },
  },
};
</script>

<style lang="scss">
.login-view{
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100vh;
  background-color: #898989;
  .card{
    padding: 24px;
    min-width: 300px;
  }
  form{
    max-width: 500px;
  }
}
</style>
