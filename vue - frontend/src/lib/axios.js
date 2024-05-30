import Axios from 'axios';

const axios = Axios.create({
    baseURL: "http://127.0.0.1:8000",
    withCredentials: true,
});

axios.interceptors.request.use(config => {
    config.headers.Authorization = 'Bearer ' + localStorage.getItem('token');
    config.headers['Content-Type'] = 'application/json';
    config.headers.Accept = 'application/json';
    return config;
});

axios.interceptors.response.use(null, (err) => {
    switch (err.response?.status) {
        case 401:
            alert('Missing correct credentials')
            break;

        case 500:
            alert('Something went wrong. Please try again')
            break;

        case 403:
            alert('You are not allowed')
            break;

        default:
            break;
    }
})

export default axios;
