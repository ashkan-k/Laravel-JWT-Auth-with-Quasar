<template>
  <q-layout>
    <q-page-container>
      <q-page class="flex bg-image flex-center">
        <q-card v-bind:style="$q.screen.lt.sm?{'width': '80%'}:{'width':'30%'}">
          <q-card-section>
            <q-form
              @submit.prevent="Register"
              class="q-ma-md q-gutter-md"
            >
              <q-input
                filled
                :rules="[val => val.length > 0 || 'نام باید وارد شود']" dense
                v-model="name"
                label="Name"
                lazy-rules
              />

              <q-input
                filled
                :rules="[val => val.length > 0 || 'نام خانوادگی باید وارد شود']" dense
                v-model="family"
                label="Family"
                lazy-rules
              />

              <q-input
                filled
                :rules="[val => val.length > 0 || 'نام کاربری باید وارد شود']" dense
                v-model="username"
                label="Username"
                lazy-rules
              />

              <q-input
                filled
                :rules="[val => val.length > 0 || 'ایمیل باید وارد شود']" dense
                type="email"
                v-model="email"
                label="Email"
                lazy-rules
              />

              <q-input
                type="password"
                filled
                :rules="[val => val.length > 0 || 'رمز عبور باید وارد شود']" dense
                v-model="password"
                label="Password"
                lazy-rules

              />

              <q-space></q-space>
              Did you registered ?!! <router-link to="/login"> Login Now </router-link>

              <div>
                <q-btn label="Register" type="submit" color="primary"/>
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
  name: 'register',

  data () {
    return {
      name: '',
      family: '',
      email: '',
      username: '',
      password: ''
    }
  },

  methods: {
    Register () {
      const app = this

      const formData = new FormData()

      formData.append('name', this.name)
      formData.append('family', this.family)
      formData.append('email', this.email)
      formData.append('username', this.username)
      formData.append('password', this.password)

      app.$q.loading.show()
      this.$axios.post(process.env.api + 'api/auth/register', formData)
        .then(function (response) {
          if (response.data.status === true) {
            app.showNotif('ثبت نام با موفقیت انجام شد . اکنون میتوانید وارد شوید', 'mdi-checkbox-marked-circle-outline ', 'green')
            app.$router.push('/login')
          } else {
            app.showNotif(response.data.error)
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
    },

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
    }
  },

  mounted () {
    this.isLogin()
  }
}
</script>

<style scoped>

</style>
