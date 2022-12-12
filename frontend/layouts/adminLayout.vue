<template>
  <el-container>
    <el-header class="d-flex" style="background-color: #545c64">
      <img
        class="mr-auto p-2"
        src="~/assets/logo.png"
        alt=""
        style="height: 50px"
      />
      <el-dropdown class="p-2" @command="handleClick" trigger="click">
        <el-avatar icon="el-icon-user-solid"> </el-avatar>
        <el-dropdown-menu slot="dropdown">
          <el-dropdown-item command="logout">
            <i class="el-icon-switch-button"></i>Logout
          </el-dropdown-item>
        </el-dropdown-menu>
      </el-dropdown>
    </el-header>
    <el-container style="height: calc(100vh - 60px)">
      <sidebar />
      <el-container>
        <el-main> <nuxt /> </el-main>
      </el-container>
    </el-container>
  </el-container>
</template>

<script>
export default {
  middleware: ["auth", "admin"],
  data() {
    return {
      collapse: false,
      activePage: 0,
      sidebar: [
        { title: "Dasboard", to: "/admin/dashboard", icon: "el-icon-menu" },
        {
          title: "Video Content",
          to: "/admin/videoContent",
          icon: "el-icon-menu",
        },
        {
          title: "Laboratorium",
          to: "/admin/laboratorium",
          icon: "el-icon-menu",
        },
        { title: "Quiz", to: "/admin/quiz", icon: "el-icon-menu" },
        { title: "User", to: "/admin/user", icon: "el-icon-user" },
        { title: "Category", to: "/admin/category", icon: "el-icon-user" },
      ],
    };
  },
  methods: {
    handleClick(command) {
      if (command == "logout") {
        this.logout();
      }
    },
    logout() {
      this.$auth.logout().then(() => this.$router.push("/login"));
    },
  },
};
</script>

<style scoped>
.width200 {
  width: 200px;
}
.width300 {
  width: 300px;
}
.body {
  background-color: red;
}
</style>
