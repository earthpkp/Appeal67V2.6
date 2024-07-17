<template>
    <div class="q-pt-lg q-mx-auto" style="max-width: 1400px ">

        <q-toolbar class="bg-primary text-white shadow-2 rounded-borders">
            <q-btn flat round dense icon="star" />
            <q-toolbar-title>ตรวจสอบสถานะเรื่องร้องเรียน </q-toolbar-title>




            <div class="q-my-sm" style="max-width: 200px;">
                <q-input rounded outlined debounce="300" v-model="filter" bg-color="white" label="เลขที่เอกสาร">
                    <template v-slot:append>
                        <q-icon name="search" />
                    </template>
                </q-input>
            </div>



        </q-toolbar>

    </div>







    <!-- <div class="q-pa-md">
        <div class="q-gutter-y-md" style="max-width: 600px">
            <q-card>
                <q-tabs v-model="tab" dense class="text-grey" active-color="primary" indicator-color="primary"
                    align="justify" narrow-indicator>
                    <q-tab name="mails" label="Mails" />
                    <q-tab name="alarms" label="Alarms" />
                    <q-tab name="movies" label="Movies" />
                </q-tabs>

                <q-separator />

                <q-tab-panels v-model="tab" animated>
                    <q-tab-panel name="mails">
                        <div class="text-h6">Mails</div>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    </q-tab-panel>

                    <q-tab-panel name="alarms">
                        <div class="text-h6">Alarms</div>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    </q-tab-panel>

                    <q-tab-panel name="movies">
                        <div class="text-h6">Movies</div>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    </q-tab-panel>
                </q-tab-panels>
            </q-card>

            <q-card>
                <q-tab-panels v-model="tab" animated>
                    <q-tab-panel name="mails">
                        <div class="text-h6">Mails</div>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    </q-tab-panel>

                    <q-tab-panel name="alarms">
                        <div class="text-h6">Alarms</div>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    </q-tab-panel>

                    <q-tab-panel name="movies">
                        <div class="text-h6">Movies</div>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    </q-tab-panel>
                </q-tab-panels>

                <q-separator />

                <q-tabs v-model="tab" dense :class="$q.dark.isActive ? 'bg-grey-9' : 'bg-grey-3'" align="justify"
                    narrow-indicator>
                    <q-tab name="mails" label="Mails" />
                    <q-tab name="alarms" label="Alarms" />
                    <q-tab name="movies" label="Movies" />
                </q-tabs>
            </q-card>
        </div>
    </div> -->





    <div class="q-mx-auto" style="max-width: 1400px">
        <q-card>
            <q-tabs v-model="tab" dense class="text-grey" active-color="primary" indicator-color="primary" align="justify">
    <q-tab name="status1" class="q-py-sm q-pr-md">
        <div class="text-bold">
            รอรับเรื่อง
        </div>
    </q-tab>
    <q-tab name="status2">
        <div class="text-bold">
            ดำเนินการ
        </div>
    </q-tab>
    <q-tab name="status3">
        <div class="text-bold">
            เสร็จสิ้น
        </div>
    </q-tab>
</q-tabs>

            <q-separator />

            <q-tab-panels v-model="tab" animated>

                <q-tab-panel name="status1" class="q-pa-none">
                    <q-table class="q-mx-auto" round :rows="filteredRows1" :columns="columns" :filter="filter"
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
                                <q-td key="app_typedetail" :props="props">

                                    {{ props.row.app_typedetail }}

                                </q-td>

                                <q-td key="app_headdetail" :props="props">

                                    {{ props.row.app_headdetail }}

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
                                <q-td key="app_typedetail" :props="props">

                                    {{ props.row.app_typedetail }}

                                </q-td>

                                <q-td key="app_headdetail" :props="props">

                                    {{ props.row.app_headdetail }}

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
                                <q-td key="app_typedetail" :props="props">

                                    {{ props.row.app_typedetail }}

                                </q-td>

                                <q-td key="app_headdetail" :props="props">

                                    {{ props.row.app_headdetail }}

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


    <div class="q-my-sm">






        <!-- <q-table :grid="$q.screen.xs" class="q-mx-auto" round :rows="rows" :columns="columns" :filter="filter" row-key="name"
        :loading="loading" no-data-label="ไม่มีข้อมูลการร้องเรียน" no-results-label="ไม่พบข้อมูลการร้องเรียน" color="primary"
        style="max-width: 1400px;"> -->




    </div>
</template>
  
  
<script>
import axios from 'axios';
import { date } from 'quasar'
import { ref } from 'vue'


const tab = ref('');

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
        sortable: true
    },

    {
        name: 'app_typedetail',
        required: true,
        label: 'ประเภท',
        align: 'center',
        field: row => row.app_typedetail,
        format: val => `${val}`,
        sortable: true
    },

    {
        name: 'app_headdetail',
        required: true,
        label: 'หัวข้อ',
        align: 'center',
        field: row => row.app_headdetail,
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
        sortable: true
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
            tab: ref('status1'),
            splitterModel: ref(20),
            rows: [],
            filter: '',
            loading: false // เพิ่มตัวแปร loading เพื่อควบคุมสถานะ loading

        }

    },

    computed: {
        filteredRows3() {
            return this.rows.filter(row => row.status.status_id === '3');
        },
        filteredRows2() {
            return this.rows.filter(row => row.status.status_id === '2');
        },
        filteredRows1() {
            return this.rows.filter(row => row.status.status_id === '1');
        }
    },

    created() {
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

            axios.get('http://192.168.168.115:8002/api/employee/appeal/details', { headers })
                .then(response => {
                    this.rows = response.data.data; // นำข้อมูลจาก API มาใส่ใน rows
                    this.loading = false; // หยุดโหลดข้อมูลเมื่อโหลดเสร็จสมบูรณ์
                })
                .catch(error => {
                    console.error('เกิดข้อผิดพลาดในการดึงข้อมูลจาก API:', error);
                    this.loading = false; // หยุดโหลดข้อมูลเมื่อเกิดข้อผิดพลาด
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
            this.$router.push(`/user/CheckStatusAppeal/view=${row.app_doc}`);
        }


    }
};
</script>
  
<style lang="scss">
tr:hover {
    cursor: pointer;
}


/* .app-doc-cell:hover {
    cursor: pointer;
  } */
</style>
  