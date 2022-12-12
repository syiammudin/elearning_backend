<template>
  <form class="pl-5 pr-5" element-loading-text="Loading..." v-loading="loading">
    <el-divider></el-divider>
    <div class="form-group">
      <label for="exampleInputEmail1">Email</label>
      <el-input
        v-model="form.email"
        placeholder="Please input Email"
        size="small"
        clearable
      >
      </el-input>
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">Password</label>
      <el-input
        placeholder="Please input password"
        v-model="form.password"
        show-password
        @keypress.enter.native="login"
      ></el-input>
    </div>
    <div class="text-center">
      <el-button type="primary" size="default" @click="login">
        Login
      </el-button>
    </div>
  </form>
</template>
<script>
import plugin from "~/mixins/plugin";
export default {
  mixins: [plugin],
  layout: "auth",
  data() {
    return {
      form: {},
      snackbar: false,
      email: "",
      password: "",
      rules: {},
      loading: false,
      showPassword: false,
    };
  },
  methods: {
    login() {
      this.loading = true;
      this.$auth
        .loginWith("laravelSanctum", {
          data: this.form,
        })
        .then((r) => {
          if (r.data.user.role == 10) {
            this.$router.push("/admin/dashboard");
          } else {
            this.$router.push("/");
          }
        })
        .catch((e) => {
          this.$message({
            message: e.response.data.message,
            type: "error",
            showClose: true,
            duration: 3000,
          });

          if (e.response.status == 422) {
            this.rules = e.response.data.errors;
          }
        })
        .finally(() => {
          this.loading = false;
        });
    },
  },
};
</script>
<style lang="">
</style>