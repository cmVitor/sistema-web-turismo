<template>
    <div class="addBtn">
        <v-btn class="gradient-btn" color="primary" @click="$router.push(to)">
            <v-icon size="x-large">mdi-plus</v-icon>
        </v-btn>
    </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
export default defineComponent({
    name: "AddButton",
    props: {
        to: {
            type: String,
            required: true
        }
    }
})
</script>

<style scoped>
.addBtn {
    display: flex;
    justify-content: center;
    margin-top: 20px;
    width: 100%;
}

.addBtn .v-btn {
    width: 20%;
    height: 80px;
}
.gradient-btn {
  background: linear-gradient(45deg, rgb(8, 54, 194), #6e70e0);
  color: white !important;
  font-weight: 600;
  border-radius: 12px;
  transition: all 0.3s ease;
}

.gradient-btn:hover {
  background: linear-gradient(45deg, #1d1085, #2e45c5);
  transform: scale(1.02);
}
</style>