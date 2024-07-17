<template>
    <q-layout view="hHh lpR fFf" class="q-pa-md" style="background-color: #f5f5f5;">
        <q-page-container>
            <FormResetPassword />
        </q-page-container>
        <FooterLayout />
    </q-layout>
</template>

<script setup>
import FormResetPassword from '../components/Formcomponents/FormResetPassword.vue';
import FooterLayout from '../components/Layouts/FooterLayoutRegister.vue'
</script>
