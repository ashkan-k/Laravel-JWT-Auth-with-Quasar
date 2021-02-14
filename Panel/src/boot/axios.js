import Vue from 'vue'
import axios from 'axios'

Vue.prototype.$axios = axios

const token = 'Bearer' + ' ' + localStorage.token
axios.defaults.headers.common.Authorization = token
