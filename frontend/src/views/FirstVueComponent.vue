<script setup>
import UserTable from "@/components/UserTable.vue";
import {onMounted, ref} from "vue";

const users = ref([]);

onMounted(async () => {
  const response = await fetch('https://localhost/api/users?page=1', {
    method: 'GET'
  });

  if (!response){
    throw new Error('Request faild');
  }
  users.value = await response.json();
});

</script>

<template>
  <UserTable :users="users"/>
</template>

<style scoped>

</style>