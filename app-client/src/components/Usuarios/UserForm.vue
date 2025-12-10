<template>
  <v-container class="d-flex align-center justify-center fill-height">
    <v-card elevation="12" width="750" class="pa-6 card-form mt-10">
      <v-card-title class="text-h4 font-weight-bold text-center mb-1">
        Cadastro de Usuário
      </v-card-title>
      <v-card-subtitle class="text-h6 text-center mb-6">
        Preencha os dados abaixo:
      </v-card-subtitle>

      <v-form ref="form" v-model="valid" lazy-validation>
        <v-row dense class="d-flex justify-center">
          <v-col cols="12" sm="6">
            <v-text-field v-model="user.login" label="Login" prepend-inner-icon="mdi-account" variant="outlined"
              color="primary" rounded :rules="[v => !!v || 'O login é obrigatório']" required />
          </v-col>

          <v-col cols="12" sm="6">
            <v-select v-model="user.role" :items="['ADMIN', 'USER']" label="Cargo"
              prepend-inner-icon="mdi-briefcase" variant="outlined" color="primary" rounded
              :rules="[v => !!v || 'Selecione um cargo']" required />
          </v-col>

          <v-col cols="12">
            <v-text-field v-model="user.email" label="E-mail" prepend-inner-icon="mdi-email" variant="outlined"
              color="primary" rounded :rules="[
                v => !!v || 'O e-mail é obrigatório',
                v => /.+@.+\..+/.test(v) || 'E-mail inválido'
              ]" required />
          </v-col>

          <v-col cols="12">
            <v-text-field v-model="user.password" label="Senha" prepend-inner-icon="mdi-lock" type="password"
              variant="outlined" color="primary" rounded :rules="[v => !!v || 'A senha é obrigatória']" required />
          </v-col>
        </v-row>

        <v-btn class="mt-6 gradient-btn" block size="large" @click="salvarUsuario">
          <v-icon start>mdi-content-save</v-icon>
          Salvar Cadastro
        </v-btn>
      </v-form>
    </v-card>
  </v-container>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { useUserStore } from '@/stores/userStore'
import type { IUsuario } from '@/Interfaces/User/IUsuario'

export default defineComponent({
  name: 'UserForm',

  data() {
    return {
      valid: false,
      router: useRouter(),
      userStore: useUserStore(),
      user: {
        login: '',
        email: '',
        password: '',
        role: ''

      } as IUsuario,
    }
  },

  methods: {
    async salvarUsuario(e: Event) {
      e.preventDefault()
      const form = this.$refs.form as any
      const { valid } = await form.validate()
      if (!valid) {
        alert('Preencha os campos corretamente')
        return
      }

      try {
        await this.userStore.salvarUsuario(this.user)
        alert('Usuário cadastrado com sucesso!')
        this.resetForm()
        this.router.push('/home')
      } catch {
        alert('Erro ao salvar usuário.')
      }
    },

    resetForm() {
      this.user = {
        login: '',
        email: '',
        password: '',
        role: ''
      }
      const form = this.$refs.form as any
      form?.resetValidation?.()
    },
  },
})
</script>


<style scoped>
.card-form {
  border-radius: 20px;
}

.gradient-btn {
  background: linear-gradient(45deg, rgb(8, 54, 194), #6e70e0);
  color: white !important;
  font-weight: 600;
  border-radius: 12px;
  transition: all 0.3s ease;
}

.gradient-btn:hover {
  background: linear-gradient(45deg, #1d1085, #2e45c5);
  transform: scale(1.02);
}
</style>
