<template>
    <!-- <div class="q-pa-md q-mt-xl">
        <q-stepper class="q-mx-auto" v-model="step" header-nav ref="stepper" color="primary" animated
            style="max-width: 1200px">
            <q-step :name="1" title="Select campaign settings" icon="settings" :done="step > 1" :header-nav="step > 1">
                <p>User: {{ user.email }}</p>
                <q-stepper-navigation>
                    <q-btn @click="() => { done1 = true; step = 2 }" color="primary" label="Continue" />
                </q-stepper-navigation>
            </q-step>

            <q-step :name="2" title="Create an ad group" caption="Optional" icon="create_new_folder" :done="step > 2"
                :header-nav="step > 2">
                An ad group contains one or more ads which target a shared set of keywords.

                <q-stepper-navigation>
                    <q-btn @click="() => { done2 = true; step = 3 }" color="primary" label="Continue" />
                    <q-btn flat @click="step = 1" color="primary" label="Back" class="q-ml-sm" />
                </q-stepper-navigation>
            </q-step>

            <q-step :name="3" title="Create an ad" icon="add_comment" :header-nav="step > 3">
                Try out different ad text to see what brings in the most customers, and learn how to
                enhance your ads using features like ad extensions. If you run into any problems with
                your ads, find out how to tell if they're running and how to resolve approval issues.

                <q-stepper-navigation>
                    <q-btn color="primary" @click="done3 = true" label="Finish" />
                    <q-btn flat @click="step = 2" color="primary" label="Back" class="q-ml-sm" />
                </q-stepper-navigation>
            </q-step>
        </q-stepper>
    </div> -->

    <div class="q-pa-md">
    <div class="row justify-center q-gutter-sm">
      <div
        v-for="index in inView.length"
        :key="index"
        :data-id="index - 1"
        class="example-item q-pa-sm flex flex-center relative-position"
        v-intersection="onIntersection"
      >
        <transition name="q-transition--scale">
          <q-card v-if="inView[index - 1]">
            <img src="https://cdn.quasar.dev/img/mountains.jpg">

            <q-card-section>
              <div class="text-h6">Card #{{ index }}</div>
              <div class="text-subtitle2">by John Doe</div>
            </q-card-section>
          </q-card>
        </transition>
      </div>
    </div>
  </div>

</template>
<script>
import { ref, computed } from 'vue'
import { useUserStore } from "../store/auth";
export default {
    setup() {
        const userStore = useUserStore();

        const user = computed(() => userStore.useremp);

        const inView = ref(Array.apply(null, Array(50)).map(_ => false))

        return {
            user,
            step: ref(1),

            inView,
            onIntersection (entry) {
        const index = parseInt(entry.target.dataset.id, 10)
        setTimeout(() => {
          inView.value.splice(index, 1, entry.isIntersecting)
        }, 50)
      }
        };
    }
}
</script>
<style scoped>
.example-item{
  height: 290px;
  width: 290px;
}
</style>
