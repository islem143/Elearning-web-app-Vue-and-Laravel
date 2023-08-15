<template>
  <div class="grid">
    <!-- <div class="col-12 lg:col-6 xl:col-3">
      <div class="card mb-0 bg-white">
        <div class="flex justify-content-between mb-3">
          <div>
            <span class="block text-500 font-medium mb-3"
              >Entrolled Students</span
            >
            <div class="text-900 font-medium text-xl">{{ stats.students }}</div>
          </div>
          <div
            class="flex align-items-center justify-content-center bg-blue-100 border-round"
            style="width: 2.5rem; height: 2.5rem"
          >
            <i class="pi pi-users text-blue-500 text-xl"></i>
          </div>
        </div>
   
      </div>
    </div>
    <div class="col-12 lg:col-6 xl:col-3">
      <div class="card mb-0 bg-white">
        <div class="flex justify-content-between mb-3">
          <div>
            <span class="block text-500 font-medium mb-3">Total Modules</span>
            <div class="text-900 font-medium text-xl">{{ stats.modules }}</div>
          </div>
          <div
            class="flex align-items-center justify-content-center bg-orange-100 border-round"
            style="width: 2.5rem; height: 2.5rem"
          >
            <i class="pi pi-book text-orange-500 text-xl"></i>
          </div>
        </div>
        
      </div>
    </div> -->

    <div class="card flex justify-content-center">
      <Chart
        type="pie"
        :data="chartData"
        :options="chartOptions"
        class="w-full md:w-30rem"
      />
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";

const chartData = ref({
  labels: ["Q1", "Q2", "Q3", "Q4"],
  datasets: [
    {
      label: "Sales",
      data: [540, 325, 702, 620],
      backgroundColor: [
        "rgba(255, 159, 64, 0.2)",
        "rgba(75, 192, 192, 0.2)",
        "rgba(54, 162, 235, 0.2)",
        "rgba(153, 102, 255, 0.2)",
      ],
      borderColor: [
        "rgb(255, 159, 64)",
        "rgb(75, 192, 192)",
        "rgb(54, 162, 235)",
        "rgb(153, 102, 255)",
      ],
      borderWidth: 1,
    },
  ],
});
const chartOptions = ref({
  scales: {
    y: {
      beginAtZero: true,
    },
  },
});
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
