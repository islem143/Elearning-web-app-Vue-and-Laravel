<template>
    <div class="">
      <div class="w-8 mx-auto">
        <h1 class="mb-4 text-6xl font-bold" style="margin-top: 200px">Our Teachers</h1>
      </div>
      <div class="mx-auto grid w-8 gap-8 mt-5">


    <Card class="shadow-4 border-round-3xl		" style="width: 22rem; overflow: hidden">
        <template #header>
            <img width="250" height="250" alt="user header	" src="http://localhost:8000/images/teacher.jpg" />
        </template>
        <template #title>Teacher 1</template>
        <template #subtitle>Developer</template>
        <template #content>
            <p class="m-0">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore sed consequuntur error repudiandae numquam deserunt quisquam repellat libero asperiores earum nam nobis.

            </p>
        </template>
        <template #footer>
            <div class="flex gap-3 mt-1">
                <Button icon="pi pi-inbox" label="Contact" class="border-round-xl w-full" />
            </div>
        </template>
    </Card>
    <Card class="shadow-4 border-round-3xl	" style="width: 22rem; overflow: hidden">
        <template #header>
            <img width="250" height="250" alt="user header	" src="http://localhost:8000/images/teacher.jpg" />
        </template>
        <template #title>Teacher 2</template>
        <template #subtitle>Marketing Specialist</template>
        <template #content>
            <p class="m-0">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore sed consequuntur error repudiandae numquam deserunt quisquam repellat libero asperiores earum nam nobis.
            </p>
        </template>
        <template #footer>
            <div class="flex gap-3 mt-1">
                <Button icon="pi pi-inbox"  label="Contact" class="border-round-xl w-full" />
            </div>
        </template>
    </Card>
    <Card class="shadow-4 border-round-3xl	" style="width: 22rem; overflow: hidden">
        <template #header>
            <img width="250" height="250" alt="user header	" src="http://localhost:8000/images/teacher.jpg" />
        </template>
        <template #title>Teacher 3</template>
        <template #subtitle>Ux/Ui Designer</template>
        <template #content>
            <p class="m-0">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore sed consequuntur error repudiandae numquam deserunt quisquam repellat libero asperiores earum nam nobis.
            </p>
        </template>
        <template #footer>
            <div class="flex gap-3 mt-1">
                <Button icon="pi pi-inbox" label="Contact" class="border-round-xl w-full" />
            </div>
        </template>
    </Card>

      </div>
    </div>
  </template>

  <script setup>
</script>