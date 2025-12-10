<template>
    <v-container fluid>
        <UserTable></UserTable>
        <AddButton to="/usuarios/novo"></AddButton>
    </v-container>
</template>

<script>
import { defineComponent } from 'vue';

export default defineComponent({
    name: 'Usuarios'
})
</script>

<style>

</style>