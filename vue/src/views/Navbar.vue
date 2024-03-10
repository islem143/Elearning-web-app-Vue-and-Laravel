<template>
    <div class="bg-indigo-50 shadow-1">

   
     <div class="list flex justify-content-end  w-8 mx-auto pt-3">
        <ul class="flex list-none">
          <li class="p-2 mr-1 text-xl hover:text-indigo-400 cursor-pointer">
            Home
          </li>
          <li class="p-2 mr-1 text-xl hover:text-indigo-400 cursor-pointer">
            About
          </li>
          <li class="p-2 mr-1 text-xl hover:text-indigo-400 cursor-pointer">
            <Router-link :to="{ name: 'module-list' }">
              <button
                style="background: none"
                class="text-xl border-none hover:text-indigo-400 cursor-pointer"
              >
                Courses
              </button>
            </Router-link>
          </li>
          <li class="ml-6" v-if="!isAuth">
            <p class="text-3xl">|</p>
          </li>
          <li class="p-2 ml-5" v-if="!isAuth">
            <Router-link :to="{ name: 'login' }">
              <button
                style="background: none"
                class="text-xl border-none hover:text-indigo-400 cursor-pointer"
              >
                Login
              </button>
            </Router-link>
          </li>

          <li class="p-1" v-if="!isAuth">
            <Router-link :to="{ name: 'register' }">
              <button
                style=" background: #0056D2;"
                class="text-xl text-white py-2  hover:ingigo-400 px-2 cursor-pointer outline-none border-1 border-round-md border-500"
              >
                Sign up
              </button>
            </Router-link>
          </li>
          <li class="p-1" v-if="isAuth">
            <Router-link :to="{ name: 'modules' }">
              <button
              
                class="text-xl bg-indigo-500 text-white p-2   hover:bg-indigo-600 px-2 cursor-pointer outline-none border-1 border-round-md border-500"
              >
                Dashbarod
              </button>
            </Router-link>
          </li>
        </ul>
      </div>
    </div>
</template>
<script setup >
import {useAuth} from "../store/authStore";

const {isAuth}=useAuth();
console.log(isAuth);

</script>

