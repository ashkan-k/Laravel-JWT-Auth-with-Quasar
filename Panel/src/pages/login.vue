<template>
  <q-layout>
    <q-page-container>
      <q-page class="flex bg-image flex-center">
        <q-card v-bind:style="$q.screen.lt.sm?{'width': '80%'}:{'width':'30%'}">
          <q-card-section>
            <q-form
              @submit.prevent="Login"
              class="q-ma-md q-gutter-md"
            >
              <q-input
                filled
                v-model="username"
                label="Username"
                lazy-rules
              />

              <q-input
                type="password"
                filled
                v-model="password"
                label="Password"
                lazy-rules

              />

              <q-space></q-space>
              Your dont have account ?!! <router-link to="/register"> Register Now </router-link>

              <div>
                <q-btn label="Login" type="submit" color="primary"/>
              </div>
            </q-form>
          </q-card-section>
        </q-card>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script>
export default {
  data () {
    return {
      username: '',
      password: ''
    }
  },

  methods: {
    isLogin () {
      const app = this

      app.$q.loading.show()
      this.$axios.post(process.env.api + 'api/auth/isLogin')
        .then(function (response) {
          if (response.data.isLogin === true) {
            app.$router.push('/')
          }
        })
        .finally(function () {
          app.$q.loading.hide()
        })
    },

    Login () {
      const app = this

      const formData = new FormData()
      formData.append('username', this.username)
      formData.append('password', this.password)

      app.$q.loading.show()
      this.$axios.post(process.env.api + 'api/auth/login', formData)
        .then(function (response) {
          if (response.data.status === true) {
            localStorage.setItem('token', response.data.access_token)
            app.$axios.defaults.headers.common.Authorization = 'Bearer' + ' ' + response.data.access_token

            app.$store.commit('JwtLaravel/setUserData', response.data.user)

            app.$router.push('/')
          } else {
            app.showNotif('شماره تلفن / رمز عبور صحیح نیست!')
          }
        })
        .finally(function () {
          app.$q.loading.hide()
        })
    },

    showNotif (message, icon = 'error', color = 'red') {
      this.$q.notify({
        message: message,
        icon: icon,
        color: color,
        position: 'bottom-right',
        progress: true
      })
    }
  },

  mounted () {
    this.isLogin()
  }
}
</script>

<style>
.bg-image {
  background-image: linear-gradient(135deg, #061a47 0%, #01112f 100%);
}
</style>
