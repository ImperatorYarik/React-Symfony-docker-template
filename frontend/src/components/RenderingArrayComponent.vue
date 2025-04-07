<script setup>
const { array, title } = defineProps(['array', 'title']);

</script>

<template>
  <div>
    <p>{{ title }}</p>
    <ul>
      <li v-for="(item, index) in array">
        {{ title !== 'Computers' ? item : item.name }}
      </li>
    </ul>
  </div>
</template>

<style scoped>

</style>