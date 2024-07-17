<template>
    <q-ajax-bar  color="yellow-7"/>
    <div class="tab-content text-center">
        <h4><b>ลงทะเบียน</b></h4>
    </div>
    <q-card class="q-mx-auto container">
        <br />


        <q-form @submit.prevent="onSubmit" class="q-mx-auto" style="max-width: 400px">
            <div>
                <q-input class="q-mb-md" v-model="email" label="อีเมล*" lazy-rules :rules="emailRules" color="secondary" />
                <q-input class="q-mb-md" v-model="password" label="รหัสผ่าน*" :type="isPwd ? 'password' : 'text'" lazy-rules
                    :rules="[...allPasswordRules]" color="secondary">
                    <template v-slot:append>
                        <q-icon :name="isPwd ? 'visibility_off' : 'visibility'" class="cursor-pointer"
                            @click="isPwd = !isPwd" />
                    </template>
                </q-input>
                <q-input class="q-mb-md" v-model="passwordconfirm" label="ยืนยันรหัสผ่าน*"
                    :type="isPwd ? 'password' : 'text'" lazy-rules :rules="[...allPasswordRules, checkPasswordConfirmation]"
                    color="secondary">
                    <template v-slot:append>
                        <q-icon :name="isPwd ? 'visibility_off' : 'visibility'" class="cursor-pointer"
                            @click="isPwd = !isPwd" />
                    </template>
                </q-input>

                <q-toggle v-model="accept" checked-icon="check" unchecked-icon="clear" size="lg"
                    color="secondary"></q-toggle>
                ข้าพเจ้าได้ตรวจสอบและยอมรับเงื่อนไข <a href="#" @click="medium = true">ข้อตกลง
                    หลักเกณฑ์การรับเรื่องร้องเรียน</a>
            </div>
            <br />

            <div class="q-gutter-md">
                <q-btn type="submit" size="lg" class="full-width" unelevated rounded color="secondary"
                    :disable="!accept || loading">
                    <span v-if="!loading">ลงทะเบียน</span>
                    <q-icon name="login" v-if="!loading" class="q-ml-md" />
                    <q-spinner v-if="loading" color="white" size="1em" />
                </q-btn>
            </div>

            <!-- <div class="title-register text-center">
                มีบัญชีอยู่แล้ว?
                <router-link to="/login">เข้าสู่ระบบ.</router-link>
            </div> -->
            <br />
            <q-separator inset />
            <div class="row q-gutter-xl q-mb-md">
                <router-link to="/" class="q-mr-auto">
                    <q-btn icon="arrow_back" flat color="secondary" label="กลับสู่หน้าหลัก" />
                </router-link>
                <router-link to="/login" class="q-ml-auto">
                    <q-btn flat color="secondary" label="เข้าสู่ระบบ" icon-right="arrow_forward" />
                </router-link>
            </div>
            <br />

            <q-dialog v-model="medium" position="top">
                <q-card style="width: 700px; max-width: 80vw; margin-top: 30px;">
                    <q-card-section>
                        <div class="text-h6">ข้อตกลงเบื้องต้นในการใช้งานระบบร้องเรียนร้องทุกข์ กรมอุตุนิยมวิทยา</div>
                    </q-card-section>
                    <q-card-section class="q-pt-none">
                        Click/Tap on the backdrop.
                    </q-card-section>
                    <q-card-actions align="right" class="bg-white text-teal">
                        <q-btn flat label="ปิด" v-close-popup />
                    </q-card-actions>
                </q-card>
            </q-dialog>
        </q-form>
    </q-card>
</template>
  
  
<script>
import Swal from 'sweetalert2';
import { QSeparator } from "quasar";
import { useUserStore } from '../../store/auth';


export default {
    data: () => ({
        medium: false,
        email: '',
        emailRules: [
            v => !!v || 'กรุณาโปรดกรอกอีเมล',
            v => /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(v) || 'กรุณากรอกอีเมลให้ถูกต้อง',
        ],
        password: '',
        passwordconfirm: '',
        isPwd: true,
        accept: false,
        loading: false, // เพิ่มสถานะ loading เริ่มต้นเป็น false
    }),
    methods: {
        checkPasswordConfirmation(v) {
            return (
                (!!v && v === this.password) ||
                "รหัสผ่านไม่ตรงกัน"
            );
        },
        async onSubmit() {
            if (!this.accept) {
                await Swal.fire({
                    icon: 'warning',
                    title: 'คำเตือน',
                    text: 'กรุณายอมรับข้อตกลงการใช้งาน',
                    confirmButtonText: 'ตกลง',
                });
            } else {
                this.loading = true;
                const userStore = useUserStore();

                try {
                    await userStore.register(this.email, this.password);
                    // ลงทะเบียนสำเร็จ
                    // คุณอาจต้องเพิ่มการแสดงข้อความหรือกระทำเพิ่มเติมที่นี่
                } finally {
                    this.loading = false;
                }
            }
        },
    },
    computed: {
        allPasswordRules() {
            return [
                (v) => !!v || "กรุณาโปรดกรอกรหัสผ่าน",
                (v) => (v && v.length >= 8) || "รหัสผ่านต้องไม่ต่ำกว่า8ตัว",
            ];
        },
    },
}
</script>
  
<style scoped>
.container {
    margin-top: 40px;
    max-width: 600px;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 16px 24px rgba(0, 0, 0, 0.1)
}



.tab-content {
    margin-top: 10rem;
    /* ปรับระยะห่างข้างบน */

}



.title-register {
    margin-top: 1.5rem;
    /* ปรับระยะห่างข้างบน */
    margin-right: 0rem;

}
</style>
  