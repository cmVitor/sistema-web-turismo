<template>
  <v-menu>
    <template #activator="{ props }">
      <v-avatar v-bind="props" class="mx-5">
        <v-img
          src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSppkoKsaYMuIoNLDH7O8ePOacLPG1mKXtEng&s"
        />
      </v-avatar>
    </template>

    <v-list>
      <v-list-item prepend-icon="mdi-account" to="/profile">Profile</v-list-item>
      <v-list-item prepend-icon="mdi-logout" @click="logout">Logout</v-list-item>
    </v-list>
  </v-menu>
</template>

<script lang="ts">
import { useAuthStore } from '@/stores/authStore';
import { defineComponent } from 'vue'

export default defineComponent({
  name: 'HeaderUserMenu',

  data(){
    return{
      authStore: useAuthStore(),
      router: useRouter()
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