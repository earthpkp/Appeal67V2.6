<template>
    <q-layout view="hHh lpR fFf" class="q-pa-md" style="background-color: #f5f5f5;">
        <q-page-container>
            <FormRegister />
        </q-page-container>
        <FooterLayout />
    </q-layout>
</template>

<script setup>
import FormRegister from '../components/Formcomponents/FormRegister.vue';
import FooterLayout from '../components/Layouts/FooterLayoutRegister.vue'
</script>
