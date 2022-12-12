<template>
  <div>
    <el-dialog title="Rate" :visible.sync="show" width="200px">
      <div class="text-center">
        <el-rate
          v-model="form.value"
          :allow-half="false"
          @change="changeRate()"
        ></el-rate>
      </div>
      <span slot="footer">
        <el-button
          size="small"
          :disabled="loading"
          type="primary"
          @click="rateVideo"
          >Rate</el-button
        >
      </span>
    </el-dialog>
  </div>
</template>

<script>
export default {
  props: ["data", "form", "show"],
  data() {
    return {
      loading: false,
    };
  },
  methods: {
    changeRate() {
      this.form.value = this.form.value;
      this.$forceUpdate();
    },
    rateVideo() {
      this.loading = true;
      this.$axios
        .$put("api/RatingVideoContent/" + this.data.id, this.form)
        .then((r) => {
          this.$message({
            message: "Rating update",
            type: "success",
            showClose: true,
            duration: 3000,
          });
          this.$emit("rating", r.data);
        })
        .catch((e) => {
          this.$message({
            message: e.response.data.message,
            type: "danger",
            showClose: true,
            duration: 3000,
          });
        })
        .finally(() => {
          this.loading = false;
        });
    },
  },
};
</script>