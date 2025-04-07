<script setup>
import RenderingArrayComponent from "@/components/RenderingArrayComponent.vue";

const {email, roles, computers} = defineProps(['email', 'roles', 'computers']);

</script>

<template>
  <div class="flex center-content user-card">
    <div>{{ email }}</div>
    <RenderingArrayComponent :array="roles" title="Roles"/>
    <RenderingArrayComponent :array="computers" title="Computers"/>
  </div>
</template>

<style scoped>

</style>