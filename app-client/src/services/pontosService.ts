import api from './api';
import type { IPonto, IPontoCreate } from '../stores/pontosStore';

export class PontosService {
  static async fetchPontos(filtros: { nome?: string; cidade?: string; nota?: string }) {
    try {
      const response = await api.get('/pontos', {
        params: {
          nome: filtros.nome || undefined,
          cidade: filtros.cidade || undefined,
          nota: filtros.nota || undefined,
        },
      });
      return response.data.data as IPonto[];
    } catch (error) {
      console.error('Erro ao buscar pontos:', error);
      throw error;
    }
  }

  static async createPonto(data: IPontoCreate) {
    try {
      await api.post('/pontos', data);
    } catch (error) {
      console.error('Erro ao criar ponto:', error);
      throw error;
    }
  }

  static async fetchMaisAcessados() {
    const response = await api.get(
      "http://localhost:8000/api/pontos/mais-acessados"
    );
    return response.data;
  }
}
