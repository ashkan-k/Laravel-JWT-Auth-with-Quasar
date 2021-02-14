<template>
  <q-page class="q-pa-sm">
    <div class="row q-col-gutter-sm" style="margin: 10px 12px !important;">
      <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
        <q-card class="bg-white text-black ">
          <q-card-section class="text-h6 ">
            <div class="text-h5 text-dark q-mb-md ">ویرایش اطلاعات حساب</div>
          </q-card-section>
          <q-card-section class="q-pa-sm">
            <q-form
              @submit="updateProfile">
              <q-list class="row">
                <q-item class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <q-item-section side>
                    <div class="field-label q-mb-lg text-grey-8"> تصویر پرفایل<span class="text-red"
                                                                                    style="font-size: 18px !important;">*</span>
                    </div>
                    <q-item-section class="q-mb-md" side>
                      <q-avatar size="150px">
                        <img :src="getimage()">
                      </q-avatar>
                    </q-item-section>
                    <q-uploader :hide-upload-btn="true" ref="uploadFile"
                                :style="$q.screen.width <= 481 ? 'width: 100%' : ''"/>
                  </q-item-section>
                </q-item>
                <q-separator class="q-ma-lg"/>
                <q-item class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <h5>اطلاعات فردی :</h5>
                </q-item>
                <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  <q-item-section>
                    <div class="field-label text-grey-8">نام <span class="text-red"
                                                                   style="font-size: 18px !important;">*</span></div>
                    <q-input dense v-model="userDetails.name" lazy-rules
                             :rules="[val => val.length > 0 || 'لطفا نام خود را وارد کنید']"/>

                  </q-item-section>
                </q-item>
                <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  <q-item-section>
                    <div class="field-label text-grey-8 ">نام خانوادگی <span class="text-red"
                                                                             style="font-size: 18px !important;">*</span>
                    </div>
                    <q-input dense v-model="userDetails.family" lazy-rules
                             :rules="[val => val.length > 2 || 'لطفا نام خانوادگی خود را وارد کنید']"/>
                  </q-item-section>
                </q-item>

                <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  <q-item-section>
                    <div class="field-label text-grey-8 ">رمز عبور</div>
                    <q-input dense v-model="password"/>
                    <small class="text-red">اگر این این فیلد خالی بماند همان پسورد قبلی باقی میماند</small>
                  </q-item-section>
                </q-item>
                <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  <q-item-section>
                    <div class="field-label text-grey-8"> نام کاربری <span class="text-red"
                                                                        style="font-size: 18px !important;">*</span>
                    </div>
                    <q-input lazy-rules
                             :rules="[val => val.length > 0 || 'نام کاربری باید وارد شود']" dense
                             v-model="userDetails.username"/>
                  </q-item-section>
                </q-item>
              </q-list>
              <q-card-actions class="q-mt-lg" align="right">
                <q-btn class="text-capitalize bg-info text-white" type="submit">ذخیره اطلاعات</q-btn>
              </q-card-actions>
            </q-form>
          </q-card-section>
        </q-card>
      </div>
    </div>
  </q-page>
</template>

<script>
export default {
  name: 'Profile',

  data: function () {
    return {
      userDetails: {},
      password: ''
    }
  },

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

    updateProfile () {
      const app = this
      const formData = new FormData()

      if (this.password === '') {
        this.password = null
      }

      this.userDetails.password = this.password

      for (const i in this.userDetails) {
        formData.append(i, this.userDetails[i])
      }

      formData.append('file', this.$refs.uploadFile.files[0] !== undefined ? this.$refs.uploadFile.files[0] : null)

      app.$q.loading.show()
      this.$axios.post(process.env.api + 'api/auth/updateProfile', formData)
        .then(function (response) {
          if (response.data.status === true) {
            app.showNotif('پروفایل شما با موفقیت ویرایش شد', 'mdi-checkbox-marked-circle-outline ', 'green')
            app.GetUserData()
          } else {
            app.showNotif('خطایی هنگام ویرایش پروفایل رخ داده است!!')
          }
        })
        .finally(function () {
          app.$q.loading.hide()
        })
    },

    GetUserData () {
      const app = this

      this.$axios.post(process.env.api + 'api/auth/profile')
        .then(function (response) {
          if (response.data.status === true) {
            app.userDetails = response.data.user
          }
        })
    },

    getimage () {
      if (this.userDetails.img !== null && this.userDetails.img !== undefined) {
        return process.env.api + this.userDetails.img
      } else {
        return 'https://i.pinimg.com/originals/51/f6/fb/51f6fb256629fc755b8870c801092942.png'
      }
    }
  },

  mounted () {
    this.GetUserData()
  }
}
</script>

<style scoped>

</style>
