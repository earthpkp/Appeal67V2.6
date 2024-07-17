<template>
    <div class="q-px-sm q-py-lg">
    <div class="q-mx-auto" style="max-width: 1400px ">

        <q-toolbar class="bg-primary text-white shadow-2 rounded-borders">
            <q-btn flat round dense icon="star" />
            <q-toolbar-title>ตรวจสอบสถานะเรื่องร้องเรียน  </q-toolbar-title>




            <div class="q-my-sm" style="max-width: 200px;">
                <q-input rounded outlined debounce="300" v-model="filter" bg-color="white" label="&nbsp;&nbsp;&nbsp;&nbsp;ค้นหา">
                    <template v-slot:append>
                        <q-icon name="search" />
                    </template>
                </q-input>
            </div>



        </q-toolbar>

    </div>




    <div class="q-mx-auto" style="max-width: 1400px">
        <q-card>
            <q-tabs v-model="tab" dense class="text-grey" active-color="primary" indicator-color="primary" align="justify">

                <q-tab name="status2" class="q-py-sm q-pr-md">
                    <div class="text-bold q-py-xs ">
                        ดำเนินการ
                        <q-badge align="top" color="red" v-show="filteredRows2.length > 0">{{ filteredRows2.length }}</q-badge>
                    </div>
                </q-tab>
                <q-tab name="status3">
                    <div class="text-bold">
                        ปิดงาน
                    </div>
                </q-tab>
            </q-tabs>

            <q-separator />

            <q-tab-panels v-model="tab" animated>

                <q-tab-panel name="status2" class="q-pa-none">
                    <q-table class="q-mx-auto" round :rows="filteredRows2" :columns="columns" :filter="filter"
                        row-key="name" :loading="loading" no-data-label="ไม่มีข้อมูลการร้องเรียน"
                        no-results-label="ไม่พบข้อมูลการร้องเรียน" color="primary" :rows-per-page-options="[10]"
                        rows-per-page-label="จำนวน" row loading-label="กำลังโหลดข้อมูล" style="max-width: 1400px;">

                        <template v-slot:no-data="{ icon, message, filter }">
                            <div class="full-width row flex-center text-accent q-gutter-sm" style="font-size: 20px;">
                                <span>
                                    <b>{{ message }}</b>
                                </span>
                                <q-icon size="1.3em" :name="filter ? 'search' : icon" />
                            </div>
                        </template>

                        <template v-slot:header="props">
                            <q-tr :props="props">
                                <q-th v-for="col in props.cols" :key="col.name" :props="props" style="font-size: 16px;">
                                    <strong>{{ col.label }}</strong>
                                </q-th>
                            </q-tr>
                        </template>

                        <template v-slot:body="props">

                            <q-tr :props="props" @click="onRowClick(props.row)">
                                <q-td key="app_doc" :props="props">

                                    {{ props.row.app_doc }}

                                </q-td>
                                <q-td key="app_headdetail" :props="props"
                                    style="white-space: pre-line; overflow-wrap: break-word;  min-width: 175px; max-width: 175px;">


                                    {{ props.row.app_headdetail }}

                                </q-td>
                                <q-td key="app_typedetail" :props="props"
                                    style="white-space: pre-line; overflow-wrap: break-word; min-width: 175px; max-width: 175px;">

                                    {{ props.row.app_typedetail }}

                                </q-td>

                                <q-td key="app_status" :props="props">
                                    <q-chip :color="getStatusColor(props.row.status.status_id)" text-color="white"
                                        size="md">
                                        {{ props.row.status.status_name }}
                                    </q-chip>
                                </q-td>

                                <q-td key="updated_at" :props="props">
                                    {{ formatDate(props.row.updated_at) }}
                                </q-td>

                                <q-td key="btn" :props="props">
                                    <q-btn size="14px" padding="xs lg" push color="white" text-color="primary" label=""
                                        icon="search" />
                                </q-td>
                            </q-tr>

                        </template>

                    </q-table>
                </q-tab-panel>

                <q-tab-panel name="status3" class="q-pa-none">
                    <q-table class="q-mx-auto" round :rows="filteredRows3" :columns="columns" :filter="filter"
                        row-key="name" :loading="loading" no-data-label="ไม่มีข้อมูลการร้องเรียน"
                        no-results-label="ไม่พบข้อมูลการร้องเรียน" color="primary" :rows-per-page-options="[10]"
                        rows-per-page-label="จำนวน" row loading-label="กำลังโหลดข้อมูล" style="max-width: 1400px;">

                        <template v-slot:no-data="{ icon, message, filter }">
                            <div class="full-width row flex-center text-accent q-gutter-sm" style="font-size: 20px;">
                                <span>
                                    <b>{{ message }}</b>
                                </span>
                                <q-icon size="1.3em" :name="filter ? 'search' : icon" />
                            </div>
                        </template>

                        <template v-slot:header="props">
                            <q-tr :props="props">
                                <q-th v-for="col in props.cols" :key="col.name" :props="props" style="font-size: 16px;">
                                    <strong>{{ col.label }}</strong>
                                </q-th>
                            </q-tr>
                        </template>

                        <template v-slot:body="props">

                            <q-tr :props="props" @click="onRowClick(props.row)">
                                <q-td key="app_doc" :props="props">

                                    {{ props.row.app_doc }}

                                </q-td>
                                <q-td key="app_headdetail" :props="props"
                                    style="white-space: pre-line; overflow-wrap: break-word;  min-width: 175px; max-width: 175px;">


                                    {{ props.row.app_headdetail }}

                                </q-td>
                                <q-td key="app_typedetail" :props="props"
                                    style="white-space: pre-line; overflow-wrap: break-word; min-width: 175px; max-width: 175px;">

                                    {{ props.row.app_typedetail }}

                                </q-td>

                                <q-td key="app_status" :props="props">
                                    <q-chip :color="getStatusColor(props.row.status.status_id)" text-color="white"
                                        size="md">
                                        {{ props.row.status.status_name }}
                                    </q-chip>
                                </q-td>

                                <q-td key="updated_at" :props="props">
                                    {{ formatDate(props.row.updated_at) }}
                                </q-td>

                                <q-td key="btn" :props="props">
                                    <q-btn size="14px" padding="xs lg" push color="white" text-color="primary" label=""
                                        icon="search" />
                                </q-td>
                            </q-tr>

                        </template>

                    </q-table>

                </q-tab-panel>
            </q-tab-panels>
        </q-card>
    </div>

