<template>
  <v-container class="d-flex align-center justify-center fill-height">
    <v-card elevation="12" width="750" class="pa-6 card-form mt-10">
      <v-card-title class="text-h4 font-weight-bold text-center mb-1">
        Cadastro de Ponto Turístico
      </v-card-title>
      <v-card-subtitle class="text-h6 text-center mb-6">
        Preencha os dados abaixo:
      </v-card-subtitle>

      <v-form ref="form" @submit.prevent="submit">
        <v-text-field
          v-model="formData.nome"
          label="Nome"
          variant="outlined"
          rounded
          required
        />

        <v-textarea
          v-model="formData.descricao"
          label="Descrição"
          variant="outlined"
          rounded
          required
        />

        <v-text-field
          v-model="formData.cidade"
          label="Cidade"
          variant="outlined"
          rounded
          required
        />

        <v-text-field
          v-model="formData.estado"
          label="Estado"
          variant="outlined"
          rounded
          required
        />

        <v-text-field
          v-model="formData.pais"
          label="País"
          variant="outlined"
          rounded
          required
        />

        <v-text-field
          v-model.number="formData.latitude"
          label="Latitude"
          type="number"
          variant="outlined"
          rounded
        />

        <v-text-field
          v-model.number="formData.longitude"
          label="Longitude"
          type="number"
          variant="outlined"
          rounded
        />

        <v-text-field
          v-model="formData.endereco"
          label="Endereço"
          variant="outlined"
          rounded
          required
        />

        <v-btn color="primary" class="mt-4" type="submit" :loading="loading">
          Salvar Ponto
        </v-btn>
      </v-form>
    </v-card>
  </v-container>
</template>

<script lang="ts" setup>
import { ref } from "vue";
import { usePontosStore } from "@/stores/pontosStore";
import type { IPontoCreate } from "@/stores/pontosStore";
import { useRouter } from 'vue-router';
const router = useRouter();

const store = usePontosStore();
const loading = store.loading;

const form = ref();

const formData = ref<IPontoCreate>({
  nome: "",
  descricao: "",
  cidade: "",
  estado: "",
  pais: "",
  latitude: null,
  longitude: null,
  endereco: "",
});

const submit = async () => {
  await store.createPonto(formData.value);
  
  // limpa após salvar
  formData.value = {
    nome: "",
    descricao: "",
    cidade: "",
    estado: "",
    pais: "",
    latitude: null,
    longitude: null,
    endereco: "",
  };

  router.push('/home');
};
</script>
