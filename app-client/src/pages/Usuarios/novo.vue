<template>
    <v-container fluid>
        <UserForm></UserForm>
        <RedirectButton to="/usuarios" text="Ver usuários"></RedirectButton>
    </v-container>
</template>

<script>
export default defineComponent({
    name: 'UsuarioNovo'
})
</script>

<style>

</style>