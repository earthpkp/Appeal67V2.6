import axios from "axios";
export default async function (to, from, next) {
  const token = localStorage.getItem('user');
  if (!token) {
    next('/login');
  } else {
    try {
      const response = await axios.get('http://192.168.168.40:8000/api/employee/details', {
        headers: {
          Authorization: 'Bearer ' + token
        }
      });
      if (response.status === 200) {
        next();
      }
    } catch (error) {
      if (error.response.status === 401)
        localStorage.removeItem('user')
        localStorage.removeItem('tab')
      next('/login');
    }
  }
}
