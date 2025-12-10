// stores/userStore.ts
import { defineStore } from 'pinia'
import type { IUsuario } from '@/interfaces/User/IUsuario'
import userService from '@/services/userService'

export const useUserStore = defineStore('userStore', {
    state: () => ({
        usuarios: [] as IUsuario[],
        loading: false
    }),

    actions: {
        async buscarUsuarios() {
            try {
                this.loading = true
                const { data } = await userService.getAll()
                this.usuarios = data
            } catch (error) {
                console.error('Erro ao buscar usuários:', error)
            } finally {
                this.loading = false
            }
        },

        async salvarUsuario(usuario: IUsuario) {
            try {
                await userService.create(usuario)
                await this.buscarUsuarios()
            } catch (error) {
                console.error('Erro ao salvar usuário:', error)
                throw error
            }
        },

        async atualizarUsuario(usuario: IUsuario) {
            if (!usuario.id) return
            try {
                await userService.update(usuario)
                await this.buscarUsuarios()
            } catch (error) {
                console.error('Erro ao atualizar usuário:', error)
                throw error
            }
        },

        async excluirUsuario(id: number) {
            try {
                await userService.delete(id)
                this.usuarios = this.usuarios.filter(u => u.id !== id)
            } catch (error) {
                console.error('Erro ao excluir usuário:', error)
                throw error
            }
        }
    }
})
