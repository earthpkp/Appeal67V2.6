<template>
  <div v-if="user">
    <q-layout view="hHh LpR fFf" class="q-pa-sm" style="background-color: #f5f5f5">
      <q-header elevated class="bg-primary text-white">
        <q-toolbar>
          <q-btn dense flat round icon="menu" @click="toggleLeftDrawer" />
          <q-avatar>
            <q-img src="" />
          </q-avatar>
          <q-toolbar-title> ระบบร้องเรียนร้องทุกข์ </q-toolbar-title>
          <q-space />

          <!-- {{ user.email }}
                      <q-btn flat round dense icon="account_circle" /> -->

          <!-- <q-btn-dropdown flat round dense icon="account_circle">
              <div class="row no-wrap q-pa-md">
                <div class="column items-center">
                  <div class="text-h6 q-mb-xs">Settings</div>
  
                  <div class="text-subtitle1 q-mt-xs q-mb-xs">{{ user.email }}</div>
                  <q-btn color="primary" label="Logout" push size="sm" v-close-popup />
                </div>
  
  
          
  
              </div>
            </q-btn-dropdown> -->

          <div class="q-pa-md">
            <q-btn-dropdown flat round dense icon="account_circle" :label="user.email.toLowerCase()"
              class="custom-btn-dropdown">
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
          </div>
        </q-toolbar>
      </q-header>

      <q-drawer show-if-above v-model="leftDrawerOpen" side="left" bordered>
        <q-scroll-area class="fit">
          <q-list padding class="menu-list q-gutter-sm">
            <q-item clickable v-ripple>
              <q-item-section avatar>
                <q-icon name="inbox" />
              </q-item-section>

              <q-item-section> Inbox </q-item-section>
            </q-item>

            <q-item active clickable v-ripple>
              <q-item-section avatar>
                <q-icon name="star" />
              </q-item-section>

              <q-item-section> Star </q-item-section>
            </q-item>

            <q-item clickable v-ripple>
              <q-item-section avatar>
                <q-icon name="send" />
              </q-item-section>

              <q-item-section> Send </q-item-section>
            </q-item>

            <q-item clickable v-ripple>
              <q-item-section avatar>
                <q-icon name="drafts" />
              </q-item-section>

              <q-item-section> Drafts </q-item-section>
            </q-item>
          </q-list>
        </q-scroll-area>
      </q-drawer>

      <q-page-container>
        <router-view />
      </q-page-container>
      <!-- <q-page-container>
          <Appeal />
          <Appeal />
          <Appeal />
          <Appeal />
        </q-page-container> -->

      <!-- <q-footer elevated class="bg-primary text-white">
        <div class="text-center text-h7">
          <strong>กรมอุตุนิยมวิทยา 4353 ถนนสุขุมวิท แขวงบางนา เขตบางนา
            กรุงเทพมหานคร</strong>
        </div>
      </q-footer> -->

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
    userStore.fetchUserEm();

    const leftDrawerOpen = ref(false);
    const toggleLeftDrawer = () => {
      leftDrawerOpen.value = !leftDrawerOpen.value;
    };

    const handleLogout = async () => {
      await userStore.handleLogout(); // เรียกใช้ handleLogout จาก store
    };

    return {
      user,
      leftDrawerOpen,
      toggleLeftDrawer,
      handleLogout,
    };
  },
};
</script>
  
  