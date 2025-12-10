import api from './api'
import type { IUsuario } from '@/interfaces/User/IUsuario'

export default {
    getAll() {
        return api.get('/usuarios')
    },

    create(usuario: IUsuario) {
        return api.post('/register', usuario)
    },

    update(usuario: IUsuario) {
        return api.put(`/usuarios/${usuario.id}`, usuario)
    },

    delete(id: number) {
        return api.delete(`/usuarios/${id}`)
    }
}
