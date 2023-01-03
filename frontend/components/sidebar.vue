<template>
  <el-aside style="background: #545c64">
    <el-menu
      style="border: none"
      :router="true"
      :default-active="'/' + $nuxt.$route.name.replace('-', '/')"
      background-color="#545c64"
      text-color="#fff"
      active-text-color="#ffd04b"
    >
      <div v-for="(item, i) in sidebar" :key="i">
        <el-menu-item :index="item.path">
          <i :class="item.icon"></i>
          <span>{{ item.title }}</span>
        </el-menu-item>
      </div>
    </el-menu>
  </el-aside>
</template>

<script>
export default {
  data() {
    return {
      collapse: false,
      sidebar: [
        { title: "Dasboard", path: "/admin/dashboard", icon: "el-icon-menu" },
        {
          title: "Video Content",
          path: "/admin/videoContent",
          icon: "el-icon-menu",
        },
        {
          title: "Laboratorium",
          path: "/admin/laboratorium",
          icon: "el-icon-menu",
        },
        // {
        //   title: "Exam",
        //   path: "/admin/exam",
        //   icon: "el-icon-menu",
        // },
        { title: "Quiz", path: "/admin/quiz", icon: "el-icon-menu" },
        { title: "User", path: "/admin/user", icon: "el-icon-user" },
        { title: "Category", path: "/admin/category", icon: "el-icon-user" },
        { title: "Kelas", path: "/admin/kelas", icon: "el-icon-user" },
      ],
    };
  },
};
</script>