<template>
  <div class="q-px-sm">
    <div class="q-pt-lg q-mx-auto" style="max-width: 1400px;">
      <q-toolbar class="bg-primary text-white shadow-2 rounded-borders" style="height: 72px;">
        <q-btn flat round dense icon="star" />
        <q-toolbar-title>ติดตามเรื่องร้องเรียนร้องทุกข์</q-toolbar-title>
      </q-toolbar>
    </div>

    <q-card class="q-pa-md q-mb-lg q-mx-auto" style="max-width: 1400px;" flat bordered>
      <div class=" q-pl-xl q-pr-xl ">
        <div class="q-pa-lg text-h5 text-weight-bold text-center">ตรวจสอบสถานะร้องเรียน-ร้องทุกข์</div>
        <q-separator color="primary" inset class="q-mb-lg q-mx-auto" style="width: 10%; height: 2.2px; " />



        <p class="text-center">ติดตามความก้าวหน้าของเรื่อง โดยใช้รหัส Tack ID ที่ได้รับหลังจากได้ทำการร้องเรียน</p>

        <div v-if="!appealData" class="q-py-xl text-center">
          <q-img src="./../assets/search.svg" style="height: 150px; max-width: 150px" />
        </div>



        <div v-if="appealData" class="q-my-lg">
          <q-intersection transition="scale">
            <q-card class="q-mx-auto inset-box" style="max-width: 700px;" flat bordered>
              <q-card-section class="bg-primary">
                <div class=" text-center text-h6 text-white">การดำเนินการ</div>
              </q-card-section>

              <q-separator />
              <q-card-section horizontal>
                <q-card-section class="col-4 text-weight-bolder text-right text-h7">
                  เลขเอกสาร :
                </q-card-section>
                <q-card-section class="col-8" style="word-wrap: break-word;">
                  {{ appealData.app_doc }}
                </q-card-section>
              </q-card-section>
              <q-card-section horizontal>
                <q-card-section class="col-4 text-weight-bolder text-right text-h7">
                  สถานะ :
                </q-card-section>
                <q-card-section class="col-8" :class="{
          'text-secondary': appealData.status.status_id == 1,
          'text-primary': appealData.status.status_id == 2 || appealData.status.status_id == 5,
          'text-red-4': appealData.status.status_id == 3 || appealData.status.status_id == 4
        }" style="word-wrap: break-word;">
                  {{ appealData.status.status_id == 5 ? 'กำลังดำเนินการ' : appealData.status.status_name }}
                </q-card-section>




              </q-card-section>

              <div v-if="appealData && (appealData.status_id == 2 || appealData.status_id == 5)">
                <q-card-section horizontal>
                  <q-card-section class="col-4 text-weight-bolder text-right text-h7">
                    การดำเนินการ :
                  </q-card-section>
                  <q-card-section class="col-8" style="word-wrap: break-word;">
                    เจ้าหน้าที่ได้รับเรื่องและดำเนินการอยู่
                  </q-card-section>
                </q-card-section>
              </div>



              <div v-else-if="appealData.status_id == 3">
                <div v-for="comment in appealData.comments">
                  <template v-if="comment.comm_status_id == '3'">
                    <q-card-section horizontal>
                      <q-card-section class="col-4 text-weight-bolder text-right text-h7">
                        ผลการดำเนินการ :
                      </q-card-section>
                      <q-card-section class="col-8" style="word-wrap: break-word;">
                        {{ comment.comment_details }}
                      </q-card-section>
                    </q-card-section>
                  </template>
                </div>
              </div>

              <div v-else-if="appealData.status_id == 4">
                <q-card-section horizontal>
                  <q-card-section class="col-4 text-weight-bolder text-right text-h7">
                    ผลการดำเนินการ :
                  </q-card-section>
                  <q-card-section class="col-8" style="word-wrap: break-word;">
                    เรื่องร้องเรียนของคุณถูก "ปฏิเสธ" การรับ
                  </q-card-section>
                </q-card-section>
              </div>



              <div v-else>
                <q-card-section horizontal>
                  <q-card-section class="col-4 text-weight-bolder text-right text-h7">
                    การดำเนินการ :
                  </q-card-section>
                  <q-card-section class="col-8" style="word-wrap: break-word;">
                    เรื่องร้องเรียนอยู่ระหว่างการรับเรื่อง
                  </q-card-section>
                </q-card-section>
              </div>

              <br>

            </q-card>
            <br>
          </q-intersection>
        </div>

        <q-form ref="myform" @submit.prevent="Search_appeal">
          <div class="row text-bold row items-center q-gutter-sm q-mt-sm ">
            <div class="col-sm-2 ">
              <p style="font-size: 14px; text-align: right;"> <span class="red-asterisk"></span>
              </p>
            </div>
            <div class="col-sm-2 ">
              <p style="font-size: 14px; text-align: right;"> รหัสติดตามเรื่องร้องเรียน-ร้องทุกข์ (Tack ID) : <span
                  class="red-asterisk">*</span>
              </p>
            </div>
            <div class="col-sm-4 col-12 ">
              <q-input outlined hint="ตัวอย่าง (อต.123456) " type="text" v-model="tack_id" :rules="tack_id_Rules" />
            </div>
          </div>
          <div class="row text-bold row items-center q-gutter-sm q-mt-sm ">
            <div class="col-sm-2 ">
            </div>
            <div class="col-sm-2 ">
              <p style="font-size: 14px; text-align: right;"> หมายเลขบัตรประชาชน : <span class="red-asterisk">*</span>
              </p>
            </div>
            <div class="col-sm-4 col-12 ">
              <q-input outlined hint="โปรดระบุเลขบัตรประชาชน" type="text" v-model="card_id"
                placeholder="#-####-#####-##-#" mask="#-####-#####-##-#" :rules="card_id_Rules" />
            </div>
          </div>
          <q-stepper-navigation>
            <div class=" row justify-center q-pb-lg">
              <div class="col-12 col-sm-3 col-md-2 col-lg-2">
                <div class="text-center">
                  <q-btn type="submit" class="full-width" color="primary" size="18px" label="ค้นหา" />
                  <q-inner-loading :showing="loading" color="primary" label="กำลังโหลดข้อมูล" label-class="text-teal"
                    label-style="font-size: 2em" />
                </div>
              </div>
            </div>
          </q-stepper-navigation>
        </q-form>
      </div>
    </q-card>




  </div>


