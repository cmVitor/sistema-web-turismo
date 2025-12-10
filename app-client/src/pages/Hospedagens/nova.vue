<template>
  <v-container>

    <h1 class="text-h4 font-weight-bold mb-6">
      Cadastrar Hospedagem
    </h1>

    <v-form @submit.prevent="salvar">

      <v-text-field
        v-model="form.nome"
        label="Nome"
        required
      />

      <v-text-field
        v-model="form.endereco"
        label="Endereço"
        required
      />

      <v-text-field
        v-model="form.telefone"
        label="Telefone"
      />

      <v-text-field
        v-model.number="form.preco_medio"
        label="Preço médio"
        type="number"
        min="0"
      />

      <v-select
        v-model="form.tipo"
        :items="tipos"
        label="Tipo"
        required
      />

      <v-text-field
        v-model="form.link_reserva"
        label="Link para reserva"
        type="url"
      />

      <v-btn
        type="submit"
        color="primary"
        :loading="loading"
      >
        Salvar
      </v-btn>

      <v-btn
        variant="text"
        class="ml-2"
        @click="$router.back()"
      >
        Cancelar
      </v-btn>

    </v-form>

  </v-container>
</template>

<script lang="ts">
import { defineComponent, reactive, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import api from "@/services/api";

export default defineComponent({
  setup() {
    const route = useRoute()
    const router = useRouter()

    const pontoId = Number(route.params.id)
    const loading = ref(false)

    const tipos = ['hotel', 'pousada', 'hostel']

    const form = reactive({
      ponto_id: pontoId,
      nome: '',
      endereco: '',
      telefone: '',
      preco_medio: null as number | null,
      tipo: '',
      link_reserva: ''
    })

    const salvar = async () => {
      try {
        loading.value = true

        await api.post(
          'http://localhost:8000/api/hospedagens',
          form
        )

        router.push(`/pontos/${pontoId}`)
      } catch (error) {
        console.error('Erro ao cadastrar hospedagem:', error)
      } finally {
        loading.value = false
      }
    }

    return {
      form,
      tipos,
      salvar,
      loading
    }
  }
})
</script>
