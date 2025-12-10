<template>
  <v-card
    elevation="4"
    class="pa-2 mx-4"
    width="400"
    height="400"
    @click="abrirDetalhes"
  >
    <v-img src="@/assets/placeholder.jpg" height="140" cover />

    <!-- Ícone de favorito -->
    <v-btn
      icon
      class="position-absolute top-0 right-0 ma-2"
      @click.stop="toggleFavorito"
    >
      <v-icon :color="isFavorito ? 'red' : 'grey'">
        {{ isFavorito ? "mdi-heart" : "mdi-heart-outline" }}
      </v-icon>
    </v-btn>

    <v-card-title class="text-h6">
      {{ nome }}
    </v-card-title>

    <v-card-text>
      <div class="text-body-2 text-grey">
        {{ descricao }}
      </div>

      <div class="mt-1"><strong>Cidade:</strong> {{ cidade }}</div>

      <div class="mt-1"><strong>Estado:</strong> {{ estado }}</div>

      <div class="mt-1"><strong>País:</strong> {{ pais }}</div>

      <div class="mt-1">
        <strong>Nota Média:</strong>
        {{ notaMedia === 0 ? "Sem avaliações" : notaMedia }}
      </div>
    </v-card-text>

    <v-card-actions>
      <v-btn variant="text" color="primary">Ver tudo</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import { useRouter } from "vue-router";
import { useFavoritosStore } from "@/stores/favoritosStore";

export default defineComponent({
  name: "PontoCard",

  props: {
    id: { type: Number, required: true },
    nome: { type: String, required: true },
    descricao: { type: String, required: true },
    cidade: { type: String, required: true },
    estado: { type: String, required: true },
    pais: { type: String, required: true },
    notaMedia: { type: Number, required: false },
    fotoUrl: { type: String, required: false },
  },

  setup(props) {
    const router = useRouter();
    const favoritosStore = useFavoritosStore();

    const abrirDetalhes = () => {
      router.push(`/pontos/${props.id}`);
    };

    const isFavorito = computed(() => favoritosStore.isFavorito(props.id));

    const toggleFavorito = async () => {
      try {
        await favoritosStore.toggleFavorito(props.id);
      } catch (error) {
        console.error("Erro ao alternar favorito:", error);
      }
    };

    return {
      abrirDetalhes,
      isFavorito,
      toggleFavorito,
    };
  },
});
</script>

<style scoped>
.v-card {
  cursor: pointer;
  transition: 0.2s ease;
}

.v-card:hover {
  transform: translateY(-4px);
}

.position-absolute {
  position: absolute;
}
</style>