</div>
</template>
  
  
<script>
import axios from 'axios';
import { date } from 'quasar'
import { ref } from 'vue'
import { useUserStore } from "../../store/auth.js";


const columns = [


    /* {
      name: 'app_id',
      required: true,
      label: 'id',
      align: 'center',
      field: row => row.app_id,
      format: val => `${val}`,
      sortable: true
    }, */

    {
        name: 'app_doc',
        required: true,
        label: 'เลขที่เอกสาร',
        align: 'center',
        field: row => row.app_doc,
        format: val => `${val}`,
        sortable: false
    },

    {
        name: 'app_headdetail',
        required: true,
        label: 'เรื่อง',
        align: 'left',
        field: row => row.app_headdetail,
        format: val => `${val}`,
        sortable: false
    },

    {
        name: 'app_typedetail',
        required: true,
        label: 'ประเภท',
        align: 'left',
        field: row => row.app_typedetail,
        format: val => `${val}`,
        sortable: true
    },

   
    {
        name: 'app_status',
        required: true,
        label: 'สถานะ',
        align: 'center',
        field: row => row.status.status_name,
        format: val => `${val}`,
        sortable: false
    },
    {
        name: 'updated_at',
        required: true,
        label: 'วันที่',
        align: 'center',
        field: row => row.updated_at,
        format: val => `${val}`,
        sortable: true
    },
    /*  {
       name: 'user_id',
       required: true,
       label: 'user_id',
       align: 'center',
       field: row => row.user_id,
       format: val => `${val}`,
       sortable: true
     }, */

    {
        name: 'btn',
        required: true,
        label: 'ตรวจสอบ',
        align: 'center',
        sortable: false

    },
];

export default {
    data() {
        return {
            columns,
            tab: ref('status2'),
            splitterModel: ref(20),
            rows: [],
            filter: '',
            loading: false, // เพิ่มตัวแปร loading เพื่อควบคุมสถานะ loading
            userStore: useUserStore()
        }

    },
    watch: {
        // Watch for changes in the 'tab' variable
        tab(newValue) {
            // Update local storage with the new value
            localStorage.setItem('tab', newValue);
        },
    },
    computed: {
        filteredRows3() {
            return this.rows.filter(row => row.status.status_id === '3');
        },
        filteredRows2() {
            return this.rows.filter(row => row.status.status_id === '2');
        },
    },

    created() {
        const storedTab = localStorage.getItem('tab');
        this.tab = storedTab || 'status2';
        this.fetchData();
    },
    methods: {

        fetchData() {
            this.loading = true; // เริ่มโหลดข้อมูล
            const user = localStorage.getItem('user'); // ดึง Token จาก Local Storage

            if (!user) {
                console.error('Token ไม่พบใน Local Storage');
                this.loading = false; // หยุดโหลดข้อมูล
                return;
            }

            // กำหนด Header ในคำขอ HTTP ด้วย Token
            const headers = {
                Authorization: `Bearer ${user}`,
            };

            axios
                .get(`${import.meta.env.VITE_API}/employee/appeal/details`, { headers })
                .then((response) => {
                    // กรองข้อมูลที่มี dep_id เท่ากับ department_id ใน user
                    this.rows = response.data.data.filter((row) => row.dep_id === this.userStore.user?.department_id);
                    this.loading = false;
                })
                .catch((error) => {
                    console.error('เกิดข้อผิดพลาดในการดึงข้อมูลจาก API:', error);
                    this.loading = false;
                });
        },

        getStatusColor(statusId) {
            switch (statusId) {
                case '1':
                    return 'secondary';
                case '2':
                    return 'primary';
                case '3':
                    return 'red-4';
                default:
                    return 'grey'; // สีเริ่มต้นหรือสีอื่น ๆ ตามที่คุณต้องการ
            }
        },


        formatDate(updatedAt) {
            // Format the date using date.formatDate
            const buddhistYear = date.addToDate(updatedAt, { years: 543 });
            return date.formatDate(buddhistYear, 'DD/MM/YYYY');
        },

        /*  formatTimeAgo(updatedAt) {
           // Format the date as time ago using date.formatRelative
           return date.formatRelative(new Date(updatedAt));
         }, */

        onRowClick(row) {
            /* alert(`${row.app_id} อย่าคลิก`); */
            this.$router.push(`/Employee/CheckStatusAppeal/view=${row.app_id}`);
        }


    }
};
</script>
  
<style lang="scss">
/* tr:hover {
    cursor: pointer;
}
 */

/* .app-doc-cell:hover {
    cursor: pointer;
  } */
</style>
  