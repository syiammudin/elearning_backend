<template>
  <div>
    <el-carousel :interval="5000" arrow="always" style="background-color: grey">
      <el-carousel-item v-for="item in 4" :key="item">
        <div class="text-center">
          <h3 class="mt-5">New Vocational learning approach {{ item }}</h3>
          <p>
            Menerapkan desaing elearning dengan kolaborasi pengguna di satu
            platform akses kapan saja dan dimana saja
          </p>
          <div class="mt-5">
            <el-button
              type="primary"
              size="default"
              @click="$router.push('/login')"
            >
              Masuk
            </el-button>
          </div>
        </div>
      </el-carousel-item>
    </el-carousel>

    <!-- search global  -->
    <div class="d-flex mt-2">
      <div class="mr-auto p-2"></div>
      <div class="p-1 text-right">
        <el-input
          placeholder="Search"
          @change="search()"
          v-model="keyword"
          size="small"
          clearable
        >
          <el-button
            slot="append"
            icon="el-icon-search"
            @click="search()"
          ></el-button>
        </el-input>
      </div>
    </div>

    <HompageMateri class="mb-2 mt-2" />
    <HompageQuiz class="mb-2 mt-2" />
    <HompageLaboratorium class="mb-4 mt-2" />

    <Footer></Footer>
  </div>
</template>

<script>
import plugin from "../mixins/plugin";

export default {
  name: "IndexPage",
  layout: "outside",
  mixins: [plugin],
  data() {
    return {
      keyword: "",
      value: [4, 5, 5, 4, 3, 4, 5, 2],
      data: {},
    };
  },
  methods: {
    search() {
      this.$router.push("/search/" + this.keyword);
    },
  },
};
</script>
