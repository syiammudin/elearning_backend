<template>
  <div>
    <div style="background-color: #545c64">
      <div class="container">
        <b-navbar toggleable="lg" type="dark">
          <b-navbar-brand href="#" @click="$router.push('/')">
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

            <form class="form-inline my-2 my-lg-0" v-if="$auth.user">
              <el-button
                v-if="$auth.user.role_name == 'ADMIN'"
                type="warning"
                size="mini"
                round
                @click="$router.push('/admin/dashboard')"
              >
                Admin Site
              </el-button>
              <el-popover
                v-else
                placement="bottom"
                title="Account"
                width="250"
                trigger="click"
              >
                <div>
                  <hr />
                  <div class="text-center">
                    <el-avatar
                      icon="el-icon-user-solid"
                      size="large"
                      shape="circle"
                      fit="fill"
                      :src="$auth.user.url"
                    >
                    </el-avatar>
                    <br />
                    {{ $auth.user.name }}
                  </div>
                  <hr />
                  <div class="d-flex justify-content-between">
                    <div class="text-left">
                      <el-button
                        type="text"
                        size="mini"
                        icon="el-icon-user"
                        @click="$router.push('./profile')"
                      >
                        Profile
                      </el-button>
                    </div>
                    <div class="text-right">
                      <el-button
                        type="text"
                        size="mini"
                        icon="el-icon-switch-button"
                        @click="logout"
                      >
                        Logout
                      </el-button>
                    </div>
                  </div>
                </div>
                <el-avatar size="small" slot="reference">
                  <img v-if="$auth.user.photo" :src="$auth.user.url" alt="" />
                  <span v-else>{{ $auth.user.initial_name }}</span>
                </el-avatar>
              </el-popover>
            </form>
            <form class="form-inline my-2 my-lg-0" v-else>
              <el-button
                type="primary"
                size="mini"
                round
                icon="el-icon-arrow-right"
                @click="$router.push('/login')"
              >
                Sign In
              </el-button>
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
      this.$auth.logout().then(() => this.$router.push("/"));
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
