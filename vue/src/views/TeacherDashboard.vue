<template>
  <div class="grid  mx-auto">
    <div class="col-12 lg:col-6 xl:col-4" v-if="stats">
      <div class="card mb-0 bg-white shadow-5 hover:shadow-6">
        <div class="flex justify-content-between mb-3">
          <div>
            <span class="block text-500 font-medium mb-3">Students</span>
            <div class="text-900 font-medium text-xl">{{ stats.students }}</div>
          </div>
          <div
            class="flex align-items-center justify-content-center bg-blue-100 border-round"
            style="width: 2.5rem; height: 2.5rem"
          >
            <i class="pi pi-users text-blue-500 text-xl"></i>
          </div>
        </div>
        <!-- <span class="text-green-500 font-medium">24 new </span>
        <span class="text-500">since last visit</span> -->
      </div>
    </div>
    <div class="col-12 lg:col-6 xl:col-4" v-if="stats">
      <div class="card mb-0 bg-white shadow-5 hover:shadow-6">
        <div class="flex justify-content-between mb-3">
          <div>
            <span class="block text-500 font-medium mb-3">Modules</span>
            <div class="text-900 font-medium text-xl">{{ stats.modules }}</div>
          </div>
          <div
            class="flex align-items-center justify-content-center bg-blue-100 border-round"
            style="width: 2.5rem; height: 2.5rem"
          >
            <i class="pi pi-book text-blue-500 text-xl"></i>
          </div>
        </div>
      </div>
    </div>
    <!-- <div class="col-12 lg:col-6 xl:col-4" v-if="stats">
      <div class="card mb-0 bg-white shadow-5 hover:shadow-6">
        <div class="flex justify-content-between mb-3">
          <div>
            <span class="block text-500 font-medium mb-3">Total Quizzes</span>
            <div class="text-900 font-medium text-xl">
              {{ stats.totalQuizzes }}
            </div>
          </div>
          <div
            class="flex align-items-center justify-content-center bg-blue-100 border-round"
            style="width: 2.5rem; height: 2.5rem"
          >
            <i class="pi pi-question text-blue-500 text-xl"></i>
          </div>
        </div>
  
      </div>
    </div> -->
    <div class="col-12 lg:col-6 xl:col-4" v-if="stats">
      <div class="card mb-0 bg-white shadow-5 hover:shadow-6">
        <div class="flex justify-content-between mb-3">
          <div>
            <span class="block text-500 font-medium mb-3">Total Courses</span>
            <div class="text-900 font-medium text-xl">
              {{ stats.totalCourses }}
            </div>
          </div>
          <div
            class="flex align-items-center justify-content-center bg-blue-100 border-round"
            style="width: 2.5rem; height: 2.5rem"
          >
            <i class="pi pi-book text-blue-500 text-xl"></i>
          </div>
        </div>
        <!-- <span class="text-green-500 font-medium">%52+ </span>
        <span class="text-500">since last week</span> -->
      </div>
    </div>
    <!-- <div class="col-12 lg:col-6 xl:col-4" v-if="stats">
      <div class="card mb-0 bg-white shadow-5 hover:shadow-6">
        <div class="flex justify-content-between mb-3">
          <div>
            <span class="block text-500 font-medium mb-3"
              >Total Uploaded Media</span
            >
            <div class="text-900 font-medium text-xl">
              {{ stats.totalMedia }}
            </div>
          </div>
          <div
            class="flex align-items-center justify-content-center bg-blue-100 border-round"
            style="width: 2.5rem; height: 2.5rem"
          >
            <i class="pi pi-video text-blue-500 text-xl"></i>
          </div>
        </div>
        
      </div>
    </div> -->
    <div class="col-12 lg:col-6 xl:col-4" v-if="stats">
      <div class="card mb-0 p-4 bg-white w-full shadow-5 hover:shadow-6">
        <Chart
          type="pie"
          :data="chartData"
          :options="chartOptions"
          class="w-full"
        />
      </div>
    </div>
    <div class="col-12 lg:col-6 xl:col-8" v-if="stats">
      <div class="card  mb-0  bg-white w-full shadow-5 hover:shadow-6">
        <Chart type="line" :data="chartData2" :options="chartOptions2" />
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref, watch } from "vue";
import axios from "../http";

let stats = ref();
const chartData = ref();
const chartOptions = ref();
const chartData2 = ref();
const chartOptions2 = ref();
let studentCount = ref(new Array(12).fill(0));

