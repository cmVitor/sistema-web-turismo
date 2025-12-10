<template>
  <div>
    <HeaderDrawer v-model="isDrawerOpen" />
    <HeaderAppBar @toggle-drawer="isDrawerOpen = !isDrawerOpen" />
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import HeaderDrawer from './HeaderDrawer.vue'
import HeaderAppBar from './HeaderAppBar.vue'

export default defineComponent({
  name: 'Header',
  components: {
    HeaderDrawer,
    HeaderAppBar,
  },
  data() {
    return {
      isDrawerOpen: false as boolean,
    }
  },
})
</script>

<style scoped>
a {
  text-decoration: none;
  color: #505050;
}

.router-link-exact-active {
  color: #1976d2 !important;
  background-color: rgba(25, 118, 210, 0.1);
  border-radius: 8px;
}
</style>