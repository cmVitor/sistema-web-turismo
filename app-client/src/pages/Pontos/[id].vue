<template>
  <v-container>
    <!-- LOADING -->
    <v-row v-if="loading">
      <v-col cols="12" class="text-center py-10">
        <v-progress-circular indeterminate size="60" />
      </v-col>
    </v-row>

    <template v-else>
      <!-- DADOS PRINCIPAIS -->
      <v-row>
        <v-col cols="12" md="6">
          <v-img
            src="@/assets/placeholder.jpg"
            height="300"
            cover
            class="rounded"
          />
        </v-col>

        <v-col cols="12" md="6">
          <h1 class="text-h4 font-weight-bold">{{ ponto.nome }}</h1>

          <p class="mt-2 text-grey">
            {{ ponto.descricao }}
          </p>

          <p>
            <strong>Cidade:</strong> {{ ponto.cidade }} - {{ ponto.estado }}
          </p>
          <p><strong>País:</strong> {{ ponto.pais }}</p>
          <p><strong>Endereço:</strong> {{ ponto.endereco }}</p>

          <v-rating
            v-model="ponto.nota_media"
            readonly
            half-increments
            color="amber"
            size="28"
          />
          <div class="text-subtitle-2 text-grey mt-1">
            {{
              ponto.nota_media ? ponto.nota_media.toFixed(1) : "Sem avaliações"
            }}
            / 5
          </div>
        </v-col>
      </v-row>
      <v-btn
        class="mt-6"
        color="success"
        prepend-icon="mdi-map-marker"
        :href="googleMapsUrl"
        target="_blank"
      >
        Ver no Google Maps
      </v-btn>

      <v-divider class="my-6" />

      <!-- AVALIAR -->
      <h2 class="text-h5 mb-2">Avaliar este ponto</h2>

      <v-row>
        <v-col cols="12" md="4">
          <v-rating v-model="novaAvaliacao.nota" color="amber" />
        </v-col>

        <v-col cols="12">
          <v-textarea
            v-model="novaAvaliacao.comentario"
            label="Comentário"
            rows="3"
          />
        </v-col>

        <v-col cols="12">
          <v-btn color="primary" @click="enviarAvaliacao">
            Enviar Avaliação
          </v-btn>
        </v-col>
      </v-row>

      <v-divider class="my-6" />

      <!-- COMENTÁRIOS -->
      <h2 class="text-h5 mb-4">Comentários</h2>

      <ComentariosList :pontoId="Number(ponto.id)"/>

      <v-divider class="my-6" />

      <!-- HOSPEDAGENS -->
      <h2 class="text-h5 mb-4">Hospedagens disponíveis</h2>

      <v-row v-if="hospedagens.length === 0">
        <v-col cols="12" class="text-grey">
          Nenhuma hospedagem cadastrada.
        </v-col>
      </v-row>

      <v-row v-else>
        <v-col v-for="h in hospedagens" :key="h.id" cols="12" md="4">
          <v-card class="pa-3">
            <h3 class="text-h6">{{ h.nome }}</h3>
            <p>{{ h.endereco }}</p>
            <p><strong>Tipo:</strong> {{ h.tipo }}</p>
            <p><strong>Preço médio:</strong> R$ {{ h.preco_medio }}</p>

            <v-btn
              variant="text"
              color="primary"
              :href="h.link_reserva"
              target="_blank"
            >
              Reservar
            </v-btn>
          </v-card>
        </v-col>
      </v-row>
      <v-btn
        v-if="auth.userRole === 'ADMIN'"
        class="mt-10"
        color="primary"
        prepend-icon="mdi-plus"
        @click="$router.push(`/pontos/${ponto.id}/hospedagens/nova`)"
      >
        Cadastrar Nova hospedagem
      </v-btn>
      <v-btn
        v-if="auth.userRole === 'ADMIN'"
        class="mt-10 w-100"
        color="red"
        variant="flat"
        prepend-icon="mdi-delete"
        @click="confirmarExclusao"
      >
        Excluir ponto turístico
      </v-btn>
    </template>
  </v-container>
</template>

<script lang="ts">
import { defineComponent, onMounted, reactive, ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import api from "@/services/api";
import { computed } from "vue";
import { useAuthStore } from "@/stores/authStore";
import ComentariosList from "@/components/Comentarios/ComentarioList.vue";

export default defineComponent({
  components: {
    ComentariosList,
  },
  setup() {
    const route = useRoute();
    const router = useRouter();
    const id = route.params.id;
    const auth = useAuthStore();

    const loading = ref(true);

    const ponto = reactive<any>({});
    // const comentarios = ref<any[]>([]);
    const hospedagens = ref<any[]>([]);

    const novaAvaliacao = reactive({
      nota: 0,
      comentario: "",
    });

    const googleMapsUrl = computed(() => {
      if (!ponto.latitude || !ponto.longitude) return "";
      return `https://www.google.com/maps?q=${ponto.latitude},${ponto.longitude}`;
    });

    const carregarDados = async () => {
      try {
        const [pontoRes, hospedagemRes] = await Promise.all([
          api.get(`http://localhost:8000/api/pontos/${id}`),
          api.get(`http://localhost:8000/api/pontos/${id}/hospedagens`),
        ]);

        Object.assign(ponto, pontoRes.data);
        hospedagens.value = hospedagemRes.data;

        // // comentários (mock por enquanto)
        // comentarios.value = [
        //   {
        //     id: 1,
        //     usuario: "Vitor Martins",
        //     texto: "Gostei muito desse ponto turístico!!!",
        //   },
        // ];
      } finally {
        loading.value = false;
      }
    };

    const enviarAvaliacao = async () => {
      await api.post(`http://localhost:8000/api/avaliacoes`, {
        ponto_id: Number(id),
        nota: novaAvaliacao.nota,
        comentario: novaAvaliacao.comentario,
      });

      novaAvaliacao.nota = 0;
      novaAvaliacao.comentario = "";
      await carregarDados();
    };

    const confirmarExclusao = async () => {
      const confirmado = confirm(
        "Tem certeza que deseja excluir este ponto turístico? Essa ação não pode ser desfeita."
      );

      if (!confirmado) return;

      try {
        await api.delete(`http://localhost:8000/api/pontos/${id}`);

        alert("Ponto turístico excluído com sucesso");

        router.push("/home");
      } catch (error) {
        alert("Erro ao excluir ponto turístico");
        console.error(error);
      }
    };

    onMounted(carregarDados);

    return {
      loading,
      ponto,
      googleMapsUrl,
      // comentarios,
      hospedagens,
      novaAvaliacao,
      enviarAvaliacao,
      auth,
      confirmarExclusao
    };
  },
});
</script>
