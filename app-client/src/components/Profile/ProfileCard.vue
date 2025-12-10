<template>
    <v-container class="py-10 d-flex justify-center">
        <v-card class="pa-8 rounded-lg elevation-12" width="500">
            <div class="text-center mb-6">
                <v-avatar size="96" color="primary" class="mb-4">
                    <v-icon size="48" color="white">mdi-account</v-icon>
                </v-avatar>
                <h2 class="text-h5 mb-1">{{ usuario.login }}</h2>
                <p class="text-subtitle-2 text-grey">{{ usuario.role }}</p>
            </div>

            <v-divider class="my-4"></v-divider>

            <v-list lines="one">
                <v-list-item prepend-icon="mdi-email">
                    <v-list-item-title>{{ usuario.email }}</v-list-item-title>
                    <v-list-item-subtitle>E-mail</v-list-item-subtitle>
                </v-list-item>
            </v-list>

            <v-divider class="my-4"></v-divider>

            <v-btn color="primary" block rounded="lg" @click="logout">
                <v-icon left>mdi-logout</v-icon>
                Sair
            </v-btn>
        </v-card>
    </v-container>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { useAuthStore } from '@/stores/authStore'
import { useRouter } from 'vue-router'

export default defineComponent({
    name: 'ProfileCard',

    data() {
    return {
      authStore: useAuthStore(),
      router: useRouter(),
    }
  },

  computed: {
    usuario() {
      return this.authStore.usuarioLogado
    },
  },

  mounted() {
    // Caso o usuário atualize a página, recarrega a sessão
    this.authStore.carregarSessao()

    // Se não estiver logado, redireciona ao login
    if (!this.authStore.isAuthenticated) {
      this.router.push('/login')
    }
  },

  methods: {
    logout() {
      this.authStore.logout()
      this.router.push('/login')
    },
  },
})
</script>