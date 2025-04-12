<script setup>

import axios from "axios";
import {jwtDecode} from "jwt-decode";
import {ref} from "vue";

let userToken = localStorage.getItem('access_token');
const userEmail = jwtDecode(userToken).username;
const userInfo = ref([]);

const userData = axios.get(
    `https://localhost/api/users?page=1&itemsPerPage=10&email=${userEmail}`,
    {
      headers: {
        'Authorization' : 'Bearer ' + userToken,
      }
    }
).then(userData => {
      userInfo.value = userData.data
    }
);

</script>

<template>
  <div>
    <img :src="userInfo[0].avatar" alt="">
    <p>name: {{ userInfo[0].name }}</p>
    <p>surname: {{ userInfo[0].surname }}</p>
    <p>email: {{ userInfo[0].email }}</p>
    <p>phone number: {{ userInfo[0].phoneNumber }}</p>
    <p>role: {{ userInfo[0].roles }}</p>
  </div>

  <img style="width: 600px; height: auto" src="https://ztusymfonycourse.s3.eu-north-1.amazonaws.com/c9e7d82181b260819890f9b9d14c3ba4.png?X-Amz-Content-Sha256=UNSIGNED-PAYLOAD&X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIA6ODU25J6XUUGE2QN%2F20250411%2Feu-north-1%2Fs3%2Faws4_request&X-Amz-Date=20250411T163937Z&X-Amz-SignedHeaders=host&X-Amz-Expires=1200&X-Amz-Signature=40b0627adbcd455926b5bc0f5eb24cf786bc796b1874eb102da7a78cac2e5de5" alt="">
</template>

<style scoped>

</style>