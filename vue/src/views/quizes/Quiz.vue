<template>
  <div>
    <p class="text-red-400">{{ showError ? "please select a choice" : "" }}</p>

    <div
      v-if="questions.length != 0 && !quizFinished && !quizDone"
      class="flex w-8 mx-auto flex-column mt-8 justify-content-center align-items-center"
    >
      <div class="p-card p-3 mb-3 align-self-end">
        Time:
        {{ parseInt(duration / 1000 / 60) + "mn" }}
        {{ ((duration / 1000) % 60) + "s" }}
      </div>
      <Question :question="questions[currentIndex]" />
      <Choices
        @selectAnswer="selectAnswer"
        :selectedChoice="answers[currentIndex]"
        :choices="questions[currentIndex].choices"
        :correctChoice="correctChoice"
      />
      <Button class="align-self-end" label="Confirm" @click="confirmChoice" />
      <Button
        class="align-self-end"
        :label="currentIndex < questions.length - 1 ? 'Next' : 'Finish Quiz'"
        @click="nextQuestion"
      />
    </div>
    <div v-else-if="quizDone || quizFinished">
      <QuizStat :totalPoints="stats.totalPoints" :duration="stats.duration" />
    </div>
    <div v-else>Quiz Will be available sooner.</div>
  </div>
</template>

<script>
import Question from "../../components/quizes/Question.vue";
import Choices from "../../components/quizes/Choices.vue";
import QuizStat from "../../components/quizes/QuizStat.vue";
import axios from "../../http";

export default {
  name: "Quiz",
  components: {
    Question,
    Choices,
    QuizStat,
  },
  data() {
    return {
      quizId: null,
      courseId: null,
      quizFinished: false,
      showError: false,
      currentIndex: 0,
      questions: [],
      totalPoints: 0,
      answers: [],
      duration: 0,
      startDuration: null,
      timerId: null,
      quizDone: false,
      correctChoice: null,
      stats: {
        duration: 0,
        totalPoints: 0,
      },
    };
  },
  watch: {
    currentIndex(val) {
      if (val == this.questions.length) {
        this.finishQuiz();
      }
    },
    duration(val) {
      if (val == 0) {
        this.finishQuiz();
      }
    },
  },
  created() {
    let courseId = this.$route.params.courseId;
    let quizId = this.$route.params.quizId;
    this.quizId = quizId;
    this.courseId = courseId;
    axios
      .get("api/course/" + courseId + "/quiz/" + quizId + "/doneQuiz")
      .then((res) => {
        if (!res.data) {
          axios
            .get("api/course/" + courseId + "/quiz/" + quizId)
            .then((res) => {
              this.questions = res.data.questions;

              this.duration = this.startDuration =
                res.data.duration * 60 * 1000;

              this.timerId = setInterval(() => {
                this.duration = this.duration - 1000;
              }, 1000);
            });
          return;
        }
        this.quizDone = true;
        this.stats.totalPoints = res.data.pivot.mark;
        this.stats.duration = res.data.pivot.time;
      });
  },

  methods: {
    finishQuiz() {
      this.quizFinished = true;
      clearInterval(this.timerId);
      this.getScore();
      this.saveQuizResult();
    },
    saveQuizResult() {
      axios
        .put(
          "/api/course/" +
            this.courseId +
            "/quiz/" +
            this.quizId +
            "/saveResult",
          {
            mark: this.stats.totalPoints,
            time: this.stats.duration,
          }
        )
        .then((res) => {
          console.log(res);
        });
    },
    getScore() {
      let correctAnswers = this.answers.filter((an) => an.is_correct);
      this.totalPoints = correctAnswers.length;
      this.stats.totalPoints = correctAnswers.length;
      this.stats.duration = this.startDuration - this.duration;
    },
    selectAnswer(choice) {
      if (!this.correctChoice) {
        this.answers[this.currentIndex] = choice;
      }
    },
    confirmChoice() {
      let isCorrect = this.questions[this.currentIndex].choices.filter(
        (c) => c.is_correct
      )[0];
      this.correctChoice = isCorrect;
    },
    nextQuestion() {
      if (this.answers[this.currentIndex]) {
        this.correctChoice = false;
        this.showError = false;
        // console.log(this.answers[this.currentIndex]);

        axios
          .put(
            "/api/question/" +
              this.questions[this.currentIndex].id +
              "/choice/" +
              this.answers[this.currentIndex].id +
              "/attach"
          )
          .then((res) => {
            console.log(res);
          });
        this.currentIndex++;
      } else {
        this.showError = true;
      }
    },
  },
};
</script>
