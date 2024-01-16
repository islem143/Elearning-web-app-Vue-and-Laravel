<template>
  <div class="app">
    <div class="w-8 mx-auto">
      <div class="list flex justify-content-end">
        <ul class="flex list-none">
          <li class="p-2 mr-4 text-xl hover:text-gray-400 cursor-pointer">
            Home
          </li>
          <li class="p-2 mr-4 text-xl hover:text-gray-400 cursor-pointer">
            About
          </li>
          <li class="p-2 text-xl hover:text-gray-400 cursor-pointer">
            <Router-link :to="{ name: 'module-list' }">
              <button
                style="background: none"
                class="text-xl border-none hover:text-gray-400 cursor-pointer"
              >
                Courses
              </button>
            </Router-link>
          </li>
          <li class="ml-6">
            <p class="text-3xl">|</p>
          </li>
          <li class="p-2 ml-5">
            <Router-link :to="{ name: 'login' }">
              <button
                style="background: none"
                class="text-xl border-none hover:text-gray-400 cursor-pointer"
              >
                Login
              </button>
            </Router-link>
          </li>

          <li class="p-1">
            <Router-link :to="{ name: 'register' }">
              <button
                style=" background: #0056D2;"
                class="text-xl text-white py-2  hover:surface-800 px-3 cursor-pointer outline-none border-1 border-round-md border-500"
              >
                Sign up
              </button>
            </Router-link>
          </li>
        </ul>
      </div>
      <div class="grid gap-8">
        
        <div class="w-5 main flex flex-column align-items-start">
          <h1 class=" text-bold">
            E-Learning platform <br />
            Online courses at your time
          </h1>

          <p class="mt-5 w-9">
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Alias sunt
            quasi eos rem quibusdam dolorum a porro beatae iste cumque adipisci
          </p>
          <div class="flex align-items-center mt-5">
            <Button id="btn" class="text-white mr-3 px-3">Courses</Button>
            <a href="#" class=" text-900">Learn more</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup >
import {useTodos} from "../store/piniatest";

const store=useTodos();
console.log(store.finishedTodos);

store.addTodo("first 1");
console.log(store.unfinishedTodos);

</script>


<style type="text/css" scoped>
.app {
  background: #fff;
  font-family: "Montserrat", sans-serif;
  height: 100vh;
  color: #000;
}
#btn{
  background: #0056D2;
}
.main {
  margin: 85px 0 0 100px;
}
.list {
  color: #000;
  padding: 20px;
  margin: 0;
 
}
.st0 {
  display: none;
}
.st1 {
  display: inline;
  opacity: 0.31;
}
.st2 {
  fill: #084970;
}
.st3 {
  fill: #cde8f9;
}
.st4 {
  fill: #d3d3d3;
}
.st5 {
  fill: #a09f9f;
}
.st6 {
  fill: #fdbd56;
}
.st7 {
  fill: #ffffff;
}
.st8 {
  fill: #4c8dcb;
}
.st9 {
  fill: #fcd2b1;
}
.st10 {
  fill: #f2c6a8;
}
.st11 {
  fill: #0b538c;
}
.st12 {
  fill: none;
  stroke: #ffffff;
  stroke-linecap: round;
  stroke-miterlimit: 10;
}
</style>
