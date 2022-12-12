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
            <el-button type="primary" size="default"> DAFTAR </el-button>
          </div>
        </div>
      </el-carousel-item>
    </el-carousel>
    <div class="d-flex mt-2">
      <div class="mr-auto p-2"></div>
      <div class="p-1 text-right">
        <el-input placeholder="Search" size="small" clearable>
          <el-button slot="append" icon="el-icon-search"></el-button>
        </el-input>
      </div>
    </div>
  </div>
</template>

<script>
import VueVideoThumbnail from "vue-video-thumbnail";
import plugin from "../mixins/plugin";

export default {
  name: "IndexPage",
  components: { VueVideoThumbnail },
  mixins: [plugin],
  data() {
    return {
      value: [4, 5, 5, 4, 3, 4, 5, 2],
      data: {},
    };
  },
  mounted() {
    this.getData();
  },
  methods: {
    getData() {
      const params = {
        pageSize: 8,
        sort: "created_at",
        order: "desc",
      };
      this.$axios.$get("api/videoContent", { params }).then((r) => {
        this.data = r;
      });
    },
  },
};
</script>
