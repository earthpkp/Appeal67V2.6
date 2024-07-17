<template>
  <div v-if="user">
    <q-layout view="hHh LpR fff" style="background-color: #f5f5f5">
      <q-ajax-bar color="teal-7" />





      <div class="nav " style=" z-index: 999; ">
        <div class="container ">
          <div class="navcon shadow-up-">
            <q-toolbar>


              <!-- <a href="/user/appeal">
                  <img src="./../../assets/home2.svg" alt="TMD Logo" style="width: Auto; height: 67px;" >
                </a> -->

              <q-btn :ripple="false" color="transparent" no-caps flat to="/AdminEmployee/Dashbord">
                <img src="./../../assets/home2.svg" />
              </q-btn>


              <!-- <img src="./../../assets/home2.svg" alt="TMD Logo" style="width: Auto; height: 73px;">


                <q-img src="./../../assets/home2.svg" alt="TMD Logo" style="width: auto; height: 73px;" /> -->

              <!-- <span class="q-ml-sm">ระบบร้องเรียนร้องทุกข์</span> -->
              <!-- <span class="q-ml-sm">ระบบร้องเรียนร้องทุกข์</span> -->

              <!-- <div class="text-center text-h7">
                  <strong>ระบบร้องเรียนร้องทุกข์</strong>
                </div>
                <div class="text-center text-h6">
                  <strong>กรมอุตุนิยมวิทยา</strong>
                </div> -->



              <q-space />



              <q-item clickable v-ripple :to="{ path: '/AdminEmployee/CheckStatusAppeal' }" v-if="$q.screen.width > 685"
                :class="{ 'q-item--active': $route.fullPath.startsWith('/AdminEmployee/CheckStatusAppeal') }">
                <q-item-section>ตรวจสอบเรื่อง</q-item-section>
              </q-item>



              <q-item clickable v-ripple to="/AdminEmployee/Dashbord" v-if="$q.screen.width > 685">
                <q-item-section> รายงาน </q-item-section>
              </q-item>



              <!-- <q-item clickable v-ripple to="/AdminEmployee/CheckStatusAppeal" v-if="$q.screen.width > 685">
                <q-item-section> ตรวจสอบเรื่อง </q-item-section>
              </q-item> -->


              





              <!-- <q-item clickable @click="handleLogout">
                <q-item-section> ออกจากระบบ </q-item-section>
              </q-item> -->


              <q-btn-dropdown v-if="$q.screen.width <= 685" flat round dense icon="account_circle"
                class="custom-btn-dropdown">
                <q-list>



                  <q-item clickable v-close-popup>
                    <q-item-section avatar>
                      <q-icon name="person" />
                    </q-item-section>
                    <q-item-section style="margin-left: -10px">
                      {{ user.email }}
                    </q-item-section>
                  </q-item>



                  <q-separator />

                  <q-item clickable v-ripple to="/AdminEmployee/Dashbord">
                    <q-item-section avatar>
                      <q-icon name="campaign" />
                    </q-item-section>
                    <q-item-section style="margin-left: -10px"> รายงาน </q-item-section>
                  </q-item>

                  <q-item clickable v-ripple to="/AdminEmployee/CheckStatusAppeal">
                    <q-item-section avatar>
                      <q-icon name="star" />
                    </q-item-section>
                    <q-item-section style="margin-left: -10px"> ตรวจสอบเรื่อง </q-item-section>
                  </q-item>


                  <q-separator />
                  <q-item clickable v-close-popup to="">
                    <q-item-section avatar>
                      <q-icon name="settings" />
                    </q-item-section>
                    <q-item-section style="margin-left: -10px" disable>
                      <q-item-label>ตั้งค่า</q-item-label>
                    </q-item-section>
                  </q-item>

                  <q-item clickable v-close-popup @click="handleLogout">
                    <q-item-section avatar>
                      <q-icon name="logout" />
                    </q-item-section>
                    <q-item-section style="margin-left: -10px">
                      <q-item-label>ออกจากระบบ</q-item-label>
                    </q-item-section>
                  </q-item>
                </q-list>
              </q-btn-dropdown>

              <q-btn-dropdown v-else color="primary" rounded dense icon="account_circle" :label="user.email" no-caps>
                <q-list>

                  <q-item clickable v-close-popup>
                    <q-item-section avatar>
                      <q-icon name="settings" />
                    </q-item-section>
                    <q-item-section style="margin-left: -10px">
                      <q-item-label>ตั้งค่า</q-item-label>
                    </q-item-section>
                  </q-item>
                  <q-separator />
                  <q-item clickable v-close-popup @click="handleLogout">
                    <q-item-section avatar>
                      <q-icon name="logout" />
                    </q-item-section>
                    <q-item-section style="margin-left: -10px">
                      <q-item-label>ออกจากระบบ</q-item-label>
                    </q-item-section>
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
      <!-- <q-page-container>
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

import { useUserStore } from "../../store/auth.js";

/* import Appeal from "../../views/Appeal.vue"; */

export default {
  components: {},
  setup() {
    const userStore = useUserStore();
    const user = computed(() => userStore.user);
    
    userStore.fetchUser();
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
      user,
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
  
  