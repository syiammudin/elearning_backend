<template>
  <div>
    <el-main>
      <div
        class="justify-content-center mt-5"
        style="padding: 10px; display: flex; flex-wrap: wrap"
      >
        <div class="login-container p-2">
          <div class="text-center text-h4 font-weight-bold">Selamat Datang</div>
          <div class="text-center h2 font-weight-bold">E-learning</div>
          <div class="text-center grey--text">
            Silakan login melalui form di bawah ini
          </div>
          <Nuxt />
          <h4 class="welcome-text-mobile">Merdeka Contract Management</h4>
        </div>
      </div>
    </el-main>
  </div>
</template>

<style scoped>
.bg {
  background: linear-gradient(0deg, rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.1));
  background-size: cover !important;
  background-repeat: no-repeat;
  height: 100%;
}
.login-container {
  width: 500px;
  background: linear-gradient(
      0deg,
      rgba(239, 234, 226, 0.5),
      rgba(239, 234, 226, 0.5)
    ),
    url("/login.png");
  background-size: cover;
}
.welcome-text {
  color: #fff;
  position: absolute;
  bottom: 0;
  font-size: 48px;
  margin: 25px;
}

.welcome-text-mobile {
  text-align: center;
  margin-top: 20px;
  color: #333;
}

@media screen and (max-width: 480px) {
  .welcome-text {
    display: none;
  }
}

@media screen and (min-width: 480px) {
  .welcome-text-mobile {
    display: none;
  }
}
</style>
