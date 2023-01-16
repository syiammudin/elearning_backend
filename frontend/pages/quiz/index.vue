<template>
  <div>
    <el-card shadow="always" :body-style="{ padding: '20px' }">
      <div slot="header">
        <div class="d-flex justify-content-between">
          <span>Quiz</span>
          <div class="p-1 text-right">
            <el-input
              placeholder="Search"
              @change="getData"
              v-model="keyword"
              size="small"
              clearable
            >
              <el-button
                slot="append"
                icon="el-icon-search"
                @click="getData"
              ></el-button>
            </el-input>
          </div>
        </div>
      </div>
      <!-- card body -->

      <div class="row">
        <div class="col-md-4 mb-3" v-for="(d, index) in data.data" :key="index">
          <el-card>
            <div>
              <span>
                <strong>{{ d.subject }} </strong>
                <br />
                <br />
              </span>
            </div>
            <div class="text-center">
              <el-button
                :type="d.status_quiz ? 'success' : 'primary'"
                size="small"
                @click="doExam(d)"
              >
                {{ d.status_quiz ? "Selesai" : "Kerjakan Soal" }}
              </el-button>
            </div>
            <hr />
            <div class="bottom clearfix">
              <time class="time" style="font-size: 10pt">
                <i class="el-icon-time"></i> {{ dateFormat(d.created_at) }}
              </time>
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
      keyword: "",
    };
  },
  mounted() {
    this.getData();
  },
  methods: {
    doExam(data) {
      this.$axios.$post("/api/exam", data).then((r) => {
        console.log(r.data.id);
        this.$router.push("quiz/" + r.data.id);
      });
    },
    getData() {
      const params = {
        pageSize: 8,
        sort: "created_at",
        order: "desc",
        keyword: this.keyword,
      };
      this.$axios.$get("api/masterQuiz", { params }).then((r) => {
        this.data = r;
      });
    },
  },
};
</script>
