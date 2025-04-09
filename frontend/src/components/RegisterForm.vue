<script setup>
import axios from "axios";
import {reactive} from "vue";

const form = reactive({
  name: "",
  surname: "",
  lastName: "",
  email: "",
  phoneNumber: "",
  password: "",
});

const register = async () => {
  try {
    const response = await axios.post('https://localhost/api/registration', form);
    console.log(response);
    alert('User created');
  }catch (error){
    console.log('Registration failed with an error', error)
    alert('Registration failed')
  }
};

</script>

<template>
  <div>
    <h1>RegisterForm</h1>
    <form @submit.prevent="register" class="register-from">
      <div>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" v-model="form.email"/>
      </div>
      <div>
        <label for="phone">Phone number</label>
        <input type="text" name="phone" id="phone" v-model="form.phoneNumber" />
      </div>
      <div>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" v-model="form.password"/>
      </div>
      <div>
        <label for="name">Name</label>
        <input type="text" name="name" id="name" v-model="form.name"/>
      </div>
      <div>
        <label for="surname">Surname</label>
        <input type="text" name="surname" id="surname" v-model="form.surname"/>
      </div>
      <div>
        <label for="lastname">Last name</label>
        <input type="text" name="lastname" id="lastname" v-model="form.lastName"/>
      </div>
      <button type="submit">Зареєструватися</button>
    </form>
  </div>
</template>

<style scoped>

</style>