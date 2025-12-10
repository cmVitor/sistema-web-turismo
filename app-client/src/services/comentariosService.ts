import api from '@/services/api'

export class ComentariosService {
  async listar(pontoId: number) {
    const res = await api.get(`/pontos/${pontoId}/comentarios`)
    return res.data
  }

  async criar(pontoId: number, formData: FormData) {
    const res = await api.post(`/pontos/${pontoId}/comentarios`, formData, {
      headers: { 'Content-Type': 'multipart/form-data' }
    })
    return res.data
  }
}
