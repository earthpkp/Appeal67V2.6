<template>
  <div class="q-px-sm q-py-lg">
    <div class="q-mx-auto " style="max-width: 1400px;">
      <div class="row q-gutter-sm">
        <q-btn size="16px" push color="white" text-color="primary" icon="arrow_back" label="กลับ" @click="goBack" />
        <q-space />
        <div v-if="appealData.status_id == 1">
          <div class="row q-gutter-sm">
            <q-btn size="16px" push label="รับเรื่องร้องเรียน" color="primary" icon="description"
              @click="updateapp = true" />
            <q-btn size="16px" push label="ปฏิเสธการรับ" color="accent" icon="clear" @click="reject" />
          </div>
        </div>
        <div v-else-if="appealData.status_id == 2">
          <div class="row q-gutter-sm">
            <q-btn v-if="user.department_id == appealData.dep_id" size="16px" push label="การดำเนินการ" color="primary"
              icon="description" @click=" updateapp2 = true" />
            <q-btn v-if="user.department_id === appealData.dep_id && filteredComments.length > 0" size="16px" push
              label="ปิดงาน" color="accent" icon="description" @click="closeapp = true" />
            <q-btn v-if="user.department_id === appealData.dep_id" size="16px" push label="ส่งต่อ" color="blue-12"
              icon="description" @click="updateapp6 = true" />
          </div>
        </div>
        <div v-if="appealData.status_id == 5">
          <div class="row q-gutter-sm">
            <q-btn size="16px" push label="รับเรื่องร้องเรียน" color="primary" icon="description"
              @click="updateapp = true" />
            <q-btn size="16px" push label="ปฏิเสธการรับ" color="accent" icon="clear" @click="reject" />
          </div>
        </div>
      </div>
    </div>

    <q-dialog v-model="updateapp" persistent>
      <q-card class="inset-box" style="width: 650px; max-width: 100vw;">
        <q-form @submit.prevent="onSubmit">
          <q-card-section>
            <div class="row items-center ">
              <div class="text-h5 text-weight-bolder">รับเรื่องร้องเรียน</div>
              <q-space />
              <q-btn no-caps round flat icon="close" v-close-popup />
            </div>
          </q-card-section>
          <q-separator />
          <q-card-section>
            <q-select outlined v-model="emdep" :options="options" option-value="id" label="หน่วยงานที่รับผิดชอบ" />
          </q-card-section>
          <q-separator />
          <q-card-actions class="justify-center q-pa-md">
            <div class="q-gutter-sm q-mr-sm ">
              <q-btn type="submit" size="16px" style="width: 115px" push color="primary" text-color="white"
                label="ยืนยัน" v-close-popup />
              <q-btn size="16px" style="width: 100px" push color="white" text-color="primary" label="ปิด"
                v-close-popup />
            </div>
          </q-card-actions>
        </q-form>
      </q-card>
    </q-dialog>

    <q-dialog v-model="updateapp2" persistent>
      <q-card class="inset-box" style="width: 650px; max-width: 100vw;">
        <q-form ref="resetform" @submit.prevent="onSubmit2">
          <q-card-section>
            <div class="row items-center ">
              <div class="text-h5 text-weight-bolder">การดำเนินการ</div>
              <q-space />
              <q-btn no-caps round flat icon="close" @click="resetval" v-close-popup />
            </div>
          </q-card-section>
          <q-separator />
          <q-card-section>
            <q-input v-model="detail" lazy-rules :rules="detailRules" outlined type="textarea"
              label="รายละเอียดการดำเนินการ" />
          </q-card-section>
          <q-card-section>
            <q-input outlined v-model="emname" lazy-rules :rules="emnameRules" label="เจ้าหน้าที่ดำเนินเรื่อง" />
          </q-card-section>
          <q-separator />
          <q-card-actions class="justify-end q-pa-md">
            <div class="q-gutter-sm q-mr-sm ">
              <q-btn type="submit" size="16px" style="width: 115px" push color="primary" text-color="white"
                label="ยืนยัน" />
              <q-btn size="16px" style="width: 100px" push color="white" text-color="primary" label="ปิด" @click="resetval"
                v-close-popup />
            </div>
          </q-card-actions>
        </q-form>
      </q-card>
    </q-dialog>

    <q-dialog v-model="closeapp" persistent >
      <q-card class="inset-box" style="width: 650px; max-width: 100vw;">
        <q-form ref="resetform" @submit.prevent="showSweetAlert" >
          <q-card-section>
            <div class="row items-center ">
              <div class="text-h5 text-weight-bolder">ปิดงาน</div>
              <q-space />
              <q-btn no-caps round flat icon="close" @click="resetval" v-close-popup />
            </div>
          </q-card-section>
          <q-separator />
          <q-card-section>
            <q-input v-model="detailend" lazy-rules :rules="emnameRules" outlined type="textarea"
              label="รายละเอียดการดำเนินการ" />
          </q-card-section>
          <q-card-section>
            <q-input outlined v-model="emnameend" lazy-rules :rules="emnameRules" label="เจ้าหน้าที่ดำเนินเรื่อง" />
          </q-card-section>
          <q-separator />
          <q-card-actions class="justify-end q-pa-md">
            <div class="q-gutter-sm q-mr-sm ">
              <q-btn type="submit" size="16px" style="width: 115px" push color="primary" text-color="white"
                label="ยืนยัน" />
              <q-btn size="16px" style="width: 100px" push color="white" text-color="primary" label="ปิด" @click="resetval"
                v-close-popup />
            </div>
          </q-card-actions>
        </q-form>
      </q-card>
    </q-dialog>


    <q-dialog v-model="updateapp6" persistent>
      <q-card class="inset-box" style="width: 650px; max-width: 100vw;">
        <q-form ref="resetform" @submit.prevent="onSubmit6">
          <q-card-section>
            <div class="row items-center ">
              <div class="text-h5 text-weight-bolder">ส่งต่อ</div>
              <q-space />
              <q-btn no-caps round flat icon="close" @click="resetval" v-close-popup />
            </div>
          </q-card-section>
          <q-separator />
          <q-card-section>
            <q-select outlined v-model="toemdep" lazy-rules :rules="emdepRules" :options="options" option-value="id"
              label="หน่วยงานที่รับผิดชอบ" />
          </q-card-section>


          <q-card-section>
            <q-input v-model="todetail" lazy-rules :rules="detailRules" outlined type="textarea" label="รายละเอียด" />
          </q-card-section>
          <q-card-section>
            <q-input outlined v-model="toemname" lazy-rules :rules="emnameRules" label="เจ้าหน้าที่ดำเนินเรื่อง" />
          </q-card-section>
          <q-separator />

          <q-card-actions class="justify-end q-pa-md">
            <div class="q-gutter-sm q-mr-sm ">
              <q-btn type="submit" size="16px" style="width: 115px" push color="primary" text-color="white"
                label="ยืนยัน" />
              <q-btn size="16px" style="width: 100px" push color="white" text-color="primary" label="ปิด"
              @click="resetval" v-close-popup />
            </div>
          </q-card-actions>
        </q-form>
      </q-card>
    </q-dialog>


    <q-dialog v-model="isactive" persistent>
      <q-card class="inset-box" style="width: 650px; max-width: 100vw;">
        <q-form @submit.prevent="showSweetAlert">
          <q-card-section class="bg-grey-1 ">
            <div class="items-center text-center">
              <div class="text-h5 text-weight-bolder ">ข้อมูลส่วนตัว</div>
            </div>
          </q-card-section>
          <q-separator />
          <q-card-section horizontal>
            <q-card-section class="col-4 text-weight-bolder text-right text-h7 text-pink2">
              คำนำหน้า :
            </q-card-section>
            <q-card-section class="col-8" style="word-wrap: break-word;">
              {{ (appealData.app_gender) }}
            </q-card-section>
          </q-card-section>
          <q-card-section horizontal>
            <q-card-section class="col-4 text-weight-bolder text-right text-h7 text-pink2">
              ชื่อ - นามสกุล :
            </q-card-section>
            <q-card-section class="col-8" style="word-wrap: break-word;">
              {{ (appealData.app_fname) }} {{ (appealData.app_lname) }}
            </q-card-section>
          </q-card-section>
          <q-card-section horizontal>
            <q-card-section class="col-4 text-weight-bolder text-right text-h7 text-pink2">
              เลขบัตรประชาชน :
            </q-card-section>
            <q-card-section class="col-8" style="word-wrap: break-word;">
              {{ (appealData.app_cardID) }}
            </q-card-section>
          </q-card-section>
          <q-card-section horizontal>
            <q-card-section class="col-4 text-weight-bolder text-right text-h7 text-pink2">
              อีเมล :
            </q-card-section>
            <q-card-section class="col-8" style="word-wrap: break-word;">
              {{ (appealData.app_email) }}
            </q-card-section>
          </q-card-section>
          <q-card-section horizontal>
            <q-card-section class="col-4 text-weight-bolder text-right text-h7 text-pink2">
              โทรศัพท์ :
            </q-card-section>
            <q-card-section class="col-8" style="word-wrap: break-word;">
              {{ (appealData.app_tel) }}
            </q-card-section>
          </q-card-section>
          <q-separator />
          <q-card-actions class="justify-center q-pa-md">
            <div class="q-gutter-sm col-12 text-center ">
              <q-btn size="16px" style="width: 120px" push color="white" text-color="primary" label="ปิด"
                v-close-popup />
            </div>
          </q-card-actions>
        </q-form>
      </q-card>
    </q-dialog>













    <q-dialog v-model="tabletimeline" persistent>
      <q-card class="inset-box" style="width: 100%; max-width: 85vw;">

        <q-card-section>
          <div class="q-px-lg row items-center ">
            <div class="text-h5 text-weight-bolder">ตารางการดำเนินการ</div>
            <q-space />
            <q-btn no-caps round flat icon="close" v-close-popup />
          </div>
        </q-card-section>
        <q-separator />
        <div class="q-px-lg" style="font-size: 16px;">
          <q-card-section horizontal>

            <q-card-section class="col-3" style="word-wrap: break-word;">
              <span class="text-green2">เลขที่เอกสาร :</span> <span class="text-bold">{{ appealData.app_doc }}</span>
            </q-card-section>


            <q-card-section class="col-3" style="word-wrap: break-word;">
              <span class="text-green2"> วันที่สร้าง :</span> <span>{{ formatDateShort(appealData.created_at) }}</span>
            </q-card-section>
            <q-card-section class="col-3" style="word-wrap: break-word;">
              <span class="text-green2">สถาณะเอกสาร :</span> <span>{{ appealData.status.status_name }}</span>
            </q-card-section>
          </q-card-section>
          <q-card-section horizontal>

            <q-card-section class="col-12" style="word-wrap: break-word;">
              <span class="text-green2">หัวข้อเรื่อง :</span> <span>{{ (appealData.app_headdetail) }}</span>
            </q-card-section>


          </q-card-section>
        </div>

        <q-card-section>
          <div class="q-px-lg">
            <q-table style="max-height: 670px; overflow-y: auto;" flat bordered :rows="filteredCommentsALL"
              :columns="columns" row-key="id" :loading="loading" no-data-label="ไม่มีข้อมูลการดำเนินการ"
              no-results-label="ไม่พบข้อมูลการร้องเรียน" color="primary" :rows-per-page-options="[20]"
              rows-per-page-label="จำนวน" row loading-label="กำลังโหลดข้อมูล">
              <template v-slot:no-data="{ icon, message, filter }">
                <div class="full-width row flex-center text-accent q-gutter-sm" style="font-size: 20px;">
                  <span>
                    <b>{{ message }}</b>
                  </span>
                  <q-icon size="1.3em" :name="filter ? 'search' : icon" />
                </div>
              </template>
              <template v-slot:header="props">
                <q-tr :props="props">
                  <q-th class="bg-primary text-white" v-for="col in props.cols" :key="col.name" :props="props"
                    style="font-size: 16px; text-align: center; ">
                    {{ col.label }}
                  </q-th>
                </q-tr>
              </template>
              <template v-slot:body="props">
                <q-tr :props="props">
                  <q-td key="comm_status_id" :props="props" style="font-size: 16px; text-align: center;">
                    <template v-if="props.row.comm_status_id == 1" >
                     <div class="text-info"> ส่งเรื่อง </div>
                    </template>
                    <template v-else-if="props.row.comm_status_id == 2">
                      <div class="text-yellow-8"> การดำเนินการ </div>
                    </template>
                    <template v-else-if="props.row.comm_status_id == 3">
                      <div class="text-accent"> ผลการดำเนินการ </div> 
                    </template>
                    <template v-else-if="props.row.comm_status_id == 4">
                      <div class="text-accent"> ปฏิเสธการรับ </div> 
                    </template>
                    <template v-else-if="props.row.comm_status_id == 5">
                      ตีกลับ
                    </template>
                    <template v-else-if="props.row.comm_status_id == 6">
                    <div class="text-blue-13">  ส่งต่อ </div> 
                    </template>
                    <template v-else>
                      Unknown
                    </template>
                  </q-td>

                  <q-td key="department.dep_name" :props="props" style="font-size: 16px; text-align: center;">
                    {{ props.row.department.dep_name }}
                  </q-td>

                  <q-td key="department.dep_name" :props="props"
                    style="font-size: 16px; white-space: pre-line; overflow-wrap: break-word; min-width: 175px; max-width: 175px; line-height: 2;">
                    {{ props.row.comment_details }}
                  </q-td>

                  <q-td key="department.dep_name" :props="props"
                    style="font-size: 16px; white-space: pre-line; overflow-wrap: break-word; min-width: 175px; max-width: 175px; line-height: 2;">
                    {{ props.row.emp_name }}
                  </q-td>

                  <q-td key="department.dep_name" :props="props" style="font-size: 16px; text-align: center;">
                    {{ formatDateShort(props.row.updated_at) }}
                  </q-td>
                </q-tr>
              </template>


            </q-table>
          </div>

        </q-card-section>
      </q-card>
    </q-dialog>












    



    <div class="q-pt-md q-mx-auto" style="max-width: 1400px;">
      <q-toolbar class="bg-primary text-white shadow-2 rounded-borders" style="height: 72px;">
        <q-btn flat round dense icon="campaign" />
        <q-toolbar-title v-if="appealData">หมายเลขเรื่อง : {{ appealData.app_doc }}
          <q-badge class="q-ml-sm" rounded align="middle" color="secondary" text-color="black">
            {{ appealData.status.status_name }}
          </q-badge> <!-- <span class="text-subtitle1">{{ appealData.status.status_name }}</span> -->




        </q-toolbar-title>

        <!-- <q-space />
        <q-btn color="white" text-color="primary" push no-caps size="sm">
          <q-icon left size="2.5em" name="table_view" />
          <div>มุมมอง<br>ตาราง</div>
        </q-btn> -->


      </q-toolbar>

      <!-- เนื้อหา -->



















      <div v-if="appealData">
        <div class="row justify-center">

          <div class="col-12 col-md-6">
            <q-card class="q-pa-md inset-left-right" style="height: 100%; " flat>
              <div class="q-px-lg q-py-md">

                <!-- กล่องซ้าย -->

                <q-intersection transition="scale" once>
                  <q-card class="q-mx-auto inset-box" style="max-width: 1200px;" flat bordered>
                    <q-card-section class="bg-grey-1">
                      <div class="text-weight-bolder text-center text-h6">รายละเอียด<q-btn
                          v-if="appealData.app_active == 0" flat round dense color="primary"
                          icon="perm_contact_calendar" @click="isactive = true" /></div>
                    </q-card-section>
                    <q-separator />
                    <q-card-section horizontal>
                      <q-card-section class="col-4 text-weight-bolder text-right text-h7  text-pink2">
                        วันที่แจ้ง :
                      </q-card-section>
                      <q-card-section class="col-8" style="word-wrap: break-word;">
                        {{ formatDate(appealData.created_at) }}
                      </q-card-section>
                    </q-card-section>
                    <q-card-section horizontal>
                      <q-card-section class="col-4 text-weight-bolder text-right text-h7  text-pink2">
                        ประเภทเรื่อง :
                      </q-card-section>
                      <q-card-section class="col-8" style="word-wrap: break-word;">
                        {{ appealData.app_typedetail }}
                      </q-card-section>
                    </q-card-section>
                    <q-card-section horizontal>
                      <q-card-section class="col-4 text-weight-bolder text-right text-h7  text-pink2">
                        หัวข้อเรื่อง :
                      </q-card-section>
                      <q-card-section class="col-8" style="word-wrap: break-word;">
                        {{ appealData.app_headdetail }}
                      </q-card-section>
                    </q-card-section>
                    <q-card-section horizontal>
                      <q-card-section class="col-4 text-weight-bolder text-right text-h7 text-pink2">
                        เนื้อหาร้องเรียน :
                      </q-card-section>
                      <q-card-section class="col-8" style="word-wrap: break-word;">
                        {{ appealData.app_detail }}
                      </q-card-section>
                    </q-card-section>
                    <br>
                  </q-card>
                  <br>
                </q-intersection>

                <q-intersection transition="scale" once>
                  <q-card class="q-mx-auto inset-box" style="max-width: 1200px;" flat bordered
                    v-if="appealData.app_active == 0">
                    <q-card-section class="bg-grey-1">
                      <div class="text-weight-bolder text-center text-h6">ข้อมูลส่วนตัว</div>
                    </q-card-section>
                    <q-separator />

                    <q-card-section horizontal>
                      <q-card-section class="col-4 text-weight-bolder text-right text-h7 text-pink2">
                        คำนำหน้า :
                      </q-card-section>
                      <q-card-section class="col-8" style="word-wrap: break-word;">
                        {{ (appealData.app_gender) }}
                      </q-card-section>
                    </q-card-section>
                    <q-card-section horizontal>
                      <q-card-section class="col-4 text-weight-bolder text-right text-h7 text-pink2">
                        ชื่อ - นามสกุล :
                      </q-card-section>
                      <q-card-section class="col-8" style="word-wrap: break-word;">
                        {{ (appealData.app_fname) }} {{ (appealData.app_lname) }}
                      </q-card-section>
                    </q-card-section>
                    <q-card-section horizontal>
                      <q-card-section class="col-4 text-weight-bolder text-right text-h7 text-pink2">
                        เลขบัตรประชาชน :
                      </q-card-section>
                      <q-card-section class="col-8" style="word-wrap: break-word;">
                        {{ (appealData.app_cardID) }}
                      </q-card-section>
                    </q-card-section>
                    <q-card-section horizontal>
                      <q-card-section class="col-4 text-weight-bolder text-right text-h7 text-pink2">
                        อีเมล :
                      </q-card-section>
                      <q-card-section class="col-8" style="word-wrap: break-word;">
                        {{ (appealData.app_email) }}
                      </q-card-section>
                    </q-card-section>
                    <q-card-section horizontal>
                      <q-card-section class="col-4 text-weight-bolder text-right text-h7 text-pink2">
                        โทรศัพท์ :
                      </q-card-section>
                      <q-card-section class="col-8" style="word-wrap: break-word;">
                        {{ (appealData.app_tel) }}
                      </q-card-section>
                    </q-card-section>

                  </q-card>

                  <q-card class="q-mx-auto inset-box" style="max-width: 1200px;" flat bordered v-else>
                    <q-card-section class="bg-grey-1">
                      <div class="text-weight-bolder text-center text-h6">ข้อมูลส่วนตัว</div>
                    </q-card-section>
                    <q-separator />

                    <q-card-section horizontal>
                      <q-card-section class="col-12 text-weight-bolder text-center text-h6 text-orange-5">
                        ผู้แจ้งเรื่อง "ปกปิดข้อมูลส่วนตัว"
                      </q-card-section>


                    </q-card-section>
                  </q-card>

                  <br>
                </q-intersection>



                <q-intersection transition="scale" once>
                  <q-card class="q-mx-auto inset-box" style="max-width: 1200px;" flat bordered>
                    <q-card-section class="bg-grey-1">
                      <div class="text-weight-bolder text-center text-h6">เพิ่มเติม</div>
                    </q-card-section>
                    <q-separator />
                    <q-card-section horizontal>
                      <q-card-section class="col-4 text-weight-bolder text-right text-h7  text-pink2">
                        สถาณะ :
                      </q-card-section>
                      <q-card-section class="col-8" style="word-wrap: break-word;">
                        {{ appealData.status.status_name }}
                      </q-card-section>
                    </q-card-section>
                    <q-card-section horizontal>
                      <q-card-section class="col-4 text-weight-bolder text-right text-h7  text-pink2">
                        ผู้รับผิดชอบ :
                      </q-card-section>
                      <q-card-section class="col-8" style="word-wrap: break-word;">
                        {{ appealData.dep.dep_name }}
                      </q-card-section>
                    </q-card-section>
                  </q-card>
                  <br>
                </q-intersection>




              </div>
            </q-card>
          </div>

          <!--  ด้านขวา -->
          <div class="col-12 col-md-6 ">

            <q-card class="q-pa-md inset-left-right" style="height: 100%;" flat>

              <div class="q-px-lg ">


                <q-intersection transition="scale" once>
                  <q-card class="q-my-md q-pa-md inset-box bg-grey-1" flat bordered>
                    <div class="text-weight-bolder text-center text-h6">การดำเนินการ<q-btn flat round dense
                        color="primary" icon="table_view" @click="tabletimeline = true" /></div>
                  </q-card>
                </q-intersection>



                <q-timeline color="primary">
                  <q-timeline-entry
                    :icon="comment.comm_status_id == 1 ? 'near_me' : (comment.comm_status_id == 2 ? 'event' : (comment.comm_status_id == 3 ? 'done' : (comment.comm_status_id == 4 ? 'close' : (comment.comm_status_id == 5 ? 'replay' : (comment.comm_status_id == 6 ? 'near_me' : '?')))))"
                    :title="comment.comm_status_id == 1 ? 'ส่งเรื่อง' : (comment.comm_status_id == 2 ? 'การดำเนินการ' : (comment.comm_status_id == 3 ? 'ผลการดำเนินการ' : (comment.comm_status_id == 4 ? 'ปฏิเสธการรับ' : (comment.comm_status_id == 5 ? 'ตีกลับ' : (comment.comm_status_id == 6 ? 'ส่งต่อ' : 'id=???')))))"
                    :subtitle="formatDateShort(comment.created_at)" side="left"
                    :color="comment.comm_status_id == 1 ? 'info' : (comment.comm_status_id == 2 ? 'secondary' : (comment.comm_status_id == 3 ? 'accent' : (comment.comm_status_id == 4 ? 'accent' : (comment.comm_status_id == 5 ? 'deep-purple-9' : (comment.comm_status_id == 6 ? 'blue-13' : 'info')))))"
                    v-for="comment in filteredCommentsALL.slice().reverse()" :key="comment.id">

                    <!-- สร้าง q-timeline-entry สำหรับ comment ที่ comm_status_id เท่ากับ 1 -->
                    <div v-if="comment.comm_status_id == 1">
                      <q-card class="q-mx-auto inset-box bg-card-st1" style="max-width: 1400px;" flat>
                        <q-card-section horizontal>
                          <q-card-section class="col-4 text-weight-bolder text-right text-h7 text-pink2">
                            ส่งเรื่องไปที่ :
                          </q-card-section>
                          <q-card-section class="col-8" style="word-wrap: break-word;">
                            {{ comment.department.dep_name }}
                          </q-card-section>
                        </q-card-section>
                      </q-card>

                    </div>



                    <!-- สร้าง q-timeline-entry สำหรับ comment ที่ comm_status_id เท่ากับ 2 -->
                    <div v-else-if="comment.comm_status_id == 2">
                      <q-card class="q-mx-auto inset-box bg-card-st2" style="max-width: 1400px;" flat>
                        <q-card-section horizontal>
                          <q-card-section class="col-4 text-weight-bolder text-right text-h7 text-pink2">
                            รายละเอียด :
                          </q-card-section>
                          <q-card-section class="col-8" style="word-wrap: break-word;">
                            {{ comment.comment_details }}
                          </q-card-section>
                        </q-card-section>
                        <q-card-section horizontal>
                          <q-card-section class="col-4 text-weight-bolder text-right text-h7 text-pink2">
                            ผู้ดำเนินการ :
                          </q-card-section>
                          <q-card-section class="col-8" style="word-wrap: break-word;">
                            {{ comment.emp_name }}
                          </q-card-section>
                        </q-card-section>
                      </q-card>
                    </div>

                    <div v-else-if="comment.comm_status_id == 3">
                      <q-card class="q-mx-auto inset-box bg-card-st3" style="max-width: 1400px;" flat>
                        <q-card-section horizontal>
                          <q-card-section class="col-4 text-weight-bolder text-right text-h7 text-pink2">
                            ผลการดำเนินการ :
                          </q-card-section>
                          <q-card-section class="col-8" style="word-wrap: break-word;">
                            {{ comment.comment_details }}
                          </q-card-section>
                        </q-card-section>
                        <q-card-section horizontal>
                          <q-card-section class="col-4 text-weight-bolder text-right text-h7 text-pink2">
                            ผู้ดำเนินการ :
                          </q-card-section>
                          <q-card-section class="col-8" style="word-wrap: break-word;">
                            {{ comment.emp_name }}
                          </q-card-section>
                        </q-card-section>
                      </q-card>
                    </div>

                    <div v-else-if="comment.comm_status_id == 4">
                      <q-card class="q-mx-auto inset-box bg-card-st3" style="max-width: 1400px;" flat>
                        <q-card-section horizontal>
                          <q-card-section class="col-4 text-weight-bolder text-right text-h7 text-pink2">
                            การดำเนินการ :
                          </q-card-section>
                          <q-card-section class="col-8" style="word-wrap: break-word;">
                            ปฏิเสธการรับ
                          </q-card-section>
                        </q-card-section>
                      </q-card>
                    </div>

                    <div v-else-if="comment.comm_status_id == 5">
                      <q-card class="q-mx-auto inset-box bg-card-st5" style="max-width: 1400px;" flat>
                        <q-card-section horizontal>
                          <q-card-section class="col-4 text-weight-bolder text-right text-h7 text-pink2">
                            จาก :
                          </q-card-section>
                          <q-card-section class="col-8" style="word-wrap: break-word;">
                            {{ comment.department.dep_name }}
                          </q-card-section>
                        </q-card-section>
                        <q-card-section horizontal>
                          <q-card-section class="col-4 text-weight-bolder text-right text-h7 text-pink2">
                            เหตุผล :
                          </q-card-section>
                          <q-card-section class="col-8" style="word-wrap: break-word;">
                            {{ comment.comment_details }}
                          </q-card-section>
                        </q-card-section>
                        <q-card-section horizontal>
                          <q-card-section class="col-4 text-weight-bolder text-right text-h7 text-pink2">
                            ผู้ดำเนินการ :
                          </q-card-section>
                          <q-card-section class="col-8" style="word-wrap: break-word;">
                            {{ comment.emp_name }}
                          </q-card-section>
                        </q-card-section>
                      </q-card>
                    </div>

                    <div v-else-if="comment.comm_status_id == 6">
                      <q-card class="q-mx-auto inset-box bg-card-st5" style="max-width: 1400px;" flat>
                        <q-card-section horizontal>
                          <q-card-section class="col-4 text-weight-bolder text-right text-h7 text-pink2">
                            กอง :
                          </q-card-section>
                          <q-card-section class="col-8" style="word-wrap: break-word;">
                            {{ comment.department.dep_name }}
                          </q-card-section>
                        </q-card-section>
                        <q-card-section horizontal>
                          <q-card-section class="col-4 text-weight-bolder text-right text-h7 text-pink2">
                            เหตุผล :
                          </q-card-section>
                          <q-card-section class="col-8" style="word-wrap: break-word;">
                            {{ comment.comment_details }}
                          </q-card-section>
                        </q-card-section>
                        <q-card-section horizontal>
                          <q-card-section class="col-4 text-weight-bolder text-right text-h7 text-pink2">
                            ผู้ดำเนินการ :
                          </q-card-section>
                          <q-card-section class="col-8" style="word-wrap: break-word;">
                            {{ comment.emp_name }}
                          </q-card-section>
                        </q-card-section>

                      </q-card>
                    </div>


                    <!-- สร้าง q-timeline-entry สำหรับ comment ที่ไม่ได้อยู่ในเงื่อนไขด้านบน (comm_status_id อื่น ๆ) -->
                    <div v-else>
                      texts id {{ comment.comm_status_id }}
                    </div>
                  </q-timeline-entry>

                  <q-timeline-entry icon="notifications" title="เรื่องเข้าสู่ระบบ"
                    :subtitle="formatDateShort(appealData.created_at)">
                    <q-intersection transition="jump-down" once>


                      <q-card class="q-mx-auto inset-box bg-card-st0" style="max-width: 1400px;" flat>
                        <q-card-section horizontal>
                          <q-card-section class="col-4 text-weight-bolder text-right text-h7 text-pink2">
                            การดำเนินการ :
                          </q-card-section>
                          <q-card-section class="col-8" style="word-wrap: break-word;">
                            รอเจ้าหน้าที่รับเรื่อง
                          </q-card-section>
                        </q-card-section>
                      </q-card>

                    </q-intersection>
                  </q-timeline-entry>

                </q-timeline>


              </div>

            </q-card>

          </div>

        </div>


      </div>






























      <div v-else>
        <q-card class="q-pa-md inset-left-right" style="height: 100%;" flat>
          <div class="row justify-center">
            <q-spinner class="q-mx-auto" color="primary" size="3em" />
          </div>
        </q-card>
      </div>











    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { useAppealStore } from "../../store/ViewAppeal";
