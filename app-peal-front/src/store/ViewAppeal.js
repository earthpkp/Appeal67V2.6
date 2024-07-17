import { defineStore } from "pinia";
import axios from 'axios';
import Swal from 'sweetalert2';

export const useAppealStore = defineStore("useAppealStore", {

    actions: {
        async createcomment(app_id, form, email, config) {
            try {
                const response = await axios.post(`${import.meta.env.VITE_API}/create/comment/${app_id}`, form, email, config);
                if (response.status === 200) {
                    // Show success message
                    await Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ',
                        text: response.data.message,
                    });
                }
            } catch (error) {
                if (error.response.status === 404) {
                    await Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: error.response.data.error,
                    });
                }
            }
        },
        async sendtocomment(app_id, form, email, config) {
            try {
                const response = await axios.post(`${import.meta.env.VITE_API}/sendto/appeal/${app_id}`, form, email, config);
                if (response.status === 200) {
                    // Show success message
                    await Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ',
                        text: response.data.message,
                    });
                }
            } catch (error) {
                if (error.response.status === 404) {
                    await Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: error.response.data.error,
                    });
                }
            }
        },
        async closeapp(app_id, form, config) {
            try {
                const response = await axios.post(`${import.meta.env.VITE_API}/update/comment/${app_id}`, form, config);
                // หลังจากลงทะเบียนสำเร็จ
                if (response.status === 200) {
                    // แสดง SweetAlert แจ้งเตือนสำเร็จ
                    await Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ',
                        text: response.data.message,
                    });
                }

            } catch (error) {
                // ในกรณีที่เกิดข้อผิดพลาดในการลงทะเบียน
                if (error.response.status === 404) {
                    await Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: error.response.data.error,
                    });
                }
            }
        },
        
        async rejectappeal(app_id, form, config) {
            try {
                const response = await axios.post(`${import.meta.env.VITE_API}/reject/appeal/${app_id}`, form, config);
                // After successful rejection
                if (response.status === 200) {
                    // Display success notification using SweetAlert
                    await Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ',
                        text: response.data.message,
                    });
                }
            } catch (error) {
                // Check if error.response exists
                if (error.response && error.response.status === 404) {
                    await Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: error.response.data.error,
                    });
                } else {
                    // Show a default error message in case of no response or other errors
                    await Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: 'มีข้อผิดพลาดเกิดขึ้นในการดำเนินการ',
                    });
                }
            }
        },
        

        async returnapp(app_id, form, config) {
            try {
                const response = await axios.post(`${import.meta.env.VITE_API}/return/appeal/${app_id}`, form, config);
                // หลังจากลงทะเบียนสำเร็จ
                if (response.status === 200) {
                    // แสดง SweetAlert แจ้งเตือนสำเร็จ
                    await Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ',
                        text: response.data.message,
                    });
                }

            } catch (error) {
                // ในกรณีที่เกิดข้อผิดพลาดในการลงทะเบียน
                if (error.response.status === 404) {
                    await Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: error.response.data.error,
                    });
                }
            }
        },

    },
});
