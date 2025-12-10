import { defineStore } from "pinia";
import type { ICredentials } from "@/Interfaces/Login/ICredentials";
import { jwtDecode } from "jwt-decode";
import type { IUsuarioLogado } from "@/Interfaces/User/IUsuarioLogado";
import AuthService from "@/services/authService";
import api from "@/services/api";

export const useAuthStore = defineStore("authStore", {
  state: () => ({
    isAuthenticated: false as boolean,
    erro: "" as string,
    token: "" as string,
    userRole: "" as string,
    usuarioLogado: null as IUsuarioLogado | null,
  }),

  actions: {
    async login(credentials: ICredentials) {
      try {
        console.log(credentials);

        const response = await AuthService.login(credentials);
        const token = response.data.access_token;

        console.log(token);

        if (token) {
          this.token = token;
          this.isAuthenticated = true;

          localStorage.setItem("token", token);

          api.defaults.headers.common["Authorization"] = `Bearer ${token}`;

          const decoded: any = jwtDecode(token);
          this.userRole = decoded.role;
          console.log(this.userRole);

          await this.buscarUsuarioLogado();
          console.log(this.usuarioLogado);
          console.log()
        }
      } catch (error: any) {
        console.error("Erro no login:", error);

        if (error.response && error.response.status === 401) {
          this.erro = "E-mail ou senha incorretos";
        } else {
          this.erro = "Erro ao tentar logar.";
        }

        throw error;
      }
    },

    async buscarUsuarioLogado() {
      try {
        const response = await AuthService.buscarUsuarioLogado();
        this.usuarioLogado = response.data;

        localStorage.setItem("usuario", JSON.stringify(response.data));
      } catch (error) {
        console.error("Erro ao buscar usuário logado:", error);
      }
    },

    async logout() {
      this.token = "";
      this.isAuthenticated = false;
      this.usuarioLogado = null;

      localStorage.removeItem("token");
      localStorage.removeItem("usuario");

      await AuthService.logout();
    },

    carregarSessao() {
      const token = localStorage.getItem("token");

      if (token) {
        this.token = token;
        this.isAuthenticated = true;

        api.defaults.headers.common["Authorization"] = `Bearer ${token}`;

        const decoded: any = jwtDecode(token);
        this.userRole = decoded.role;
      }
    },
  },
});
