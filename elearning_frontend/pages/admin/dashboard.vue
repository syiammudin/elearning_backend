<template>
  <div>
    <el-card shadow="always" :body-style="{ padding: '20px' }">
      <div slot="header">
        <span>Dashboard</span>
      </div>
      Ini adalah halaman dashboardnya
    </el-card>
  </div>
</template>

<script>
export default {
  layout: "adminLayout",
  name: "dashboard",
};
</script>