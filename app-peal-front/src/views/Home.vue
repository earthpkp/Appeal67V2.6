<template>
    <q-layout view="hHh lpR fFf" class="q-pa-sm" style="background-color: #f5f5f5;">
        <q-page-container>
            <HomeContainer />
        </q-page-container>
        <FooterLayout />
    </q-layout>
</template>

<script setup>
import HomeContainer from '../components/Homecomponents/HomeContainer.vue';
import FooterLayout from '../components/Layouts/FooterLayout.vue'
</script>

