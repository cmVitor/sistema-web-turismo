import api from './api'

export class FavoritosService {
  /**
   * Busca os favoritos do usuário
   */
  async listarFavoritos(): Promise<number[]> {
    const response = await api.get('/favoritos')
    // backend retorna [{id:1, ponto_id:5}, ...]
    return response.data.map((f: any) => f.ponto_id)
  }

  /**
   * Adiciona um favorito
   */
  async adicionarFavorito(pontoId: number): Promise<any> {
    const response = await api.post('/favoritos', { ponto_id: pontoId })
    return response.data
  }

  /**
   * Remove um favorito
   */
  async removerFavorito(pontoId: number): Promise<void> {
    await api.delete(`/favoritos/${pontoId}`)
  }
}
