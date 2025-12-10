<template>
  <div>
    <ComentarioForm :pontoId="pontoId" @comentario-criado="onCriado" />

    <v-list>
      <v-list-item v-for="c in comentarios" :key="c._id">
        <v-list-item-content>
          <v-list-item-title>
            <strong>{{ c.usuario_nome }}</strong>
            <span class="text-caption text-grey ml-2">{{
              formatDate(c.created_at)
            }}</span>
          </v-list-item-title>
          <v-list-item-subtitle>{{ c.texto }}</v-list-item-subtitle>

          <div v-if="c.imagens && c.imagens.length" class="mt-3 d-flex gap-2 justify-start flex-wrap">
            <v-img
              v-for="(img, i) in c.imagens"
              :key="i"
              :src="img"
              height="250"
              width="200"
              contain
            />
          </div>
        </v-list-item-content>
      </v-list-item>
    </v-list>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from "vue";
import { ComentariosService } from "@/services/comentariosService";
import ComentarioForm from "@/components/Comentarios/ComentarioForm.vue";

const service = new ComentariosService();

const imagemAtiva = ref<string | null>(null)
const dialogImagem = ref(false)

const abrirImagem = (img: string) => {
  imagemAtiva.value = img
  dialogImagem.value = true
}

export default defineComponent({
  components: { ComentarioForm },
  props: {
    pontoId: { type: [String, Number], required: true },
  },
  setup(props) {
    const comentarios = ref<any[]>([]);
    const loading = ref(false);

    const load = async () => {
      loading.value = true;
      try {
        comentarios.value = await service.listar(Number(props.pontoId));
      } finally {
        loading.value = false;
      }
    };

    const onCriado = async () => {
      await load();
    };

    onMounted(load);

    const formatDate = (d: string) => {
      return new Date(d).toLocaleString();
    };

    return { comentarios, onCriado, formatDate };
  },
});
</script>

