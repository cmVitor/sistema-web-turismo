<template>
  <v-card class="pa-4 mb-4">
    <v-form ref="form" @submit.prevent="submit">
      <v-textarea
        v-model="texto"
        label="Escreva seu comentário"
        rows="3"
        required
      />

      <div class="my-3">
        <input type="file" multiple accept="image/*" @change="onFilesChange" />
      </div>

      <!-- previews -->
      <div class="d-flex gap-2 mb-3">
        <div v-for="(p, idx) in previews" :key="idx" style="width:100px">
          <v-img :src="p" height="80" contain />
          <v-btn small text @click="removePreview(idx)">Remover</v-btn>
        </div>
      </div>

      <v-btn color="primary" type="submit" :loading="loading">Enviar</v-btn>
    </v-form>
  </v-card>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue'
import { ComentariosService } from '@/services/comentariosService'

const service = new ComentariosService()

export default defineComponent({
  props: {
    pontoId: { type: [String, Number], required: true }
  },
  setup(props, { emit }) {
    const texto = ref('')
    const files = ref<File[]>([])
    const previews = ref<string[]>([])
    const loading = ref(false)

    const onFilesChange = (e: Event) => {
      const input = e.target as HTMLInputElement
      if (!input.files) return
      for (let i = 0; i < input.files.length; i++) {
        const file = input.files[i]
        files.value.push(file)
        const reader = new FileReader()
        reader.onload = () => previews.value.push(reader.result as string)
        reader.readAsDataURL(file)
      }
      // clear input
      input.value = ''
    }

    const removePreview = (idx: number) => {
      previews.value.splice(idx, 1)
      files.value.splice(idx, 1)
    }

    const submit = async () => {
      if (!texto.value.trim() && files.value.length === 0) {
        return alert('Escreva um comentário ou envie uma foto.')
      }

      loading.value = true
      try {
        const fd = new FormData()
        fd.append('texto', texto.value)
        files.value.forEach((f) => fd.append('imagens[]', f))

        const created = await service.criar(Number(props.pontoId), fd)

        // emitir evento para pai recarregar lista
        emit('comentario-criado', created)

        // reset
        texto.value = ''
        files.value = []
        previews.value = []
      } catch (err) {
        console.error(err)
        alert('Erro ao enviar comentário.')
      } finally {
        loading.value = false
      }
    }

    return {
      texto,
      onFilesChange,
      previews,
      removePreview,
      submit,
      loading
    }
  }
})
</script>
