<script setup>
  import UserCardComponent from "@/components/UserCardComponent.vue";

  const { users } = defineProps({ users: {
      required: true
    }
  });

</script>

<template>
  <ol>
    <li v-for="(user, index) in users" :key="index">
      <UserCardComponent
          :email="user.email"
          :roles="user.roles"
          :computers="user.computers"/>
    </li>
  </ol>
</template>

<style scoped>

</style>