<template>
    <div class="grid w-8 mx-auto ">
        
        <div class="col-4 w-5 main flex flex-column align-items-start">
          <h1 class=" text-bold">
          <span class="text-indigo-500 font-bold text-6xl	"> E-Learning platform </span> 
            <br />
            Online courses at your time.
          </h1>

          <p class="mt-4 w-9 text-xl font-medium			">
            Lorem ipsum dolor sit amet consectetur adipisicing elit.
           
          </p>
          <div class="flex align-items-center mt-5">
            <Button id="btn" class="text-white mr-3 px-3 bg-indigo-600 text-xl ">Get Started</Button>
            <Button  class=" text-900 bg-indigo-100 mr-3 px-3   hover:text-indigo-800">Learn more</Button>
          </div>
        </div>
        <div class="col-4">
          <img width="500" height="500" src="http://localhost:8000/images/prof.svg" alt="">
        </div>
      </div>
</template>


<style scoped>
.main {
  margin: 85px 0 0 100px;
}
</style>