import axios from "axios";

export default async function (to, from, next) {
  const token = localStorage.getItem('user');

  if (!token) {
    next('/login');
  } else {
    try {
      const response = await axios.get(`${import.meta.env.VITE_API}/employee/details`, {
        headers: {
          Authorization: 'Bearer ' + token
        }
      });

      if (response.status === 200 && response.data.data.employee_role_id === "2") {
        // ตรวจสอบ 'employee_role_id' และอนุญาตให้ผู้ใช้เข้าถึงหน้านี้
        next();
      } else {
        next('/login'); // นำทางผู้ใช้ไปยังหน้า '/login' ถ้าไม่มีสิทธิ์
      }
    } catch (error) {
      if (error.response.status === 401) {
        localStorage.removeItem('user');
        localStorage.removeItem('tab');
      }
      next('/login');
    }
  }
}
