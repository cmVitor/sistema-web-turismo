<template>
  <v-container class="fill-height d-flex justify-center align-center">
    <v-card class="mt-15 pa-8 rounded-lg elevation-20" width="450">
      <h1 class="my-6 text-center">Bem vindo</h1>
      <div class="d-flex justify-center mb-15">
        <v-icon size="64">mdi-human-greeting</v-icon>
      </div>
      <v-card-title class="text-h6 text-center">Login</v-card-title>

      <v-form ref="formRef" v-model="valid" lazy-validation>
        <v-text-field
          label="E-mail"
          v-model="credentials.email"
          :rules="[rules.required, rules.email]"
          prepend-inner-icon="mdi-email"
          type="email"
          required
          variant="outlined"
          rounded
        />

        <v-text-field
          label="Senha"
          v-model="credentials.password"
          :rules="[rules.required]"
          prepend-inner-icon="mdi-lock"
          type="password"
          required
          variant="outlined"
          rounded
        />

        <v-btn color="primary" block class="mt-4" @click="login">
          Entrar
        </v-btn>
      </v-form>

      <v-alert v-if="erro" type="error" class="mt-4" dense>
        {{ erro }}
      </v-alert>
    </v-card>
  </v-container>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/authStore'
import type { ICredentials } from '@/Interfaces/Login/ICredentials'

export default defineComponent({
  name: 'LoginForm',

  created(){
    this.router = useRouter()
  },

  data() {
    return {
      valid: false as boolean,
      erro: '' as string,
      credentials: {
        email: '',
        password: '',
      } as ICredentials,
      rules: {
        required: (v: any) => !!v || 'Campo obrigatório',
        email: (v: string) => /.+@.+\..+/.test(v) || 'E-mail inválido',
      },
      authStore: useAuthStore(),
      router: null as any
    }
  },

  methods: {
    async login() {
      const formRef = this.$refs.formRef as any
      if (formRef && typeof formRef.validate === 'function' && !formRef.validate()) {
        return
      }

      try {
        await this.authStore.login(this.credentials)
        this.erro = ''
        this.router.push('/home')
      } catch (err){
        this.erro = this.authStore.erro || err.message || 'Erro desconhecido'
      }
    },
  },
})
</script>
