<template>
  <div>
    <q-layout view="hHh LpR fff" style="background-color: #f5f5f5">
      <q-ajax-bar color="teal-7" />





      <div class="nav " style=" z-index: 999; ">
        <div class="container ">
          <div class="navcon shadow-up-">
            <q-toolbar>

              <q-btn :ripple="false" color="transparent" no-caps flat to="/">
                <img src="./../../assets/home2.svg" />
              </q-btn>
              <q-space />

              <q-item clickable v-ripple to="/user/appeal" v-if="$q.screen.width > 685">
                <q-item-section> แจ้งเรื่อง </q-item-section>
              </q-item>



              <q-item clickable v-ripple to="/user/CheckStatusAppeal" v-if="$q.screen.width > 685">
                <q-item-section> ตรวจสอบเรื่อง </q-item-section>
              </q-item>


              <q-btn-dropdown v-if="$q.screen.width <= 685" flat round dense dropdown-icon="menu"
                class="custom-btn-dropdown">
                <q-list>


                  <q-separator />

                  <q-item clickable v-ripple to="/user/appeal">
                    <q-item-section avatar>
                      <q-icon name="campaign" />
                    </q-item-section>
                    <q-item-section style="margin-left: -10px"> แจ้งเรื่อง </q-item-section>
                  </q-item>

                  <q-item clickable v-ripple to="/user/CheckStatusAppeal">
                    <q-item-section avatar>
                      <q-icon name="star" />
                    </q-item-section>
                    <q-item-section style="margin-left: -10px"> ตรวจสอบเรื่อง </q-item-section>
                  </q-item>


                 
                </q-list>
              </q-btn-dropdown>

              














            </q-toolbar>






          </div>
        </div>
      </div>



      <q-page-container>
        <router-view />
      </q-page-container>
     <!--  <q-page-container>
          <Appeal />
          <Appeal />
          <Appeal />
          <Appeal />
        </q-page-container> -->

      <q-footer elevated class="bg-primary text-white">
        <div class="text-center text-h7">
          <strong>กรมอุตุนิยมวิทยา 4353 ถนนสุขุมวิท แขวงบางนา เขตบางนา
            กรุงเทพมหานคร</strong>
        </div>
      </q-footer>

    </q-layout>
  </div>
</template>
    
<script>
import { computed, ref } from "vue"; // นำเข้า ref เพื่อใช้งาน



/* import Appeal from "../../views/Appeal.vue"; */

export default {
  components: {},
  setup() {


    const leftDrawerOpen = ref(false);
    const toggleLeftDrawer = () => {
      leftDrawerOpen.value = !leftDrawerOpen.value;
    };

    const handleLogout = async () => {
      await userStore.handleLogout(); // เรียกใช้ handleLogout จาก store
    };

    const redirectToHome = () => {
      this.$router.push('/user');
    };

    return {
   
      leftDrawerOpen,
      toggleLeftDrawer,
      handleLogout,
      redirectToHome,


    };
  },
};
</script>

<style scoped>
.nav {

  background: white;
  /* background: linear-gradient(135deg, #e91e63, #673ab7); */
  /* border-radius: 20px; */
  box-shadow: 0 16px 24px rgba(0, 0, 0, 0.1);

  position: sticky;
  top: 0px
}

.container {
  max-width: 1423px;

  text-align: center;
  margin: 0 auto;
  /* จัดกึ่งกลางตามแนวนอน */
  /* border: 1px solid red; */


}

.navcon {
  display: flex;
  justify-content: space-between;
}
</style>
  
  