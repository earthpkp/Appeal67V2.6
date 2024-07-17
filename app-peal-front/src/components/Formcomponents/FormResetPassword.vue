<template>
    <q-ajax-bar  color="yellow-7"/>
    <div class="tab-content text-center">
        <h4><b>รีเซ็ทรหัสผ่าน</b></h4>
    </div>
    <q-card class="q-mx-auto container">
        <br />


        <q-form @submit.prevent="onSubmit" class="q-mx-auto" style="max-width: 400px">
            <div>
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
            </div>
            <br />

            <div class="q-gutter-md">
                <q-btn type="submit" size="lg" class="full-width" unelevated rounded color="secondary">
                    <span>รีเซ็ทรหัสผ่าน</span>
                    <q-icon name="login" class="q-ml-md" />
                </q-btn>
            </div>

            <!-- <div class="title-register text-center">
                มีบัญชีอยู่แล้ว?
                <router-link to="/login">เข้าสู่ระบบ.</router-link>
            </div> -->
            <br />
        </q-form>
    </q-card>
</template>
  
  
<script>
import { useUserStore } from '../../store/auth';

export default {
    data: () => ({
        medium: false,
        password: '',
        passwordconfirm: '',
        isPwd: true,
    }),
    methods: {
        checkPasswordConfirmation(v) {
            return (
                (!!v && v === this.password) ||
                "รหัสผ่านไม่ตรงกัน"
            );
        },
        async onSubmit() {
            const token = this.$route.params.token;
            const userStore = useUserStore();
            await userStore.resetpassword(this.password,token);
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
  