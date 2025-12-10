<template>
  <v-container>

    <h1 class="text-h4 font-weight-bold mb-6">
      Hospedagens
    </h1>

    <!-- LOADING -->
    <v-row v-if="store.loading">
      <v-col cols="12" class="text-center py-10">
        <v-progress-circular indeterminate size="50" />
      </v-col>
    </v-row>

    <!-- LISTA -->
    <v-row v-else>
      <v-col
        v-for="h in store.hospedagens"
        :key="h.id"
        cols="12"
        md="4"
      >
        <v-card class="pa-4 h-100" variant="outlined">

          <h3 class="text-h6 font-weight-bold">
            {{ h.nome }}
          </h3>

          <p class="text-grey">{{ h.endereco }}</p>

          <p><strong>Tipo:</strong> {{ h.tipo }}</p>

          <p v-if="h.preco_medio">
            <strong>Preço médio:</strong> R$ {{ h.preco_medio }}
          </p>

          <v-spacer />

          <v-btn
            v-if="h.link_reserva"
            :href="h.link_reserva"
            target="_blank"
            variant="text"
            color="primary"
          >
            Reservar
          </v-btn>

          <v-btn
            variant="text"
            color="secondary"
            @click="$router.push(`/pontos/${h.ponto_id}`)"
          >
            Ver ponto turístico
          </v-btn>

        </v-card>
      </v-col>
    </v-row>

    <!-- PAGINAÇÃO -->
    <v-row v-if="store.lastPage > 1" class="mt-6">
      <v-col cols="12" class="d-flex justify-center">
        <v-pagination
          v-model="page"
          :length="store.lastPage"
          @update:model-value="changePage"
        />
      </v-col>
    </v-row>

  </v-container>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from 'vue'
import { useHospedagensStore } from '@/stores/hospedagensStore'

export default defineComponent({
  setup() {
    const store = useHospedagensStore()
    const page = ref(1)

    const changePage = (p: number) => {
      store.fetchHospedagens(p)
    }

    onMounted(() => {
      store.fetchHospedagens()
    })

    return { store, page, changePage }
  }
})
</script>
