import { defineStore } from "pinia";
import router from "../router";
import axios from 'axios';
import Swal from 'sweetalert2';

export const useUserStore = defineStore("useUserStore", {
    state: () => ({
        user: null,
    }),
    getters: {
        useremp(state) {
            return state.user
        },
    },
    actions: {
        async fetchUser() {
            const response = await axios.get(`${import.meta.env.VITE_API}/employee/details`, {
                headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('user')
                }
            });
            this.user = response.data.data;
           
        },

        async fetchUserEm() {
            const response = await axios.get(`${import.meta.env.VITE_API}/user/details`, {
                headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('user')
                }
            });
            this.user = response.data.data;
        },

        async signInEmployee(form) {
            try {
                const response = await axios.post(`${import.meta.env.VITE_API}/employee/login`, form);
                const token = response.data.token;
                localStorage.setItem('user', token);

                // นำทางไปยังหน้าที่ถูกต้องตามค่า 'employee_role_id' จาก API login
                if (response.data.employee_role_id === "1") {
                    router.push('/AdminEmployee/CheckStatusAppeal');
                } else {
                    router.push('/Employee/CheckStatusAppeal');
                }
            } catch (error) {
                if (error.response.status === 401) {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: error.response.data.message,
                    });
                }
            }
        },

        async signInUser(form) { // Change the action name to signInUser
            try {
                const response = await axios.post(`${import.meta.env.VITE_API}/user/login`, form); // Use the user login API
                const token = response.data.token;
                localStorage.setItem('user', token)
                router.push('user/appeal') // Change the route to 'dashboard/employee'
            } catch (error) {
                if (error.response.status === 401) {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: error.response.data.message,
                    })
                }
            }
        },

        async handleLogout() {
            try {
                // รับโทเค็นการเข้าสู่ระบบจาก localStorage หรือตำแหน่งที่เก็บโทเค็นของคุณ
                const token = localStorage.getItem('user');

                // ตรวจสอบว่ามีโทเค็นหรือไม่
                if (!token) {
                    console.error('ไม่มีโทเค็นการเข้าสู่ระบบ');
                    return;
                }

                // เรียกใช้ API ออกจากระบบด้วยโทเค็นการเข้าสู่ระบบ
                const response = await axios.post(`${import.meta.env.VITE_API}/user/logout`, null, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                });

                // หลังจากออกจากระบบสำเร็จ คุณสามารถล้างโทเค็นการเข้าสู่ระบบออกจาก localStorage
                localStorage.removeItem('user');
                localStorage.removeItem('tab');
                // หลังจากออกจากระบบสำเร็จ คุณสามารถนำผู้ใช้ไปยังหน้าหลักหรือหน้าเข้าสู่ระบบอื่น ๆ ตามที่คุณต้องการ
                router.push('/'); // เปลี่ยนเส้นทางไปยังหน้าเข้าสู่ระบบหรือหน้า login
            } catch (error) {
                // ในกรณีที่มีข้อผิดพลาดในการเรียก API คุณสามารถจัดการข้อผิดพลาดที่นี่
                console.error('เกิดข้อผิดพลาดในการออกจากระบบ:', error);
            }
        },


        async register(email, password) {
            try {
                const response = await axios.post(`${import.meta.env.VITE_API}/user/register`, {
                    email: email,
                    password: password,
                    // อื่น ๆ ที่คุณต้องการส่งไปยัง API
                });

                // หลังจากลงทะเบียนสำเร็จ
                if (response.status === 200) {
                    // ดึง token จาก response.data และเก็บไว้ใน localStorage
                    const token = response.data.token;
                    localStorage.setItem('user', token);

                    // แสดง SweetAlert แจ้งเตือนสำเร็จ
                    await Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ',
                        text: 'คุณได้ลงทะเบียนสำเร็จแล้ว!',
                    });

                    // เรียกใช้งานฟังก์ชันเข้าสู่ระบบหลังจากลงทะเบียน
                    router.push('/user/appeal');
                }

            } catch (error) {
                // ในกรณีที่เกิดข้อผิดพลาดในการลงทะเบียน
                console.error('เกิดข้อผิดพลาดในการลงทะเบียน:', error);
                if (error.response && error.response.data && error.response.data.message) {
                    await Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: error.response.data.message,
                    });
                } else {
                    await Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: 'มีข้อผิดพลาดในการลงทะเบียน',
                    });
                }
            }
        },
        async sendreset(email) {
            try {
                const response = await axios.post(`${import.meta.env.VITE_API}/sendreset`, {
                    email: email                    // อื่น ๆ ที่คุณต้องการส่งไปยัง API
                });

                // หลังจากลงทะเบียนสำเร็จ
                if (response.status === 200) {
                    // แสดง SweetAlert แจ้งเตือนสำเร็จ
                    await Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ',
                        text: response.data.message,
                    });

                    // เรียกใช้งานฟังก์ชันเข้าสู่ระบบหลังจากลงทะเบียน
                    //router.push('/user/appeal');
                }

            } catch (error) {
                // ในกรณีที่เกิดข้อผิดพลาดในการลงทะเบียน
                if (error.response.status === 404) {
                    await Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: error.response.data.message,
                    });
                }
                if (error.response.status === 500) {
                    await Swal.fire({
                        icon: 'error',
                        title: 'กรุณาลองอีกครั้งภายหลัง (3นาที)',
                        text: error.response.data.message,
                    });
                }
            }
        },
        async resetpassword(password,token) {
            try {
                const response = await axios.post(`${import.meta.env.VITE_API}/reset/${token}`, {
                    password: password,
                });

                // หลังจากลงทะเบียนสำเร็จ
                if (response.status === 200) {
                    // แสดง SweetAlert แจ้งเตือนสำเร็จ
                    await Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ',
                        text: response.data.message,
                    });

                    // เรียกใช้งานฟังก์ชันเข้าสู่ระบบหลังจากลงทะเบียน
                    router.push('/login');
                }

            } catch (error) {
                // ในกรณีที่เกิดข้อผิดพลาดในการลงทะเบียน
                if (error.response.status === 404) {
                    await Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: error.response.data.message,
                    });
                }
            }
        }
    },
});
