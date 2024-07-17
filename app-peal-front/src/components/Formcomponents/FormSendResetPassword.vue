<template>
    <q-ajax-bar color="yellow-7" />
    <div class="tab-content text-center">
        <h4><b>ค้นหาบัญชีของคุณ</b></h4>
    </div>
    <q-card class="q-mx-auto container">
        <br />

        <q-form @submit.prevent="onSubmit" class="q-mx-auto" style="max-width: 400px">
            <div>
                <q-input class="q-mb-md" v-model="email" label="อีเมล*" lazy-rules :rules="emailRules" color="secondary" />
            </div>
            <br />
            <div class="q-gutter-md">
                <q-btn type="submit" size="lg" class="full-width" unelevated rounded color="secondary" :disable="loading">
                    <q-icon name="search" v-if="!loading"/>
                    <span v-if="!loading">ค้นหา</span>
                    <q-spinner v-if="loading" color="white" size="1em" />
                </q-btn>
            </div>
            <br />
        </q-form>
    </q-card>
</template>
  
  
<script>
import { useUserStore } from '../../store/auth';

export default {
    data: () => ({
        loading: false,
        email: '',
        emailRules: [
            v => !!v || 'กรุณาโปรดกรอกอีเมล',
            v => /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(v) || 'กรุณากรอกอีเมลให้ถูกต้อง',
        ],
    }),

    methods: {
        async onSubmit() {
            this.loading = true;
            const userStore = useUserStore();
            await userStore.sendreset(this.email);
            this.loading = false;
        }
    }

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
  