</template>


<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      tack_id: '',
      card_id: '',
      loading: false,
      appealData: null
    }
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
    async Search_appeal() {
      const form = {
        app_doc: this.tack_id,
        app_cardID: this.card_id
      };
      try {
        /*  Swal.fire({
           title: 'กำลังดำเนินการ',
           text: 'กรุณารอสักครู่...',
           didOpen: () => {
             Swal.showLoading();
           }
         }); */
        const response = await axios.post(`${import.meta.env.VITE_API}/user/getcode`, form);
        // หลังจากลงทะเบียนสำเร็จ
        if (response.status === 200) {

          this.appealData = response.data.appeal;
          this.tack_id = ""
          this.card_id = ""
          this.$refs.myform.reset();

          Swal.close();
        }
      } catch (error) {
        if (error.response.status === 404) {
          this.appealData = null;
          this.tack_id = ""
          this.card_id = ""
          this.$refs.myform.reset();
          await Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาด',
            text: error.response.data.message,
          });


        }
      }
    }
  },

  computed: {
    tack_id_Rules() {
      return [
        v => !!v || 'กรุณากรอก Tack ID (อต.xxxxxx)',
        v => /^อต\.[0-9]{6}$/i.test(v) || 'Tack ID ต้องขึ้นต้นด้วย "อต." ตามด้วยเลข 6 หลัก'
      ]
    },
    card_id_Rules() {
      return [
        v => !!v || 'โปรดกรอกเลขบัตรประชาชน',
        v => /^[0-9]{1}-[0-9]{4}-[0-9]{5}-[0-9]{2}-[0-9]{1}$/.test(v) || 'เลขบัตรประชาชนต้องมี 13 หลักเป็นตัวเลขเท่านั้น',
        v => {
          const id = v.replace(/-/g, ''); // ลบขีด (-) ออกจากเลขบัตรประชาชน
          if (id.length !== 13) return 'เลขบัตรประชาชนต้องมี 13 หลัก';

          // เพิ่มโค้ดตรวจสอบตามสูตร
          let sum = 0;
          for (let i = 0; i < 12; i++) {
            sum += parseFloat(id.charAt(i)) * (13 - i);
          }

          if ((11 - (sum % 11)) % 10 !== parseFloat(id.charAt(12))) return 'เลขบัตรประชาชนไม่ถูกต้อง';

          return true;
        }
      ]
    }
  }
}
</script>

<style lang="scss" scoped>
.inset-box {
  /*  box-shadow:  -10px 0px 10px -10px rgba(30, 197, 57, 0.5),; */
  border-radius: 15px;
  /* กำหนดขอบโค้งให้กับกรอบ */
}
</style>
