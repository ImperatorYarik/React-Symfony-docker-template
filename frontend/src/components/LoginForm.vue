<script setup>
import axios from "axios";
import {jwtDecode} from "jwt-decode";
import {reactive} from "vue";

const form = reactive({
  username: "",
  password: "",
});

const login = async () => {
  try {
    const response = await axios.post('https://localhost/api/login_check', form);
    let tokenData = jwtDecode(response.data.token);
    localStorage.setItem('access_token', response.data.token);
    localStorage.setItem('role', [tokenData.roles]);
    alert('Авторизовано');
  }catch (error){
    console.log('Login failed with an error', error)
    alert('Login failed')
  }
};

</script>

<template>
  <div>
    <h1>Login Form</h1>
    <form @submit.prevent="login" class="register-from">
      <div>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" v-model="form.username"/>
      </div>
      <div>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" v-model="form.password"/>
      </div>
      <button type="submit">Зайти</button>
    </form>
  </div>
</template>

<style scoped>

</style>