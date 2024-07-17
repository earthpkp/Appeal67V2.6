<template>
  <div>
    <div class="q-pt-md q-mx-auto " style="max-width: 1400px;">
      <div class="row q-gutter-sm">
        <q-btn size="16px" style="width: 101px" push color="white" text-color="primary" icon="arrow_back" label="กลับ"
          @click="goBack" />
      </div>
    </div>

    <div class="q-pt-md q-mx-auto" style="max-width: 1400px;">
      <q-toolbar class="bg-primary text-white shadow-2 rounded-borders" style="height: 72px;">
        <q-btn flat round dense icon="campaign" />
        <q-toolbar-title v-if="appealData">
          หมายเลขเรื่อง : {{ app_doc }}
          <q-badge class="q-ml-sm" rounded align="middle" color="secondary" text-color="black">
            <span v-if="appealData.status.status_id == 5">ดำเนินการ</span>
            <span v-else>{{ appealData.status.status_name }}</span>
          </q-badge>
        </q-toolbar-title>
      </q-toolbar>



      <q-card class="q-pa-md q-mx-auto" style="max-width: 1400px;" flat bordered>
        <div v-if="appealData">
          <q-intersection transition="scale" once>
            <q-card class="q-mx-auto inset-shadow-1" style="max-width: 700px;" flat bordered>
              <q-card-section class="bg-grey-1">
                <div class="text-weight-bolder text-center text-h6">รายละเอียด</div>
              </q-card-section>

              <q-separator />

              <q-card-section horizontal>
                <q-card-section class="col-4 text-weight-bolder text-right text-h7">
                  วันที่แจ้ง :
                </q-card-section>
                <q-card-section class="col-8" style="word-wrap: break-word;">
                  {{ formatDate(appealData.created_at) }}
                </q-card-section>
              </q-card-section>

              <q-card-section horizontal>
                <q-card-section class="col-4 text-weight-bolder text-right text-h7">
                  ประเภทเรื่อง :
                </q-card-section>
                <q-card-section class="col-8" style="word-wrap: break-word;">
                  {{ appealData.app_typedetail }}
                </q-card-section>
              </q-card-section>

              <q-card-section horizontal>
                <q-card-section class="col-4 text-weight-bolder text-right text-h7">
                  หัวข้อเรื่อง :
                </q-card-section>
                <q-card-section class="col-8" style="word-wrap: break-word;">
                  {{ appealData.app_headdetail }}
                </q-card-section>
              </q-card-section>

              <q-card-section horizontal>
                <q-card-section class="col-4 text-weight-bolder text-right text-h7">
                  เนื้อหาร้องเรียน :
                </q-card-section>
                <q-card-section class="col-8" style="word-wrap: break-word;">
                  {{ appealData.app_detail }}
                </q-card-section>
              </q-card-section>
              <br>

            </q-card>
            <br>
          </q-intersection>
        </div>
        <div v-else class="q-mt-sm row justify-center">
          <q-spinner color="primary" size="3em" />
        </div>


        <div v-if="appealData && (appealData.status_id == 2)">
          <q-intersection transition="scale" once>
            <q-card class="q-mx-auto inset-shadow-2" style="max-width: 700px;" flat bordered>
              <q-card-section class="bg-grey-1">
                <div class="text-weight-bolder text-center text-h6">การดำเนินการ</div>
              </q-card-section>

              <q-separator />

              <q-card-section horizontal>
                <q-card-section class="col-4 text-weight-bolder text-right text-h7">
                  วันที่รับดำเนินการ :
                </q-card-section>
                <q-card-section class="col-8" style="word-wrap: break-word;">
                  {{ formatDate(appealData.updated_at) }}
                </q-card-section>
              </q-card-section>

              <q-card-section horizontal>
                <q-card-section class="col-4 text-weight-bolder text-right text-h7">
                  หน่วยงานที่รับผิดชอบ :
                </q-card-section>
                <q-card-section class="col-8" style="word-wrap: break-word;">
                  {{ appealData.dep.dep_name }}
                </q-card-section>
              </q-card-section>

              <q-card-section horizontal>
                <q-card-section class="col-4 text-weight-bolder text-right text-h7">
                  การดำเนินการ :
                </q-card-section>
                <q-card-section class="col-8" style="word-wrap: break-word;">
                  เจ้าหน้าที่ได้รับเรื่องและดำเนินการ
                </q-card-section>
              </q-card-section>

              <br>
            </q-card>
            <br>
          </q-intersection>
        </div>
        <div v-else-if="appealData && (appealData.status_id == 3)">
          <q-intersection transition="scale" once>
            <q-card class="q-mx-auto inset-shadow-2" style="max-width: 700px;" flat bordered>
              <q-card-section class="bg-grey-1">
                <div class="text-weight-bolder text-center text-h6">การดำเนินการ</div>
              </q-card-section>

              <q-separator />

              <q-card-section horizontal>
                <q-card-section class="col-4 text-weight-bolder text-right text-h7">
                  วันที่รับดำเนินการ :
                </q-card-section>
                <q-card-section class="col-8" style="word-wrap: break-word;">
                  {{ formatDate(appealData.updated_at) }}
                </q-card-section>
              </q-card-section>

              <q-card-section horizontal>
                <q-card-section class="col-4 text-weight-bolder text-right text-h7">
                  หน่วยงานที่รับผิดชอบ :
                </q-card-section>
                <q-card-section class="col-8" style="word-wrap: break-word;">
                  {{ appealData.dep.dep_name }}
                </q-card-section>
              </q-card-section>

              <q-card-section horizontal>
                <q-card-section class="col-4 text-weight-bolder text-right text-h7">
                  การดำเนินการ :
                </q-card-section>
                <q-card-section class="col-8" style="word-wrap: break-word;">
                  เจ้าหน้าที่ได้รับเรื่องและดำเนินการแล้วเสร็จ
                </q-card-section>
              </q-card-section>

              <br>
            </q-card>
            <br>
          </q-intersection>
        </div>


        <div v-if="appealData && appealData.status_id == 3">
          <q-intersection transition="scale">
            <q-card class="q-mx-auto inset-shadow-3" style="max-width: 700px;" flat bordered>

              <q-card-section class="bg-grey-1">
                <div class="text-weight-bolder text-center text-h6">ผลการดำเนินการ</div>
              </q-card-section>

              <q-separator />

              <div v-if="filteredCommentsstr3.length > 0" v-for="comment in filteredCommentsstr3">
                <q-card-section horizontal>

                  <q-card-section class="col-4 text-weight-bolder text-right text-h7">
                    วันที่แจ้งผลการดำเนินการ :
                  </q-card-section>

                  <q-card-section class="col-8" style="word-wrap: break-word;">
                    {{ formatDate(comment.created_at) }}
                  </q-card-section>
                </q-card-section>
                <q-card-section horizontal>
                  <q-card-section class="col-4 text-weight-bolder text-right text-h7">
                    หน่วยงานที่รับผิดชอบ :
                  </q-card-section>
                  <q-card-section class="col-8" style="word-wrap: break-word;">
                    {{ appealData.dep.dep_name }}
                  </q-card-section>
                </q-card-section>
                <q-card-section horizontal>
                  <q-card-section class="col-4 text-weight-bolder text-right text-h7">
                    ผลการดำเนินการ :
                  </q-card-section>
                  <q-card-section class="col-8" style="word-wrap: break-word;">
                    {{ comment.comment_details }}
                  </q-card-section>
                </q-card-section>
              </div>
              <div v-else>

                <q-card-section horizontal>
                  <q-card-section class="col-4 text-weight-bolder text-right text-h7">
                    ผลการดำเนินการ :
                  </q-card-section>
                  <q-card-section class="col-8" style="word-wrap: break-word;">
                    กำลังรอเจ้าหน้าที่ดำเนินการ
                  </q-card-section>
                </q-card-section>
              </div>
              <br>
            </q-card>
            <br>
          </q-intersection>
        </div>

        <div v-if="appealData && appealData.status_id == 5">
          <q-intersection transition="scale">
            <q-card class="q-mx-auto inset-shadow-4" style="max-width: 700px;" flat bordered>
              <q-card-section class="bg-grey-1">
                <div class="text-weight-bolder text-center text-h6">การดำเนินการ</div>
              </q-card-section>
              <q-separator />
              <div>
                <q-card-section horizontal>
                  <q-card-section class="col-4 text-weight-bolder text-right text-h7">
                    ผลการดำเนินการ :
                  </q-card-section>
                  <q-card-section class="col-8" style="word-wrap: break-word;">
                    กำลังรอเจ้าหน้าที่ดำเนินการ
                  </q-card-section>
                </q-card-section>
              </div>
              <br>
            </q-card>
            <br>
          </q-intersection>
        </div>
      </q-card>

    </div>





  </div>
