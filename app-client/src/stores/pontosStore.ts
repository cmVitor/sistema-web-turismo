import { defineStore } from "pinia";
import { PontosService } from "../services/PontosService";

export interface IPonto {
  id: number;
  nome: string;
  descricao: string;
  cidade: string;
  estado: string;
  pais: string;
  nota_media: number | null;
  foto_url?: string;
}

export interface IPontoCreate {
  nome: string;
  descricao: string;
  cidade: string;
  estado: string;
  pais: string;
  latitude: number | null;
  longitude: number | null;
  endereco: string;
}

export const usePontosStore = defineStore("pontos", {
  state: () => ({
    loading: false as boolean,
    pontos: [] as IPonto[],
    filtros: {
      nome: "",
      cidade: "",
      nota: "",
    },
  }),

  actions: {
    async fetchPontos() {
      try {
        this.loading = true;
        this.pontos = await PontosService.fetchPontos(this.filtros);
      } finally {
        this.loading = false;
      }
    },

    async createPonto(data: IPontoCreate) {
      try {
        this.loading = true;
        await PontosService.createPonto(data);
        await this.fetchPontos(); // atualiza a lista
      } finally {
        this.loading = false;
      }
    },

    setFiltro(campo: string, valor: string) {
      (this.filtros as any)[campo] = valor;
    },

    async fetchMaisAcessados() {
      try {
        this.loading = true;
        this.pontos = await PontosService.fetchMaisAcessados();
      } finally {
        this.loading = false;
      }
    },
  },
});
