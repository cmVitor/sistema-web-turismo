<template>
  <v-container fluid>

    <h1 class="text-h4 font-weight-bold mb-6">
      Meus Favoritos
    </h1>

    <!-- Loading -->
    <v-row v-if="loading">
      <v-col cols="12" class="text-center py-10">
        <v-progress-circular indeterminate size="50" />
      </v-col>
    </v-row>

    <!-- Sem favoritos -->
    <v-row v-else-if="pontosFavoritos.length === 0">
      <v-col cols="12" class="text-center text-grey">
        Você ainda não favoritou nenhum ponto turístico.
      </v-col>
    </v-row>

    <!-- Cards -->
    <v-row v-else>
      <v-col
        v-for="p in pontosFavoritos"
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
          :nota-media="p.nota_media"
          :foto-url="p.foto_url ?? '/placeholder.jpg'"
        />
      </v-col>
    </v-row>

  </v-container>
</template>

<script lang="ts">
import { defineComponent, computed, onMounted } from 'vue'
import { useFavoritosStore } from '@/stores/favoritosStore'
import { usePontosStore } from '@/stores/pontosStore'
import PontoCard from '@/components/Pontos/PontoCard.vue'

export default defineComponent({
  components: { PontoCard },

  setup() {
    const favoritosStore = useFavoritosStore()
    const pontosStore = usePontosStore()

    onMounted(async () => {
      await favoritosStore.carregarFavoritos()

      // Garante que os pontos estejam carregados
      if (pontosStore.pontos.length === 0) {
        await pontosStore.fetchPontos()
      }
    })

    const pontosFavoritos = computed(() =>
      pontosStore.pontos.filter(p =>
        favoritosStore.favoritos.includes(p.id)
      )
    )

    const loading = computed(() =>
      pontosStore.loading
    )

    return {
      pontosFavoritos,
      loading
    }
  }
})
</script>
