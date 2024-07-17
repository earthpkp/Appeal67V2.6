<template>
    <div class="text-center">
        <q-img src="./../../assets/tmdlogo.png" style="height: 170px; max-width: 170px" />
        <h4 style="margin-top: 1rem; font-weight: 600;">ระบบร้องเรียนร้องทุกข์</h4>
        <h5 style="margin-top : -2rem; font-weight: 500;">กรมอุตุนิยมวิทยา</h5>
    </div>


    <div class="row q-pt-xl row justify-center">

        <q-card class="my-card-login text-center q-mx-auto q-pa-md q-mb-sm" style="height: 250px; max-width: 400px; ">
            <q-card-section>
                <q-avatar color="primary" text-color="white" style="transform: translateY(-80%);" size="110px">
                    <q-icon name="campaign" />
                </q-avatar>
            </q-card-section>
            <q-card-section>
                <div class="text-h6 q-mb-md" style="margin-top: -6rem;">แจ้งร้องเรียนร้องทุกข์ / ติดตามเรื่อง</div>
                <router-link to="/user/Appeal">
                    <q-btn size="lg" outline rounded color="primary" icon-right="arrow_right_alt" label="แจ้ง / ติดตาม" />



                </router-link>
            </q-card-section>
        </q-card>


        <q-card class="my-card-register text-center q-mx-auto q-pa-md q-mb-sm "
            style="height: 250px; max-width: 400px; ">
            <q-card-section>
                <q-avatar color="secondary" text-color="white" style="transform: translateY(-80%);" size="110px">
                    <q-icon name="login" />
                </q-avatar>
            </q-card-section>
            <q-card-section>
                <div class="text-h6 q-mb-md" style="margin-top: -6rem;">สำหรับเจ้าหน้าที่</div>
                <router-link to="/login"><q-btn size="lg" outline rounded color="secondary" icon-right="arrow_right_alt"
                        label="เข้าสู่ระบบ" /></router-link>
            </q-card-section>
        </q-card>


        <q-card class="my-card-doc text-center text-center q-mx-auto q-pa-md q-mb-sm "
            style="height: 250px; max-width: 400px; ">
            <q-card-section>
                <q-avatar color="accent" text-color="white" style="transform: translateY(-80%);" size="110px">
                    <q-icon name="library_books" />
                </q-avatar>
            </q-card-section>
            <q-card-section>
                <div class="text-h6 q-mb-md" style="margin-top: -6rem;">คู่มือระบบร้องเรียนร้องทุกข์</div>
                <q-btn size="lg" outline rounded color="accent" icon-right="arrow_right_alt" label="คู่มือระบบ" href="/"
                    target="_blank" />
            </q-card-section>
        </q-card>
    </div>

    <div class="text-center">
        <h5 style="line-height: 0.1 ">ติดต่อสอบถามข้อมูลได้ที่</h5>
        <p style="line-height: 0.1">กลุ่มการเจ้าหน้าที่ โทร.0-2399-4023</p>
        <pre><h6 >กรมอุตุนิยมวิทยา    |    <q-icon name="language" />www.tmd.go.th    |    <q-icon name="phone" />0-2399-4566</h6></pre>
    </div>


</template>

<script>
export default {

}
</script>

<style lang="sass" scoped>
.my-card-login , .my-card-register, .my-card-doc
  width: 100%
  max-width: 500px
  margin: 1rem
  border-radius: 20px
  box-shadow: 0 16px 24px rgba(0, 0, 0, 0.1)
  

</style>

<style scoped>
@media only screen and (max-width: 1516px) {

    .my-card-login,
    .my-card-register {
        margin-bottom: 4rem;
    }
}
</style>