import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'


import { Quasar, Notify ,Dialog } from 'quasar'

// Import icon libraries
import '@quasar/extras/material-icons/material-icons.css'

// Import Quasar css
import 'quasar/src/css/index.sass'

import './style.css'

import router from './router'
import { VueRecaptchaPlugin } from 'vue-recaptcha/head'

const myApp = createApp(App)
const pinia = createPinia()

myApp.use(Quasar, {
    plugins: {
        Notify,
        Dialog
    }, // import Quasar plugins and add here
})

// Assumes you have a <div id="app"></div> in your index.html
myApp.use(pinia)
myApp.use(router)
myApp.use(VueRecaptchaPlugin , {
    v2SiteKey: '6LcoBa0pAAAAAG_V5EXWZ922i6SvmCkMU5et7LL4'
  })
myApp.mount('#app')
