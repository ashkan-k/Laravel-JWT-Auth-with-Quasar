<template>
  <q-page class="flex flex-center">
    <img
      alt="Quasar logo"
      width="270"
      src="~assets/Blazar-Logo.svg"
    >
  </q-page>
</template>

<script>
export default {
  name: 'PageIndex',

  methods: {
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

      this.$axios.post(process.env.api + 'api/auth/isLogin')
        .then(function (response) {
          if (response.data.isLogin === false) {
            app.$router.push('/login')
          }
        })
    }
  }
}
</script>
