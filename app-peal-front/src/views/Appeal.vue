<template>
    <div class="q-px-sm ">
        <div class="q-pt-lg q-mx-auto" style="max-width: 1400px;">
            <q-toolbar class="bg-primary text-white shadow-2 rounded-borders" style="height: 72px;">
                <q-btn flat round dense icon="campaign" />
                <q-toolbar-title>แจ้งเรื่องร้องเรียนร้องทุกข์</q-toolbar-title>
            </q-toolbar>
        </div>

        <div class=" ">
            <q-stepper class="q-mx-auto q-mb-lg" v-model="step" ref="stepper" alternative-labels color="primary"
                animated style="max-width: 1400px">
                <!-- Step 1: ข้อมูลส่วนตัว -->
                <q-step class=" q-px-xl " :name="1" title="ข้อตกลง" icon="settings" :done="step > 1"
                    :header-nav="step > 1">


                    <div class="q-pa-lg text-h5 text-weight-bold">ข้อตกลง
                        หลักเกณฑ์การรับเรื่องร้องเรียน</div>
                    <q-separator color="primary" inset class="q-mb-lg"
                        style="width: 100%; height: 2.2px; margin-right: 20%;" />

                    <div class="q-ml-xl">
                        <q-scroll-area style="height: 320px; max-width: 1200px;">
                            <div class="q-py-xs text-weight-medium">
                                <p>1. ใช้ถ้อยคำหรือข้อความที่สุภาพ และต้องมี ชื่อ ที่อยู่ หมายเลขโทรศัพท์
                                    อีเมล์ที่สามารถติดต่อถึงผู้ร้องเรียนได้</p>
                                <p>2. เรื่องร้องเรียนต้องเป็นเรื่องจริงที่มีมูลเหตุ
                                    มิได้หวังสร้างกระแสหรือสร้างข่าวที่เสียหายต่อบุคคล</p>
                                <p> 3. การใช้บริการร้องเรียนของกรมอุตุนิยมวิทยานั้น
                                    ต้องสามารถติดต่อกลับไปยังผู้ใช้บริการได้
                                    เพื่อยืนยันว่ามีตัวตนจริง ไม่ได้สร้างเรื่องเพื่อกล่าวหาบุคคลอื่นหรือหน่วยงานต่างๆ
                                    ให้เกิดความเสียหาย</p>
                                <p>
                                    4. เป็นเรื่องที่ผู้ร้องได้รับความเดือดร้อน หรือเสียหาย
                                    อันเนื่องมาจากการปฏิบัติหน้าที่ต่างๆ
                                    ของเจ้าหน้าที่หรือหน่วยงานภายในสังกัดกรมอุตุนิยมวิทยา</p>
                                <p> 5. เป็นเรื่องที่ประสงค์ขอให้กรมอุตุนิยมวิทยาช่วยเหลือหรือขจัดความเดือดร้อน
                                    ในด้านที่เกี่ยวข้องกับความรับผิดชอบหรือภารกิจของกรม โดยตรง</p>
                                <p> 6. เรื่องร้องเรียนที่มีข้อมูลไม่ครบถ้วน ไม่เพียงพอ
                                    หรือไม่สามารถหาข้อมูลเพิ่มเติมได้ในการดำเนินการตรวจสอบ สืบสวน สอบสวน ข้อเท็จจริง
                                    ตามรายละเอียดที่กล่าวมาในข้อที่ 1 นั้น จะยุติเรื่องทันที</p>
                                <p> 7. ไม่เป็นเรื่องร้องเรียนที่เข้าลักษณะดังต่อไปนี้</p>
                                <p> - เรื่องร้องเรียนที่เป็นบัตรสนเท่ห์ เว้นแต่บัตรสนเท่ห์นั้นจะระบุรายละเอียดตามข้อที่
                                    1
                                    นั้น จึงจะรับไว้พิจารณาเป็นการเฉพาะเรื่อง</p>
                                <p> - เรื่องร้องเรียนที่เข้าสู่กระบวนการยุติธรรมแล้ว
                                    หรือเป็นเรื่องที่ศาลได้มีคำสั่งพิพากษาหรือคำสั่งถึงที่สุดแล้ว</p>
                                <p> - เรื่องร้องเรียนที่เกี่ยวข้องกับสถาบันพระมหากษัตริย์</p>
                                <p>- เรื่องร้องเรียนที่เกี่ยวข้องกับนโยบายของรัฐบาล</p>
                                <p>- เรื่องร้องเรียนที่หน่วยงานอื่นได้ดำเนินการตรวจสอบ พิจารณาวินิจฉัย
                                    และได้มีข้อสรุปผลการพิจารณาเป็นที่เรียบร้อยไปแล้ว</p>
                                <p>· ข้าพเจ้าขอรับรองว่าข้อเท็จจริงที่ได้ยื่นร้องเรียนต่อกรมอุตุนิยมวิทยาเป็นเรื่องที่เกิดขึ้นจริงทั้งหมดและขอรับผิดชอบต่อข้อเท็จจริงดังกล่าวข้างต้นทุกประการ
                                </p>
                                <p> · การนำความเท็จมาร้องเรียนต่อเจ้าหน้าที่
                                    ซึ่งทำให้ผู้อื่นได้รับความเสียหายอาจเป็นความผิดฐานแจ้งความเท็จต่อเจ้าพนักงานตามประมวลกฎหมายอาญา
                                </p>
                            </div>
                        </q-scroll-area>
                    </div>

                    <q-form @submit.prevent="appeal">

                        <div class="text-center q-mt-lg">
                            <q-checkbox v-model="checkbox1" label="ข้าพเจ้าได้ตรวจสอบและยอมรับเงื่อนไข" />


                        </div>

                        <q-stepper-navigation>
                            <div class="row justify-center ">
                                <div class="col-12 col-sm-3 col-md-2 col-lg-2">
                                    <div class="text-center">
                                        <q-btn type="submit" class="full-width" color="primary" size="18px"
                                            label="ถัดไป" :disabled="!checkbox1" />
                                    </div>
                                </div>
                            </div>
                        </q-stepper-navigation>
                    </q-form>
                </q-step>



                <!-- Step 2: รายละเอียด -->
                <q-step class=" q-pl-xl q-pr-xl" :name="2" title="กรอกข้อมูล" icon="create_new_folder" :done="step > 2"
                    :header-nav="step > 2">

                    <div class="q-pa-lg text-h5 text-weight-bold">ข้อมูลของผู้ร้องเรียน :</div>
                    <q-separator color="primary" inset class="q-mb-lg"
                        style="width: 100%; height: 2.2px; margin-right: 20%;" />

                    <q-form @submit.prevent="appeal">

                        <div class=" row justify-evenly text-bold ">

                            <div class="col-sm-3 col-12 q-mt-md">
                                <p> คำนำหน้าชื่อ <span class="red-asterisk">*</span></p> <q-select outlined
                                    v-model="gender" :options="options" label="ระบุคำนำหน้าชื่อ" :rules="genderRules" />
                            </div>

                            <div class="col-sm-4 col-12 q-mt-md">
                                <p> ชื่อ <span class="red-asterisk">*</span></p><q-input outlined hint="โปรดระบุชื่อ"
                                    v-model="fname" lazy-rules :rules="nameRules" />

                            </div>

                            <div class="col-sm-4 col-12 q-mt-md">
                                <p> นามสกุล <span class="red-asterisk">*</span></p> <q-input outlined
                                    hint="โปรดระบุนามสกุล" v-model="surname" :rules="surnameRules" />
                            </div>

                        </div>

                        <div class="q-mt-md row justify-evenly text-bold">

                            <div class="col-sm-3 col-12 q-mt-md">
                                <p> เลขบัตรประชาชน <span class="red-asterisk">*</span></p><q-input outlined
                                    hint="โปรดระบุเลขบัตรประชาชน" type="text" v-model="idcard"
                                    placeholder="#-####-#####-##-#" mask="#-####-#####-##-#" :rules="idcardRules" />
                            </div>

                            <div class="col-sm-4 col-12 q-mt-md">
                                <p> อีเมล <span class="red-asterisk">*</span></p><q-input outlined hint="โปรดระบุอีเมล"
                                    type="email" v-model="email" :rules="emailRules" />
                            </div>

                            <div class="col-sm-4 col-12 q-mt-md">
                                <p> โทรศัพท์มือถือ <span class="red-asterisk">*</span></p> <q-input outlined
                                    hint="โปรดระบุหมายเลขโทรศัพท์" v-model="tel" placeholder="(###) ### - ####"
                                    mask="(###) ### - ####" :rules="telRules" />
                            </div>

                        </div>


                        <div class="row items-center q-mt-lg">

                            <div class="col-12">
                                <div class="text-center text-h6 ">
                                    <q-checkbox v-model="pvactive" val="1" label="ฉันต้องการ 'ปกปิดข้อมูลส่วนตัว'">
                                    </q-checkbox>
                                </div>
                            </div>

                            <div class="col-12 text-h7 ">
                                <div class="text-center">
                                    <p> <span class="red-asterisk">(หากคุณเลือก "ปกปิดข้อมูลส่วนตัว"
                                            เจ้าหน้าที่ดำเนินเรื่องจะไม่สามารถเห็นข้อมูลส่วนตัวของคุณ)</span></p>

                                </div>
                            </div>

                        </div>


                        <div class="q-pa-lg  text-h5 text-weight-bold">รายละเอียดการร้องเรียน :</div>
                        <q-separator color="primary" inset class="q-mb-lg"
                            style="width: 100%; height: 2.2px; margin-right: 20%;" />


                        <div class="row text-bold row items-center q-gutter-sm q-mt-sm">

                            <div class="col-sm-2 ">
                                <p style="font-size: 14px; text-align: right;"> ประเภทเรื่อง <span
                                        class="red-asterisk">*</span>
                                </p>
                            </div>

                            <div class="col-sm-8 col-lg-5 col-12 ">
                                <q-select outlined v-model="headtopic" :options="headtopicdetail"
                                    label="เลือกเรื่องที่ต้องการแจ้ง" :rules="headtopicdetailRules" />
                            </div>

                        </div>


                        <div class="row text-bold row items-center q-gutter-sm q-mt-sm">

                            <div class="col-sm-2 ">
                                <p style="font-size: 14px; text-align: right;"> หัวข้อเรื่อง <span
                                        class="red-asterisk">*</span>
                                </p>
                            </div>

                            <div class="col-sm-8 col-12 ">
                                <q-input outlined hint="โปรดระบุหัวข้อเรื่อง" type="text" v-model="topic"
                                    :rules="topicRules" />
                            </div>

                        </div>

                        <div class="row text-bold row items-center q-gutter-sm q-mt-sm">

                            <div class="col-sm-2 ">
                                <p style="font-size: 14px; text-align: right;"> เนื้อหาร้องเรียน <span
                                        class="red-asterisk">*</span></p>
                            </div>

                            <div class="col-sm-8 col-12 ">
                                <q-input outlined hint="โปรดระบุรายละเอียด" type="textarea" v-model="detail"
                                    :rules="detailRules" />

                            </div>

                        </div>


                        <div class="q-mt-md row justify-center text-bold">

                            <Checkbox v-model:model-value="response" class="item-center" />



                        </div>

                        <div class="col-12 text-h7 ">
                            <div class="text-center">
                                <p> <span class="red-asterisk"> {{ responseMessage }}</span></p>

                            </div>
                        </div>



                        <q-stepper-navigation>
                            <div class="-sm row justify-center q-gutter-sm">
                                <div class="col-12 col-sm-3 col-md-2 col-lg-2">
                                    <div class="text-center">
                                        <q-btn type="submit" class="full-width" color="primary" size="18px"
                                            label="ยืนยัน" />
                                        <q-inner-loading :showing="loading" color="primary" label="กำลังโหลดข้อมูล"
                                            label-class="text-teal" label-style="font-size: 2em" />
                                    </div>
                                </div>
                                <div class="col-12 col-sm-3 col-md-2 col-lg-2">
                                    <div class="text-center">
                                        <q-btn flat @click="prevStep(1)" class="full-width" color="primary" size="18px"
                                            label="ย้อนกลับ" />
                                    </div>
                                </div>
                            </div>
                        </q-stepper-navigation>



                    </q-form>
                </q-step>


                <!-- Step 3: เสร็จสิ้น -->
                <q-step :name="3" title="เสร็จสิ้น" icon="add_comment" :header-nav="step > 3">



                    <div class="q-mt-sm row justify-center text-bold">
                        <div class="col-12">
                            <div class="text-center" role="status" aria-label="text-subtitle2">
                                <q-img src="./../assets/success3.gif" style="height: 150px; max-width: 150px" />

                                <!-- <p style="font-size: 30px">สำเร็จ!</p> -->

                            </div>
                        </div>

                    </div>


                    <div class="q-mt-sm row justify-center ">

                        <!-- <div class="col-2 col-sm-12 text-bold ">
                        <p style="font-size: 23px; text-align: right;"> รหัสเรื่อง : </p>
                    </div> -->

                        <div class="col-12 col-sm-12">
                            <p style="font-size: 25px; text-align: center;"> <strong>รหัสเรื่อง(Tracking ID) :
                                </strong>{{
                responseMessage }}
                            </p>
                        </div>

                    </div>

                    <div class=" q-gutter-sm ">

                        <div class="col-12 text-bold  column items-center">
                            <p class="text-secondary" style="font-size: 23px;">อยู่ระหว่างตรวจสอบข้อมูล</p>
                            <!-- <p class="text-secondary" style="font-size: 23px;">อยู่ระหว่างตรวจสอบข้อมูล</p> -->


                            <!-- <q-chip color="secondary" text-color="white" style="font-size: 23px;">
                            อยู่ระหว่างรอรับเรื่อง
                        </q-chip> -->

                        </div>
                        <div class="col-12  column items-center">
                            <p style="font-size: 23px; "> ท่านสามารถติดตามสถานะได้ที่ Email ของท่าน "  <span class="text-cyan-14"> {{ responseMessageEmail }}</span>"  หรือ "<span class="text-cyan-14">   ปุ่มติดตามสถานะ</span>"
                              </p>
                        </div>
                    </div>

                    <q-stepper-navigation>
                        <div class="q-pb-md row justify-center ">
                            <div class="col-12 col-sm-3 col-md-2 col-lg-2">
                                <div class="text-center">
                                    <q-btn clickable v-ripple to="/user/CheckStatusAppeal" class="full-width"
                                        color="cyan-14" size="18px" label="ติดตามสถานะ" />
                                </div>
                            </div>

                        </div>
                    </q-stepper-navigation>



                </q-step>
            </q-stepper>




        </div>
    </div>