</template>

<script>
import axios from 'axios';
import { date } from 'quasar'



export default {


  data() {
    return {
      app_doc: this.$route.params.app_doc, // หมายเลขเอกสารจาก URL
      appealData: null, // เก็บข้อมูล appeal ที่ได้จาก API หรือฐานข้อมูล
    };
  },
  mounted() {
    this.loadAppealData();
  },
  computed: {
    filteredComments() {
      if (this.appealData && this.appealData.comments) {
        return this.appealData.comments.filter(comment => comment.comm_status_id === "2");
      }
      return [];
    },
    filteredCommentsstr3() {
      if (this.appealData && this.appealData.comments) {
        return this.appealData.comments.filter(comment => comment.comm_status_id === "3");
      }
      return [];
    },
  },
  methods: {
    loadAppealData() {
      const userToken = localStorage.getItem('user'); // ดึง Token จาก Local Storage

      if (!userToken) {
        // กรณีที่ไม่พบ Token ใน Local Storage
        console.error('ไม่พบ Bearer Token ใน Local Storage');
        return;
      }

      const config = {
        headers: {
          Authorization: `Bearer ${userToken}`
        }
      };

      axios
        .get(`${import.meta.env.VITE_API}/user/appeal/${this.app_doc}`, config)
        .then((response) => {
          this.appealData = response.data.data;
          console.log(this.appealData)
        })
        .catch((error) => {
          console.error('เกิดข้อผิดพลาดในการโหลดข้อมูล:', error);
        });

    },

    formatDate(updatedAt) {
      // สร้างวัตถุ Date จากค่า updatedAt
      const date = new Date(updatedAt);

      // กำหนดรูปแบบวันที่และเวลาเป็นรูปแบบไทย
      const options = {
        year: 'numeric', era: 'short', month: 'long', day: 'numeric', hour: 'numeric',
        minute: 'numeric',
        hour12: false,
      };

      // ใช้ Intl.DateTimeFormat เพื่อรูปแบบวันที่และเวลา
      const formattedDate = new Intl.DateTimeFormat('th-TH', options).format(date);

      return `วันที่ ${formattedDate} น.`;
    },


    goBack() {
      this.$router.push('/user/CheckStatusAppeal');
    },
  },
};
</script>

<style lang="scss" scoped>
.inset-shadow-1 {
  /*  box-shadow:  -10px 0px 10px -10px rgba(30, 197, 57, 0.5),; */
  border-radius: 15px;
  /* กำหนดขอบโค้งให้กับกรอบ */
}

.inset-shadow-2 {
  /*  box-shadow: -10px 0px 10px -10px rgb(236, 234, 105,); */
  border-radius: 15px;
  /* กำหนดขอบโค้งให้กับกรอบ */
}

.inset-shadow-3 {
  /*  box-shadow: -10px 0px 10px -10px rgba(240, 95, 95, 0.5); */
  border-radius: 15px;
  /* กำหนดขอบโค้งให้กับกรอบ */
}

.inset-shadow-4 {
  /*  box-shadow: -10px 0px 10px -10px rgba(240, 95, 95, 0.5); */
  border-radius: 15px;
  /* กำหนดขอบโค้งให้กับกรอบ */
}
</style>