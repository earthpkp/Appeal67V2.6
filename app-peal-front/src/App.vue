<template>
  <router-view />
</template>
<script setup lang="ts">
import { useRecaptchaProvider } from 'vue-recaptcha'

useRecaptchaProvider()
</script>
<style></style>