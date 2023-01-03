<template>
  <div>
    <el-card shadow="always" :body-style="{ padding: '20px' }">
      <div slot="header">
        <span>New Content</span>
      </div>
      <!-- card body -->

      <div class="row">
        <div class="col-md-3 mb-3" v-for="(d, index) in data.data" :key="index">
          <el-card>
            <div>
              <span>
                <strong>{{ d.subject }} </strong>
                <br />
                <br />
                <el-button type="primary" size="small" @click="doExam(d)">
                  Do Exam
                </el-button>
              </span>
              <hr />
              <div class="bottom clearfix">
                <time class="time" style="font-size: 10pt, sy">
                  <i class="el-icon-time"></i> {{ dateFormat(d.created_at) }}
                </time>
              </div>
            </div>
          </el-card>
        </div>
      </div>
    </el-card>
  </div>
</template>

<script>
import VueVideoThumbnail from "vue-video-thumbnail";
import plugin from "../../mixins/plugin";

export default {
  name: "IndexPage",
  components: { VueVideoThumbnail },
  mixins: [plugin],
  data() {
    return {
      data: {},
    };
  },
  mounted() {
    this.getData();
  },
  methods: {
    doExam(data) {
      this.$confirm("Yakin ingin mengerjakan Exam ?", "Perthatian", {
        confirmButtonText: "Kerjakan",
        cancelButtonText: "Cancel",
        type: "success",
      }).then((action) => {
        this.$axios.$post("/api/exam", data).then((r) => {
          console.log(r.data.id);
          this.$router.push("quiz/" + r.data.id);
        });
      });
    },
    getData() {
      const params = {
        pageSize: 8,
        sort: "created_at",
        order: "desc",
      };
      this.$axios.$get("api/masterQuiz", { params }).then((r) => {
        this.data = r;
      });
    },
  },
};
</script>
