import axios from "axios";

export default async function (to, from, next) {
  const userToken = localStorage.getItem('user');

  if (!userToken) {
    next();
  } else {
    try {


      const userDetails = await axios.get(`${import.meta.env.VITE_API}/employee/details`, {
        headers: {
          Authorization: 'Bearer ' + userToken
        }
      });

      const emDetailsAppeal = await axios.get(`${import.meta.env.VITE_API}/employee/appeal2/${to.params.app_id}`, {
        headers: {
          Authorization: 'Bearer ' + userToken
        }
      });

      /* console.log('userDetails.data.department_id:', userDetails.data.data.department_id);
      console.log('emDetailsAppeal.data.dep_id:', emDetailsAppeal.data.data.dep_id); */

      if (userDetails.data.data.department_id === emDetailsAppeal.data.data.dep_id) {
        next(); 
      } else {
        next(false); 
      history.back(); 
      }
    } catch (error) {
      console.error('Error:', error);
    /*   localStorage.removeItem('user');
      localStorage.removeItem('tab'); */
      next(false); 
      history.back(); 
    }
  }
}
