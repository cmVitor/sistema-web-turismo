<template>
  <v-app-bar :elevation="4" color="primary">
    <!-- Ícone para abrir o drawer -->
    <v-app-bar-nav-icon @click="$emit('toggle-drawer')" />

    <v-toolbar-title class="text-truncate">Web Turismo</v-toolbar-title>

    <v-spacer />

    <!-- Itens do menu - visíveis apenas em telas médias e grandes -->
    <div class="d-none d-md-flex">
      <v-btn
        v-for="item in menuItems"
        :key="item.to"
        :to="item.to"
        text
        color="white"
      >
        {{ item.label }}
      </v-btn>
    </div>

    <!-- Menu suspenso para telas pequenas -->
    <v-menu class="d-md-none">
      <template #activator="{ props }">
        <v-btn icon v-bind="props" class="d-md-none">
          <v-icon color="white">mdi-dots-vertical</v-icon>
        </v-btn>
      </template>
      <v-list>
        <v-list-item
          v-for="item in menuItems"
          :key="item.to"
          :to="item.to"
          link
        >
          <v-list-item-title>{{ item.label }}</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-menu>

    <HeaderUserMenu />
  </v-app-bar>
</template>

<script lang="ts">
import { defineComponent } from 'vue'

import HeaderUserMenu from './HeaderUserMenu.vue'

export default defineComponent({
  name: 'HeaderAppBar',
  components: {
    HeaderUserMenu,
  },
  emits: ['toggle-drawer'],
  data() {
    return {
      menuItems: [
        { label: 'Dashboard', to: '/home' },
        { label: 'Mais Acessados', to: '/mais-acessados' },
        { label: 'Hospedagens', to: '/hospedagens' },
        { label: 'Favoritos', to: '/favoritos' },
      ] as { label: string; to: string }[],
    }
  },
})
</script>