import { useUserStore } from "../../store/auth";
import { ref, computed } from 'vue'
import Swal from 'sweetalert2'





export default {

  setup() {


    const userStore = useUserStore();

    const user = computed(() => userStore.useremp);

    const userToken = localStorage.getItem('user'); // ดึง Token จาก Local Storage


    return {
      userToken,
      user,
      dialog: ref(false),
      updateapp: ref(false),
      updateapp2: ref(false),
      updateapp6: ref(false),
      closeapp: ref(false),
      cancelEnabled: ref(false),
      isactive: ref(false),
      tabletimeline: ref(false),
    }
  },

  data() {
    return {
      app_id: this.$route.params.app_id, // หมายเลขเอกสารจาก URL
      appealData: ref(''),
      appId: null, // เก็บข้อมูล appeal ที่ได้จาก API หรือฐานข้อมูล
      options: [],
      emdep: ref(null),
      detail: '',
      emname: '',
      toemdep: ref(null),
      todetail: '',
      toemname: '',
      detailend: '',
      emnameend: '',
      loading: false,
      detailRules: [
        val => !!val || 'กรุณากรอกรายละเอียด' // ตรวจสอบว่าค่าไม่เป็นค่าว่าง
      ],
      emnameRules: [
        val => !!val || 'กรุณากรอกรายละเอียด' // ตรวจสอบว่าค่าไม่เป็นค่าว่าง
      ],
      emdepRules: [
        val => !!val || 'กรุณากรอกรายละเอียด' // ตรวจสอบว่าค่าไม่เป็นค่าว่าง
      ],


      columns: [




        {
          name: 'comm_status_id',
          required: true,
          label: 'สถานะ',
          align: 'left',
          field: row => row.comm_status_id
        },

        {
          name: 'department.dep_name',
          required: true,
          label: 'หน่วยงาน',
          align: 'left',
          field: row => row.department.dep_name
        },


        {
          name: 'comment_details',
          required: true,
          label: 'รายละเอียด',
          align: 'left',
          field: 'comment_details'
        },

        {
          name: 'emp_name',
          required: true,
          label: 'ผู้ดำเนินการ',
          align: 'left',
          field: 'emp_name'
        },

        {
          name: 'created_at',
          required: true,
          label: 'วันที่ดำเนินการ',
          align: 'left',
          field: row => this.formatDateShort(row.created_at)
        }
      ]

    };
  },
  mounted() {
    this.loadAppealData();
    this.loadDepartmentData();
  },
  computed: {
    filteredComments() {
      if (this.appealData && this.appealData.comments) {
        return this.appealData.comments.filter(comment => comment.comm_status_id === "2");
      }
      return [];
    },
    filteredCommentsstr3() {
      if (this.appealData && this.appealData.comments) {
        return this.appealData.comments.filter(comment => comment.comm_status_id === "3");
      }
      return [];
    },
    filteredCommentsstr5() {
      if (this.appealData && this.appealData.comments) {
        return this.appealData.comments.filter(comment => comment.comm_status_id === "5");
      }
      return [];
    },

    filteredCommentsALL() {
      if (this.appealData && this.appealData.comments) {
        return this.appealData.comments;
      }
      return [];
    },
  },
  methods: {

    resetval() {
      this.detail = '';
      this.emname = '';
      this.detailend = '';
      this.emnameend = '';
      this.toemdep = '';
      this.todetail = '';
      this.toemname = '';
      this.$refs.resetform.reset();
    },
    


    loadAppealData() {
      const userToken = this.userToken // ดึง Token จาก Local Storage

      if (!userToken) {
        // กรณีที่ไม่พบ Token ใน Local Storage
        console.error('ไม่พบ Bearer Token ใน Local Storage');
        return;
      }

      const config = {
        headers: {
          Authorization: `Bearer ${userToken}`
        }
      };

      axios
        .get(`${import.meta.env.VITE_API}/employee/appeal2/${this.app_id}`, config)
        .then((response) => {
          this.appealData = response.data.data;
          this.appId = response.data.data.app_id;
          console.log('appealData:', this.appealData);
          console.log('appId:', this.appId);
          console.log('user:', this.user);
        })
        .catch((error) => {
          console.error('เกิดข้อผิดพลาดในการโหลดข้อมูล:', error);
        });

    },

    async loadDepartmentData() {
      try {
        const userToken = this.userToken // ดึง Token จาก Local Storage

        if (!userToken) {
          // กรณีที่ไม่พบ Token ใน Local Storage
          console.error('ไม่พบ Bearer Token ใน Local Storage');
          return;
        }

        const config = {
          headers: {
            Authorization: `Bearer ${userToken}`
          }
        };

        const response = await axios.get(`${import.meta.env.VITE_API}/employee/department`, config); // แก้ไข URL API ตามที่คุณต้องการ

        // แปลงข้อมูล department เพื่อให้เข้ากับรูปแบบ options
        this.options = response.data.data.map(department => ({
          label: department.dep_name,
          id: department.dep_id
        }));
      } catch (error) {
        console.error('เกิดข้อผิดพลาดในการโหลดข้อมูล department:', error);
      }
    },


    async onSubmit() {
      const app_id = this.appId;
      const emdep = this.emdep;

      const form = {
        comment_details: this.detail,
        emp_name: this.emname,
        dep_id: emdep.id
      };
      Swal.fire({
        title: 'กำลังดำเนินการ',
        text: 'กรุณารอสักครู่...',
        didOpen: () => {
          Swal.showLoading();
        }
      });
      const userToken = this.userToken; // ดึง Token จาก Local Storage

      const config = {
        headers: {
          Authorization: `Bearer ${userToken}`
        }
      };
      const userStore = useAppealStore();
      await userStore.createcomment(app_id, form, config);
      Swal.close();
      this.loadAppealData();
    },

    async onSubmit2() {
      try {
        this.updateapp2 = false;

        const app_id = this.appId;
        const form = {
          comment_details: this.detail,
          emp_name: this.emname,
          department_id: this.user.department_id,
        };

        Swal.fire({
          title: 'กำลังดำเนินการ',
          text: 'กรุณารอสักครู่...',
          didOpen: () => {
            Swal.showLoading();
          }
        });

        const userToken = this.userToken;
        const config = {
          headers: {
            Authorization: `Bearer ${userToken}`
          }
        };

        const userStore = useAppealStore();
        await userStore.createcomment(app_id, form, config);

        Swal.close();
        this.loadAppealData();

      } catch (error) {
        console.error('เกิดข้อผิดพลาดในการส่งข้อมูล:', error);
        Swal.fire({
          title: 'เกิดข้อผิดพลาด',
          text: 'ไม่สามารถส่งข้อมูลได้ กรุณาลองใหม่อีกครั้ง',
          icon: 'error'
        });
      } finally {
        // Reset comment_details to empty after submission
        this.detail = '';
        this.emname = '';

      }
    },



    async onSubmit6() {
      try {
        this.updateapp6 = false;
        const user_dep_id = this.user.department_id;
        const app_id = this.appId;
        const emdep = this.toemdep;
        const form = {
          comment_details: this.todetail,
          emp_name: this.toemname,
          dep_id: emdep.id
        };

        if (user_dep_id === emdep.id) {
      throw new Error('ไม่สามารถ "ส่งต่อ" ไปยังแผนกนี้ได้');
    }
        Swal.fire({
          title: 'กำลังดำเนินการ',
          text: 'กรุณารอสักครู่...',
          didOpen: () => {
            Swal.showLoading();
          }
        });

        const userToken = this.userToken;
        const config = {
          headers: {
            Authorization: `Bearer ${userToken}`
          }
        };

        const userStore = useAppealStore();
        await userStore.sendtocomment(app_id, form, config);

        Swal.close();
        this.loadAppealData();

      } catch (error) {
        console.error('เกิดข้อผิดพลาดในการส่งข้อมูล:', error);
        Swal.fire({
          title: 'เกิดข้อผิดพลาด',
          text: 'ไม่สามารถ "ส่งต่อ" ไปยังแผนกนี้ได้',
          icon: 'error'
        });
      } finally {
        // Reset comment_details to empty after submission
        this.todetail = '';
        this.toemname = '';
        this.toemdep = '';

      }
    },


    async showSweetAlert() {
      
      // You can customize the Swal configuration as needed
      this.closeapp = false;
      const app_id = this.appId;
      const form = {
        comment_details: this.detailend,
        emp_name: this.emnameend,
        department_id: this.user.department_id,
      };
      Swal.fire({
        title: 'กำลังดำเนินการ',
        text: 'กรุณารอสักครู่...',
        didOpen: () => {
          Swal.showLoading();
        }
      });
      const userToken = this.userToken // ดึง Token จาก Local Storage
      const config = {
        headers: {
          Authorization: `Bearer ${userToken}`
        }
      };
      const userStore = useAppealStore();
      await userStore.closeapp(app_id, form, config);
      Swal.close();
      this.loadAppealData();
    },

    formatDate(updatedAt) {
      // Create a Date object from the updatedAt value
      const date = new Date(updatedAt);

      // Define options for formatting the date and time
      const options = {
        year: 'numeric', // Display the year
        month: 'long',   // Display the full month name
        day: 'numeric',  // Display the day of the month
        hour: 'numeric', // Display the hour
        minute: 'numeric', // Display the minute
        hour12: false,   // Use 24-hour format
      };

      // Use Intl.DateTimeFormat to format the date and time
      const formattedDate = new Intl.DateTimeFormat('th-TH', options).format(date);

      // Return the formatted date
      return `วันที่ ${formattedDate} น.`;
    },


    formatDateShort(updatedAt) {
      // สร้างวัตถุ Date จากค่า updatedAt
      const date = new Date(updatedAt);

      // กำหนดรูปแบบวันที่และเวลาเป็นรูปแบบไทย
      const options = {
        year: 'numeric',
        month: 'numeric',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        hour12: false,
      };
      // ใช้ Intl.DateTimeFormat เพื่อรูปแบบวันที่และเวลา
      const formattedDate = new Intl.DateTimeFormat('th-TH', options).format(date);

      return `${formattedDate} น.`;
    },


    goBack() {
      this.$router.push(`/AdminEmployee/CheckStatusAppeal/`); // ให้กลับไปยังแท็บก่อนหน้า
    },


    reject() {
      Swal.fire({
        title: "คุณแน่ใจหรือไม่?",
        html: "<strong>คำเตือน</strong> คุณจะไม่สามารถดำเนินการเกี่ยวกับเอกสารนี้ได้อีก<br> กดยืนยันหากคุณต้องการปฏิเสธเรื่องร้องเรียนนี้!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#54b59A",
        cancelButtonColor: "#ce5374",
        confirmButtonText: "ยืนยัน",
        cancelButtonText: "ยกเลิก"
      }).then(async (result) => {
        if (result.isConfirmed) {
          const form = {
            department_id: this.user.department_id,
          };

          Swal.fire({
            title: 'กำลังดำเนินการ',
            text: 'กรุณารอสักครู่...',
            didOpen: () => {
              Swal.showLoading();
            }
          });

          try {
            const app_id = this.appId;
            const userStore = useAppealStore();
            const userToken = this.userToken; // Fetch Token from Local Storage
            const config = {
              headers: {
                Authorization: `Bearer ${userToken}`
              }
            };
            await userStore.rejectappeal(app_id, form, config);
            Swal.close();
            this.loadAppealData();
            this.$router.push('/AdminEmployee/CheckStatusAppeal');

          } catch (error) {
            Swal.fire({
              title: "เกิดข้อผิดพลาด!",
              text: error.message || "มีข้อผิดพลาดเกิดขึ้นในการปฏิเสธเรื่องร้องเรียน",
              icon: "error"
            });
          }
        }
      });
    }


  },

};
</script>

