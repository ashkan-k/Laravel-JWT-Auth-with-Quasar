<template>
  <div>
    <q-item to="/" class="item-side-bar" active-class="q-item-no-link-highlighting">
      <q-item-section  avatar>
        <q-icon name="dashboard"/>
      </q-item-section>
      <q-item-section>
        <q-item-label>داشبورد</q-item-label>
      </q-item-section>
    </q-item>

    <q-item to="/profile" class="item-side-bar" active-class="item-side-bar-active">
      <q-item-section avatar>
        <q-icon name="mdi-account-circle"/>
      </q-item-section>
      <q-item-section>
        <q-item-label>پروفایل</q-item-label>
      </q-item-section>
    </q-item>
  </div>
</template>

<script>
export default {
  name: 'SideBar'
}
</script>
