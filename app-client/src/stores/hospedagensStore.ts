import { defineStore } from 'pinia'
import api from "@/services/api";

export interface IHospedagem {
  id: number
  ponto_id: number
  nome: string
  endereco: string
  telefone?: string
  preco_medio?: number
  tipo: 'hotel' | 'pousada' | 'hostel'
  link_reserva?: string
}

export const useHospedagensStore = defineStore('hospedagens', {
  state: () => ({
    hospedagens: [] as IHospedagem[],
    loading: false,
    page: 1,
    lastPage: 1,
  }),

  actions: {
    async fetchHospedagens(page = 1) {
      try {
        this.loading = true
        this.page = page

        const response = await api.get(
          'http://localhost:8000/api/hospedagens',
          { params: { page } }
        )

        this.hospedagens = response.data.data
        this.lastPage = response.data.last_page
      } finally {
        this.loading = false
      }
    }
  }
})
