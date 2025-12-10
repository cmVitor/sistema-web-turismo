<template>
  <v-navigation-drawer v-model="isDrawerOpen">
    <v-list>
      <v-list-subheader>Gerenciamento</v-list-subheader>

      <v-list>
        <v-list-item v-if="auth.usuarioLogado" :prepend-avatar="defaultAvatar" :subtitle="auth.usuarioLogado.role"
          :title="auth.usuarioLogado.login" />
      </v-list>

      <v-divider />

      <v-list-item to="/home" prepend-icon="mdi-view-dashboard">Dashboard</v-list-item>
      <v-list-item to="/mais-acessados" prepend-icon="mdi-fire">Mais acessados</v-list-item>
      <v-list-item to="/hospedagens" prepend-icon="mdi-home-city">Hospedagens</v-list-item>
      <v-list-item to="/favoritos" prepend-icon="mdi-star">Favoritos</v-list-item>

      <v-divider />
      <div class="admin-list" v-if="authStore.userRole === 'ADMIN'">
        <v-list-subheader class="mt-5">Administração</v-list-subheader>
        <v-list-item to="/usuarios" prepend-icon="mdi-account">Usuários</v-list-item>
      </div>
    </v-list>
  </v-navigation-drawer>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { useAuthStore } from '@/stores/authStore'
import { useRouter } from 'vue-router';

export default defineComponent({
  name: 'HeaderDrawer',
  props: {
    modelValue: { type: Boolean, required: true },
  },
  emits: ['update:modelValue'],

  data() {
    return {
      auth: useAuthStore(),
      router: useRouter(),
      defaultAvatar:
        'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSppkoKsaYMuIoNLDH7O8ePOacLPG1mKXtEng&s',
    }
  },

  computed: {
    isDrawerOpen: {
      get(): boolean {
        return this.modelValue
      },
      set(value: boolean) {
        this.$emit('update:modelValue', value)
      },
    },
    usuario() {
      return this.auth.usuarioLogado
    },
    authStore(){
      return useAuthStore()
    }
  },

  mounted() {
    // Caso o usuário atualize a página, recarrega a sessão
    // this.auth.carregarSessao()

    // // Se não estiver logado, redireciona ao login
    // if (!this.auth.isAuthenticated) {
    //   this.router.push('/login')
    // }
  },
})
</script>