</template>

<script>
import { ref, onBeforeUnmount } from 'vue'
import { Checkbox } from 'vue-recaptcha';
import axios from 'axios';


export default {
    components: {
        Checkbox
    },

    setup() {

        const pvactive = ref(false);
        const checkbox1 = ref(false);
        const loading = ref(false);

        const dialog1 = ref(false);



        const responseMessage = ref('');
        const responseMessageEmail = ref('');
        /* const user_id = localStorage.getItem('user_id'); */



        // สร้างฟังก์ชันเพื่อลบ _grecaptcha ออกจาก Local Storage เมื่อนำทางไปยัง Router อื่น
        const removeGrecaptchaOnRouteChange = () => {
            localStorage.removeItem('_grecaptcha');
        };

        // ใช้ Navigation Guards ใน Vue Router เพื่อลบ _grecaptcha ออกจาก Local Storage เมื่อทำการนำทางไปยังหน้าใหม่
        onBeforeUnmount(() => {
            removeGrecaptchaOnRouteChange();
        });


        const step = ref(1);

        const nextStep = (nextStep) => {
            step.value = nextStep;
        };

        const prevStep = () => {
            // ตรวจสอบว่าผู้ใช้อยู่ในขั้นตอนที่สองของแบบฟอร์มหรือไม่
            if (step.value === 2) {
                // ลบข้อมูลจาก Local Storage เมื่อผู้ใช้ออกจากขั้นตอนที่สองของแบบฟอร์ม
                localStorage.removeItem('_grecaptcha');
            } else {
                // ถ้าไม่ได้อยู่ในขั้นตอนที่สองของแบบฟอร์มให้ลบ _grecaptcha ออกจาก Local Storage ทันที
                localStorage.removeItem('_grecaptcha');
            }
            // กำหนด gkey เป็นค่าว่าง
            data.response = '';
            data.fname = ref('');
            data.surname = ref('');
            data.gender = ref('');
            data.idcard = ref('');
            data.email = ref('');
            data.tel = ref('');
            data.headtopic = ref('');
            data.topic = ref('');
            data.detail = ref('');
            data.pvactive = ref(false);
            responseMessage.value = '';
            
            // กำหนดขั้นตอนก่อนหน้า
            step.value = step.value - 1;
        };




        const finish = () => {
            // Your finish logic here
            // For example, you can navigate to another page or perform some actions
            console.log("Finished");
        };
        const appeal = async () => {
            if (step.value === 1) {
                nextStep(2);
            } else {

                loading.value = true


                // เตรียมข้อมูลที่จะส่งไปยัง API
                const requestData = {

                    app_fname: data.fname.value,
                    app_lname: data.surname.value,
                    app_gender: data.gender.value,
                    app_cardID: data.idcard.value,
                    app_email: data.email.value,
                    app_tel: data.tel.value,

                    app_typedetail: data.headtopic.value,
                    app_headdetail: data.topic.value,
                    app_detail: data.detail.value,

                    app_active: data.pvactive.value,
                    gkey: data.response,
                };


                try {
                    const response = await axios.post(`${import.meta.env.VITE_API}/user/appeal`, requestData);
                    console.log('ส่งข้อมูลสำเร็จ', response.data);
                    responseMessage.value = response.data.message;
                    responseMessageEmail.value = response.data.data.app_email;
                    loading.value = false;
                    nextStep(3);
                } catch (error) {
                    if (error.response.status === 401) {
                        // Handle 401 Unauthorized error
                        console.error('reCAPICHA เกิดข้อผิดพลาด', error);
                        responseMessage.value = 'กรุณายืนยัน reCAPICHA';
                    } else {
                        // Handle other errors
                        console.error('เกิดข้อผิดพลาดในการส่งข้อมูล', error);
                        responseMessage.value = 'เกิดข้อผิดพลาดในการส่งข้อมูล';
                    }
                    loading.value = false;
                }
            }
        };

        const data = {
            step,
            nextStep,
            prevStep,
            finish,
            appeal,
            pvactive,
            dialog1,
            checkbox1,
            loading,
            response: '',





            responseMessage: responseMessage,
            responseMessageEmail: responseMessageEmail,

            color: ref(''),

            fname: ref(''),
            surname: ref(''),
            gender: ref(''),
            idcard: ref(''),
            email: ref(''),
            tel: ref(''),


            department: ref(''),
            namedepartment: ref(''),

            headtopic: ref(''),
            topic: ref(''),
            detail: ref(''),

            options: [
                'นาย', 'นาง', 'นางสาว', 'อื่นๆ',
            ],
            headtopicdetail: [
                'ด้านการทุจริตการปฏิบัติหรือละเว้นการปฏิบัติหน้าที่โดยมิชอบของเจ้าหน้าที่ของรัฐ', 'ด้านการจัดซื้อจัดจ้าง', 'ด้านการบริหารและการพัฒนาทรัพยากรบุคคล',
                'ด้านอื่นๆ',
            ],
            departmentdetail: [
                'กองบริการดิจิตอล', 'กองสื่อสาร',
            ],

            nameRules: [
                v => !!v || 'โปรดกรอกชื่อ', // ตรวจสอบว่าชื่อไม่ว่างเปล่าหรือไม่
                v => !/\d/.test(v) || 'ชื่อไม่ควรมีตัวเลข',
                v => (v && v.length >= 3) || 'ชื่อต้องมีอย่างน้อย 3 ตัวอักษร', // ตรวจสอบว่าชื่อมีอย่างน้อย 3 ตัวอักษร
                v => (!!v && v.length <= 50) || 'รายละเอียดเกิน 50 ตัวอักษร',
                v => !/[!@#$%^&*(),.?":{}|<>-]/.test(v) || 'ชื่อไม่ควรมีสัญลักษณ์'
            ],

            genderRules: [
                v => !!v || 'โปรดเลือกคำนำหน้าชื่อ',
            ],
            surnameRules: [
                v => !!v || 'โปรดกรอกนามสกุล',
                v => !/\d/.test(v) || 'นามสกุลไม่ควรมีตัวเลข',
                v => (v && v.length >= 3) || 'นามสกุลต้องมีอย่างน้อย 3 ตัวอักษร',
                v => (!!v && v.length <= 50) || 'รายละเอียดเกิน 50 ตัวอักษร',
                v => !/[!@#$%^&*(),.?":{}|<>-]/.test(v) || 'ชื่อไม่ควรมีสัญลักษณ์'
            ],
            idcardRules: [
                v => !!v || 'โปรดกรอกเลขบัตรประชาชน',
                v => /^[0-9]{1}-[0-9]{4}-[0-9]{5}-[0-9]{2}-[0-9]{1}$/.test(v) || 'เลขบัตรประชาชนต้องมี 13 หลักเป็นตัวเลขเท่านั้น',
                v => {
                    const id = v.replace(/-/g, ''); // ลบขีด (-) ออกจากเลขบัตรประชาชน
                    if (id.length !== 13) return 'เลขบัตรประชาชนต้องมี 13 หลัก';

                    // เพิ่มโค้ดตรวจสอบตามสูตร
                    let sum = 0;
                    for (let i = 0; i < 12; i++) {
                        sum += parseFloat(id.charAt(i)) * (13 - i);
                    }

                    if ((11 - (sum % 11)) % 10 !== parseFloat(id.charAt(12))) return 'เลขบัตรประชาชนไม่ถูกต้อง';

                    return true;
                }
            ],
            emailRules: [
                v => !!v || 'โปรดกรอกอีเมล',
                v => /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/.test(v) || 'รูปแบบอีเมลไม่ถูกต้อง',
                v => (!!v && v.length <= 50) || 'รายละเอียดเกิน 50 ตัวอักษร'
            ],
            telRules: [
                v => !!v || 'โปรดกรอกหมายเลขโทรศัพท์',
                v => /^\(\d{3}\) \d{3} - \d{4}$/.test(v) || 'หมายเลขโทรศัพท์ต้องมี 10 หลัก',
            ],

            headtopicdetailRules: [
                v => !!v || 'โปรดระบุประเภทเรื่อง',
            ],



            topicRules: [
                v => !!v || 'โปรดระบุหัวข้อเรื่อง',
                v => (!!v && v.length <= 150) || 'รายละเอียดเกิน 150 ตัวอักษร'
            ],

            detailRules: [
                v => !!v || 'โปรดระบุรายละเอียด',
                v => (!!v && v.length <= 2500) || 'รายละเอียดเกิน 2500 ตัวอักษร'
            ],



        };


        return data;


    }
}

</script>

<style>
span.red-asterisk {
    color: rgb(211, 15, 15);
}
</style>