<template>
  <v-container fluid>
    <!-- Títulos -->
    <h1 class="text-h4 font-weight-bold mb-4">Pontos Turísticos</h1>

    <!-- FILTROS -->
    <v-row class="mb-4">
      <v-col cols="12" sm="4">
        <v-text-field
          label="Nome"
          v-model="store.filtros.nome"
          @update:model-value="buscar"
          clearable
          variant="outlined"
          rounded
        />
      </v-col>

      <v-col cols="12" sm="4">
        <v-text-field
          label="Cidade"
          v-model="store.filtros.cidade"
          @update:model-value="buscar"
          clearable
          variant="outlined"
          rounded
        />
      </v-col>

      <v-col cols="12" sm="4">
        <v-text-field
          label="Nota mínima"
          type="number"
          v-model="store.filtros.nota"
          @update:model-value="buscar"
          clearable
          variant="outlined"
          rounded
        />
      </v-col>
    </v-row>

    <v-row class="mb-4" v-if="auth.userRole === 'ADMIN'">
      <v-col cols="12" class="text-center">
        <v-btn
          color="primary"
          prepend-icon="mdi-plus"
          @click="$router.push('/pontos/novo')"
        >
          Novo Ponto Turístico
        </v-btn>
      </v-col>
    </v-row>

    <!-- GRID DE CARDS -->
    <v-row>
      <template v-if="store.loading">
        <v-col cols="12" class="text-center py-10">
          <v-progress-circular indeterminate size="50" />
        </v-col>
      </template>

      <template v-else>
        <v-col
          v-for="p in store.pontos"
          :key="p.id"
          cols="12"
          sm="6"
          md="4"
          lg="3"
        >
          <PontoCard
            :id="p.id"
            :nome="p.nome"
            :descricao="p.descricao"
            :cidade="p.cidade"
            :estado="p.estado"
            :pais="p.pais"
            :nota-media="p.nota_media"
            :foto-url="p.foto_url ?? '/placeholder.jpg'"
          />
        </v-col>
      </template>
    </v-row>
  </v-container>
</template>

<script lang="ts">
import { defineComponent, onMounted } from "vue";
import { usePontosStore } from "@/stores/pontosStore";
import PontoCard from "@/components/Pontos/PontoCard.vue";
import { useAuthStore } from '@/stores/authStore'

export default defineComponent({
  components: { PontoCard },

  setup() {
    const store = usePontosStore();
    const auth = useAuthStore();

    const buscar = () => {
      store.fetchPontos();
    };

    onMounted(() => {
      store.fetchPontos();
    });

    return { store, buscar, auth };
  },
});
</script>
