<template>
  <div>
    <div style="background-color: #545c64">
      <div class="container">
        <b-navbar toggleable="lg" type="dark">
          <b-navbar-brand href="#">
            <img
              src="~/assets/logo.png"
              alt=""
              style="height: 40px; margin-top: -10px"
            />
          </b-navbar-brand>

          <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

          <b-collapse id="nav-collapse" is-nav>
            <b-navbar-nav class="navbar-nav mx-auto text-md-center text-left">
              <b-nav-item href="#" @click="$router.push('/')">
                Beranda
              </b-nav-item>
              <b-nav-item href="#" @click="$router.push('/video')">
                Materi
              </b-nav-item>
              <b-nav-item href="#" @click="$router.push('/laboratorium')">
                Laboratorium
              </b-nav-item>
              <b-nav-item href="#" @click="$router.push('/quiz')">
                Quiz
              </b-nav-item>
            </b-navbar-nav>

            <!-- Right aligned nav items -->

            <form class="form-inline my-2 my-lg-0">
              <el-button plain size="small">
                <i class="el-icon-download"></i> Plain</el-button
              >
            </form>
          </b-collapse>
        </b-navbar>
      </div>
    </div>

    <div class="container mt-1">
      <Nuxt />
    </div>
  </div>
</template>

<script>
export default {
  middleware: ["auth"],
  data() {
    return {
      menu: [
        { title: "Materi", to: "/video" },
        { title: "Laboratorium", to: "/laboratorium" },
        { title: "Quizz", to: "/quizz" },
      ],
    };
  },
  methods: {
    logout() {
      this.$auth.logout().then(() => this.$router.push("/login"));
    },
  },
};
</script>

<style>
a {
  color: white;
}
.time {
  font-size: 10pt;
  font-style: italic;
  color: grey;
}

.title {
  font-size: 14pt;
  font-weight: bold;
}

.nav-item {
  margin-left: 5px !important;
  margin-right: 5px !important;
}
</style>
