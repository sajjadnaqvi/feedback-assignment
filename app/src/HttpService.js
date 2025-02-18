import axios from 'axios';
import store from '@/store';

const API_URL = 'http://localhost:8082/api';

const axiosInstance = axios.create({
  baseURL: API_URL,
  headers: {
    'Content-Type': 'application/json'
  }
});

export const makeRequest = async (method, url, data = null, params = {}) => {

    try {
      const accessToken = store.state.accessToken; 
      axiosInstance.defaults.headers.common['Authorization'] = `Bearer ${accessToken}`;
      const response = await axiosInstance.request({
        method,
        url,
        data,
        params
      });
      return response.data;
    } catch (error) {
      throw new Error(error.response.data.message || 'An error occurred');
    }
  };