<template>
  <div class="app bg-indigo-100 h-full">
   
     <NavBar/>
      <Hero/>
  <Features/>
  </div>
</template>

<script setup >
import NavBar from "./Navbar.vue";
import Hero from "./Hero.vue"
import Features from "./Features.vue"
</script>


<style type="text/css" scoped>

#btn{
  background: #0056D2;
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
