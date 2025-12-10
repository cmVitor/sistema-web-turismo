import { defineStore } from 'pinia'
import { FavoritosService } from '../services/favoritosService'

const favoritosService = new FavoritosService()

export const useFavoritosStore = defineStore('favoritos', {
  state: () => ({
    favoritos: [] as number[], // armazena apenas os ponto_id
  }),

  actions: {
    async carregarFavoritos() {
      try {
        this.favoritos = await favoritosService.listarFavoritos()
      } catch (error) {
        console.error('Erro ao carregar favoritos:', error)
      }
    },

    async addFavorito(pontoId: number) {
      try {
        await favoritosService.adicionarFavorito(pontoId)
        if (!this.favoritos.includes(pontoId)) {
          this.favoritos.push(pontoId)
        }
      } catch (error) {
        console.error('Erro ao adicionar favorito:', error)
      }
    },

    async removeFavorito(pontoId: number) {
      try {
        await favoritosService.removerFavorito(pontoId)
        this.favoritos = this.favoritos.filter(id => id !== pontoId)
      } catch (error) {
        console.error('Erro ao remover favorito:', error)
      }
    },

    async toggleFavorito(pontoId: number) {
      if (this.isFavorito(pontoId)) {
        await this.removeFavorito(pontoId)
      } else {
        await this.addFavorito(pontoId)
      }
    },

    isFavorito(pontoId: number) {
      return this.favoritos.includes(pontoId)
    }
  }
})
