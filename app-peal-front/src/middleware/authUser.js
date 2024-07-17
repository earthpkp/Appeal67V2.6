import Swal from "sweetalert2";
import axios from "axios";
export default async function (to, from, next) {
  const token = localStorage.getItem('user');
  if (!token) {
        next('/login');
  } else {
    try {
      const response = await axios.get(`${import.meta.env.VITE_API}/user/details`, {
        headers: {
          Authorization: 'Bearer ' + token
        }
      });
      if (response.status === 200) {
        next();
      }
    } catch (error) {
      if (error.response.status === 401){
        localStorage.removeItem('user')
        localStorage.removeItem('tab')
        next('/login');
      }
    }
  }
}
