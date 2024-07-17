<template>
    <q-layout view="hHh lpR fFf" class="q-pa-md" style="background-color: #f5f5f5;">
        <q-page-container>
            <FormSendResetPassword />
        </q-page-container>
        <FooterLayout />
    </q-layout>
</template>

<script setup>
import FormSendResetPassword from '../components/Formcomponents/FormSendResetPassword.vue';
import FooterLayout from '../components/Layouts/FooterLayout.vue';
</script>
