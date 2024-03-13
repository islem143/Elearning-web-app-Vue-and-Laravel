<template>
  <div class="border-bottom-1 border-50	">
    <div class="w-8 font-semibold	  flex align-items-center	justify-content-between	  mx-auto">
      <h1 class="m-0">Logo</h1>
   
     <div class="list flex      pt-3">
        <ul class="flex list-none">
          <li class="p-2 mr-1 text-xl hover:text-indigo-400 cursor-pointer">
            Home
          </li>
         
          <li class="p-2 mr-1 text-xl hover:text-indigo-400 cursor-pointer">
            <Router-link :to="{ name: 'module-list' }">
              <a
             
                class="text-xl text-white  hover:text-indigo-400 cursor-pointer"
              >
                Courses
            </a>
            </Router-link>
          </li>
          <li class="p-2 mr-1 text-xl hover:text-indigo-400 cursor-pointer">
            About
          </li>
          <li class="p-2 mr-1 text-xl hover:text-indigo-400 cursor-pointer">
           Contact 
          </li>
          <li class="ml-6" v-if="!isAuth">
            <p class="text-3xl">|</p>
          </li>
          <li class="p-2  ml-5" v-if="!isAuth">
            <Router-link :to="{ name: 'login' }">
              <a
              
                class="text-xl border-none hover:text-indigo-400 cursor-pointer"
              >
                Login
            </a>
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
          <li class="" v-if="isAuth">
            <Router-link :to="{ name: 'modules' }">
              <button
              
                class="text-xl bg-white hover:bg-indigo-300   text-black p-2    px-2 cursor-pointer outline-none border-2 font-bold border-black-alpha-90	 border-round-md border-500"
              >
                Dashbarod
              </button>
            </Router-link>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>
<script setup >
import {useAuth} from "../store/authStore";

const {isAuth}=useAuth();
console.log(isAuth);

</script>