onMounted(() => {
  axios.get("/api/teacher/stats").then((res) => {
    stats.value = res.data;
    let ress = new Array(12).fill(0);
    stats.value.barChart.forEach((val) => {
      console.log(val);
      ress[val.month - 1] = val.count_students;
    });
    studentCount.value = ress;

    chartData.value = setChartData();
    chartOptions.value = setChartOptions();
    chartData2.value = setChartData2();
    chartOptions2.value = setChartOptions2();
  });
});

const setChartData2 = () => {
  const documentStyle = getComputedStyle(document.body);

  return {
    labels: [
      "January",
      "February",
      "March",
      "April",
      "May",
      "June",
      "July",
      "August",
      "Semptember",
      "October",
      "November",
      "December",
    ],
    datasets: [
      {
        data: studentCount.value,
        label: 'Dataset 1',
        backgroundColor: [
          documentStyle.getPropertyValue("--blue-500"),
          documentStyle.getPropertyValue("--yellow-500"),
          documentStyle.getPropertyValue("--green-500"),
          documentStyle.getPropertyValue("--red-500"),
        ],
        hoverBackgroundColor: [
          documentStyle.getPropertyValue("--blue-400"),
          documentStyle.getPropertyValue("--yellow-400"),
          documentStyle.getPropertyValue("--green-400"),
        ],
      },
    ],
  };
};
const setChartData = () => {
  const documentStyle = getComputedStyle(document.body);

  return {
    labels: stats.value.moduleStudentPie.labels,
    datasets: [
      {
        data: stats.value.moduleStudentPie.data,
        backgroundColor: [
          documentStyle.getPropertyValue("--blue-500"),
          documentStyle.getPropertyValue("--yellow-500"),
          documentStyle.getPropertyValue("--green-500"),
          documentStyle.getPropertyValue("--red-500"),
        ],
        hoverBackgroundColor: [
          documentStyle.getPropertyValue("--blue-400"),
          documentStyle.getPropertyValue("--yellow-400"),
          documentStyle.getPropertyValue("--green-400"),
        ],
      },
    ],
  };
};

const setChartOptions2 = () => {
  const documentStyle = getComputedStyle(document.documentElement);

  return {
    plugins: {
      colors: {
        enabled: true,
      },

      title: {
        display: true,
        text: "Enrolled Students Per Month",
        font: {
          size: 20,
        },
      },
    },
  };
};
const setChartOptions = () => {
  const documentStyle = getComputedStyle(document.documentElement);
  const textColor = documentStyle.getPropertyValue("--text-color");

  return {
    plugins: {
      colors: {
        enabled: true,
      },
      legend: {
        labels: {
          usePointStyle: true,
          color: textColor,
        },
      },
      title: {
        display: true,
        text: "Students count per module",
        font: {
          size: 20,
        },
      },
    },
  };
};
</script>
<!-- <script >
  import EventBus from "../AppEventBus";
  import axios from "../http";
  export default {
    data() {
      return { stats: {} };
    },
    created() {
      axios.get("/api/teacher/stats").then((res) => {
        console.log(res);
        this.stats = res.data;
      });
    },
    themeChangeListener: null,
    mounted() {
      this.themeChangeListener = (event) => {
        if (event.dark) this.applyDarkTheme();
        else this.applyLightTheme();
      };
      EventBus.on("change-theme", this.themeChangeListener);
  
      if (this.isDarkTheme()) {
        this.applyDarkTheme();
      } else {
        this.applyLightTheme();
      }
    },
    beforeUnmount() {
      EventBus.off("change-theme", this.themeChangeListener);
    },
  
    methods: {
      formatCurrency(value) {
        return value.toLocaleString("en-US", {
          style: "currency",
          currency: "USD",
        });
      },
      isDarkTheme() {
        return this.$appState.darkTheme === true;
      },
      applyLightTheme() {
        this.lineOptions = {
          plugins: {
            legend: {
              labels: {
                color: "#495057",
              },
            },
          },
          scales: {
            x: {
              ticks: {
                color: "#495057",
              },
              grid: {
                color: "#ebedef",
              },
            },
            y: {
              ticks: {
                color: "#495057",
              },
              grid: {
                color: "#ebedef",
              },
            },
          },
        };
      },
      applyDarkTheme() {
        this.lineOptions = {
          plugins: {
            legend: {
              labels: {
                color: "#ebedef",
              },
            },
          },
          scales: {
            x: {
              ticks: {
                color: "#ebedef",
              },
              grid: {
                color: "rgba(160, 167, 181, .3)",
              },
            },
            y: {
              ticks: {
                color: "#ebedef",
              },
              grid: {
                color: "rgba(160, 167, 181, .3)",
              },
            },
          },
        };
      },
    },
  };
  </script>
   -->
