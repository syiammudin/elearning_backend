<template >
  <div>
    <el-card
      shadow="always"
      :body-style="{ padding: '20px' }"
      style="height: calc(100vh - 100px); overflow: auto"
    >
      <div slot="header">
        <span>Profile Page</span>
      </div>
      <el-row class="tac"> <el-col :span="12"> </el-col> </el-row>
      <div class="row">
        <div class="col-md-3" style="height: 100%">
          <el-menu
            class="el-menu-vertical-demo"
            default-active="1"
            style="height: 100%"
          >
            <el-menu-item index="1" @click="page = 1">
              <i class="el-icon-right"></i>
              <span>Profile</span>
            </el-menu-item>
            <el-menu-item index="2" @click="page = 2">
              <i class="el-icon-right"></i>
              <span>Exam</span>
            </el-menu-item>
          </el-menu>
        </div>
        <div class="col-md-9">
          <ProfileUserExam v-if="page == 2"></ProfileUserExam>
          <ProfileUserProfile v-if="page == 1"></ProfileUserProfile>
        </div>
      </div>
    </el-card>
  </div>
</template>
<script>
export default {
  data() {
    return {
      page: 1,
    };
  },
};
</script>
<style lang="">
</style>