import api from './api'
import type { ICredentials } from '@/Interfaces/Login/ICredentials'

export default {
    login(credentials: ICredentials) {
        return api.post('/login', credentials)
    },

    buscarUsuarioLogado() {
        return api.get('/me')
    },

    logout() {
        return api.post('/logout')
    }
}
