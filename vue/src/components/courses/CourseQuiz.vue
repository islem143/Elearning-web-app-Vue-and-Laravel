<template >
  <div
    class="pa-7 w-5 cursor-pointer py-2 px-4 m-4 border-round transition-all transition-duration-200 hover:bg-gray-100 shadow-4 hover:shadow-6"
  >
    <div class="flex gap-2 align-items-center">
      <i class="pi pi-check-square"></i>
      <h4>Quiz</h4>
    </div>
    <div class="p-2">
      <div v-if="role!='teacher' && quiz.user_id">
        <p>
          <b>Title: </b>{{ quiz.title }}, <b> mark: {{ quiz.mark }}</b>
        </p>
        <p>
          <b> time: {{ quiz.time }}</b>
        </p>
      </div>

      <div v-else>
        <p><b>Title: </b>{{ quiz.title }}</p>

        <p><b>Duration: </b> {{ quiz.duration }} mn</p>
      </div>
    </div>

    <div class="p-2 flex gap-2">
  
      <Button
        v-if="role == 'student'"
        class="text-sm"
        @click="$emit('go-to-quiz', quiz)"
        :label="quiz.user_id ? 'See Result' : 'Start Quiz'"
      />
      <Button
        style="width: 110px"
        class="text-sm"
        v-if="role == 'teacher'"
        @click="$emit('edit-quiz', quiz)"
        label="Edit Quiz"
      />
      <Button
        style="width: 110px"
        class="text-sm p-button-danger"
        v-if="role == 'teacher'"
        @click="$emit('delete-quiz', quiz)"
        label="Delete Quiz"
      />
    </div>
  </div>
</template>

<script>
export default {
  name: "CourseQuiz",
  props: ["quiz", "course"],
  inject: ["role"],
};
</script>
