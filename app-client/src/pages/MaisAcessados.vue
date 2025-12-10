<template>
  <v-container>
    <h1 class="text-h4 font-weight-bold mb-6">Pontos mais acessados</h1>

    <v-row>
      <v-col v-for="ponto in store.pontos" :key="ponto.id" cols="12" md="4">
        <PontoCard
          :id="ponto.id"
          :nome="ponto.nome"
          :descricao="ponto.descricao"
          :cidade="ponto.cidade"
          :estado="ponto.estado"
          :pais="ponto.pais"
          :nota-media="ponto.nota_media"
        />
      </v-col>
    </v-row>
  </v-container>
</template>

<script lang="ts">
import { defineComponent, onMounted } from "vue";
import { usePontosStore } from "@/stores/pontosStore";
import PontoCard from "@/components/Pontos/PontoCard.vue";

export default defineComponent({
  components: { PontoCard },
  setup() {
    const store = usePontosStore();

    onMounted(() => {
      store.fetchMaisAcessados();
    });

    return { store };
  },
});
</script>
