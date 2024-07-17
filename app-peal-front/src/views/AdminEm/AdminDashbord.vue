<template>

  <div class="q-px-sm">
    <div class="q-pt-lg q-mx-auto" style="max-width: 1400px;">
      <q-toolbar class="bg-primary text-white shadow-2 rounded-borders" style="height: 72px;">
        <q-btn flat round dense icon="star" />
        <q-toolbar-title>Dashboard</q-toolbar-title>
      </q-toolbar>
    </div>

    <q-card class="q-pa-md q-mx-auto" style="max-width: 1400px;" flat bordered>
      <div class=" q-px-auto ">

        <div class="row justify-center q-gutter-xl ">
          <q-card dark bordered class="bg-grey-9 my-card">
            <q-card-section>
              <div class="text-h6">จำนวนเรื่องที่แจ้งร้องเรียน (เรื่อง)</div>
            </q-card-section>
            <q-separator dark inset />
            <q-card-section class="text-center text-h3">
              {{ data.length }}
            </q-card-section>
          </q-card>
        </div>
        <q-card class="q-mx-auto q-my-lg  bg-white my-card" style="width: 800px;">
      <q-card-section>
        <div class="text-h6">สถิติประเภทเรื่องร้องเรียน (ทั้งหมด)</div>
      </q-card-section>
      <canvas id="myChart"></canvas>
    </q-card>
      </div>
    </q-card>




  </div>

 
</template>

<script>
import Chart from 'chart.js/auto';
import axios from 'axios';
import { ref, computed, onMounted } from 'vue'
import { useUserStore } from "../../store/auth";


export default {
  setup() {
    const userStore = useUserStore();

    const user = computed(() => userStore.useremp);
    const data = ref([]); // Define data as a reactive reference

    const fetchData = () => {
      const user = localStorage.getItem('user'); // Get Token from Local Storage

      if (!user) {
        console.error('Token not found in Local Storage');
        return;
      }

      // Set HTTP request headers with Token
      const headers = {
        Authorization: `Bearer ${user}`,
      };

      axios.get(`${import.meta.env.VITE_API}/employee/appeal/details`, { headers })
        .then(response => {
          data.value = response.data.data; // Assign fetched data to the reactive reference
        })
        .catch(error => {
          console.error('Error fetching data from API:', error);
        });
    };

    const myChart = () => {
      axios.get(`${import.meta.env.VITE_API}/test`)
        .then(response => {
          const recordCounts = response.data.map(item => item.record_count);
          const app_typedetail = response.data.map(item => item.app_typedetail);
          const ctx = document.getElementById('myChart');
          new Chart(ctx, {
            type: 'bar',
            data: {
              labels: app_typedetail,
              datasets: [{
                label: 'จำนวนเอกสารที่ร้องเรียน',
                data: recordCounts,
                backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(255, 159, 64, 0.2)',
                  'rgba(255, 205, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                ],
                borderColor: [
                  'rgb(255, 99, 132)',
                  'rgb(255, 159, 64)',
                  'rgb(255, 205, 86)',
                  'rgb(75, 192, 192)',
                ],
                borderWidth: 2
              }]
            },
            options: {
              scales: {
                y: {
                  beginAtZero: true
                }
              },
              layout: {
                padding: 10
              }
            }
          });
          // Assign fetched data to the reactive reference
        })
        .catch(error => {
          console.error('Error fetching data from API:', error);
        });
    }
    onMounted(myChart)
    // Call fetchData when component is mounted
    onMounted(fetchData);
    return {
      user,
      data,
      fetchData,
    };
  },

}
</script>

<style scoped>
.example-item {
  height: 290px;
  width: 290px;
}
</style>