<style lang="scss" scoped>
.inset-box {
  /*  box-shadow:  -10px 0px 10px -10px rgba(30, 197, 57, 0.5),; */
  border-radius: 15px;
  /* กำหนดขอบโค้งให้กับกรอบ */
}

.inset-left-right {
  /*  box-shadow:  -10px 0px 10px -10px rgba(30, 197, 57, 0.5),; */
  border-radius: 0px;
  /* กำหนดขอบโค้งให้กับกรอบ */
}

.bg-card-st0 {
  background-color: #2bad5231;
}

.bg-card-st5 {
  background-color: #54b59a2f;
}

.bg-card-st2 {
  /* background-color: #ccf5f5; */
  background-color: rgba(248, 243, 197, 0.719);
  /* สีพื้นหลังที่คุณต้องการ */
}

.bg-card-st3 {
  /*  background-color: #ccf5f5; */
  background-color: #ce53742a;
  /* สีพื้นหลังที่คุณต้องการ */
}

.bg-card-st1 {
  /* background-color: #31cdec21; */
  background-color: #06a9db17;
}

.bg-card-st6 {
  background-color: #31cdec21;
}

.text-pink2 {
  color: #d3217e;
}

.text-green2 {
  color: #43967a;

}

.black-bg {
  background-color: rgb(0, 0, 0) !important;
}
</style>
