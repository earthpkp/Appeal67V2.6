<template>
    <q-ajax-bar color="yellow-7" />
    <div class="tab-content text-center">
        <h4><b>เข้าสู่ระบบ</b></h4>
    </div>
    <q-card class="q-mx-auto container">

        <q-tabs v-model="tab" dense class="text-grey" active-color="primary" indicator-color="primary" align="justify"
            style="position: relative;">



        </q-tabs>
        <QSeparator />



        
                <q-form @submit.prevent="emplogin" class="q-mx-auto" style="max-width: 400px">
                    <br><br>
                    <div class="input q-pt-lg">
                        <q-input class="q-mb-md" v-model="emailemp" label="อีเมล*" lazy-rules :rules="emailRules" color="secondary"/>
                        <q-input class="q-mb-md" v-model="passwordemp" label="รหัสผ่าน*" color="secondary" :type="isPwd ? 'password' : 'text'"
                            lazy-rules :rules="passwordRules">
                            <template v-slot:append>
                                <q-icon :name="isPwd ? 'visibility_off' : 'visibility'" class="cursor-pointer"
                                    @click="isPwd = !isPwd" />
                            </template>
                        </q-input>



                        <q-btn type="submit" size="lg" class="full-width" unelevated rounded color="secondary"
                            :disable="loading">

                            <span v-if="!loading">เข้าสู่ระบบ</span>
                            <q-icon name="login" v-if="!loading" class="q-ml-md" />

                            <q-spinner v-if="loading" color="white" size="1em" />
                        </q-btn>

                        <br><br>
                        <QSeparator />
                        <div class="row q-pa-md">
                            <router-link to="/" class="q-mr-auto">
                                <q-btn icon="arrow_back" flat color="secondary" label="กลับสู่หน้าหลัก" />
                            </router-link>
                            <router-link to="/sendpassreset" class="q-ml-auto">
                                <q-btn flat color="secondary" label="ลืมรหัสผ่าน ?" />
                            </router-link>
                        </div>

                    </div>
                </q-form>

      
    </q-card>
</template>

<script>
import { QSeparator } from "quasar";
import { useUserStore } from "../../store/auth.js";
export default {

    setup() {
        const userStore = useUserStore();
        return { userStore };
    },
    data: () => ({
        tab: 'tabUser',
        email: '',
        emailuser: '',
        emailemp: '',
        emailRules: [
            v => !!v || 'กรุณาโปรดกรอกอีเมล',
            v => /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(v) || 'กรุณากรอกอีเมลให้ถูกต้อง',
        ],
        password: '',
        passworduser: '',
        passwordemp: '',
        isPwd: true,
        passwordRules: [
            v => !!v || 'กรุณาโปรดกรอกรหัสผ่าน',
            v => (v && v.length >= 6) || 'รหัสผ่านต้องไม่ต่ำกว่า6ตัว',
        ],
        loading: false, // เพิ่มสถานะเริ่มต้นเป็น false
    }),



    methods: {
        async emplogin() {
            this.loading = true; // เปิดสถานะ loading ก่อนทำการเข้าสู่ระบบ
            const form = {
                email: this.emailemp,
                password: this.passwordemp
            };
            await this.userStore.signInEmployee(form);
            this.loading = false; // หลังจากเสร็จสิ้นการเข้าสู่ระบบ ปิดสถานะ loading
        },

        async userlogin() {
            this.loading = true; // เปิดสถานะ loading ก่อนทำการเข้าสู่ระบบ
            const form = {
                email: this.emailuser,
                password: this.passworduser
            };
            await this.userStore.signInUser(form);
            this.loading = false; // หลังจากเสร็จสิ้นการเข้าสู่ระบบ ปิดสถานะ loading
        },
    },
    components: { QSeparator }

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



.input {
    margin-top: -2rem;
}

.larger-text {
    font-size: 18px;
    /* ปรับขนาดตัวหนังสือตามที่คุณต้องการ */
    min-height: 35px;
    /* ปรับขนาดความกว้างของแท็บ */
    margin-top: 1rem;
    /* จัดตำแหน่งข้อความให้อยู่ตรงกลาง */
    font-weight: bold;
}



.tab-content {
    margin-top: 10rem;
    /* ปรับระยะห่างข้างบน */

}
</style>
