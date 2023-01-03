<template>
  <div class="mb-5">
    <el-card shadow="always" :body-style="{ padding: '20px' }">
      <div slot="header">
        <span>
          <h5>
            Number : {{ $route.params.nomor }} of
            {{ data.exam_quiz.length }}
          </h5>
        </span>
      </div>
      <div class="row">
        <div
          v-if="data.exam_quiz[$route.params.nomor - 1].path != null"
          class="col-md-5"
        >
          <el-image
            :src="data.exam_quiz[$route.params.nomor - 1].url"
            fit="fill"
            :lazy="true"
          ></el-image>
        </div>
        <div class="col-md-7">
          <h5>{{ data.exam_quiz[$route.params.nomor - 1].question }} ?</h5>
          <ul class="list" infinite-scroll-disabled="disabled">
            <div
              v-for="(c, i) in data.exam_quiz[$route.params.nomor - 1].choices"
              class="row"
              :key="i"
            >
              <div>
                <el-radio
                  v-model="data.exam_quiz[$route.params.nomor - 1].user_answer"
                  :label="c.jawaban"
                >
                  {{ c.jawaban }}.
                </el-radio>
              </div>
              <div class="ml-2">
                {{ c.pilihan }}
              </div>
            </div>
          </ul>
          <hr />
          <div class="d-flex justify-content-between">
            <div>
              <el-button
                v-if="$route.params.nomor != 1"
                type="text"
                size="small"
                icon="el-icon-arrow-left"
                @click="prev($route.params.nomor)"
              >
                Prev
              </el-button>
            </div>
            <div>
              <el-button
                :class="$route.params.nomor == item ? 'btn-active' : ''"
                v-for="(item, index) in data.exam_quiz.length"
                :key="index"
                type="icon"
                size="mini"
                @click="$router.push('/quiz/' + item + '/' + data.id)"
              >
                {{ item }}
              </el-button>
            </div>
            <div>
              <el-button
                type="text"
                size="small"
                v-if="$route.params.nomor != data.exam_quiz.length"
                @click="next($route.params.nomor)"
              >
                Next<i class="el-icon-arrow-right"></i>
              </el-button>
            </div>
          </div>
        </div>
      </div>
      <el-button type="primary" size="default" @click="handler()"
        >Test</el-button
      >
    </el-card>
  </div>
</template>

<script>
export default {
  async asyncData({ $axios, params, $auth }) {
    const data = await $axios.$get("api/exam/" + params.id);
    return { data };
  },
  data() {
    return {
      url: "/api/exam",
    };
  },
  created() {
    document.addEventListener("beforeunload", this.handler);
  },
  mounted() {
    window.addEventListener("beforeunload", this.onClose);
  },
  methods: {
    onClose(event) {
      console.log("unload");
      this.$axios.$get("/api/testing/" + this.$route.params.id).then((r) => {
        console.log(r);
      });
      if (this.$store.state.curOrder != "") {
        event.preventDefault();
        event.returnValue = "";
      }
    },
    handler: function handler(event) {
      this.$axios
        .$put("/api/test/" + this.$route.params.id, this.$route.params)
        .then((r) => {
          this.$message({
            message: "successs",
            type: "info",
            showClose: true,
            duration: 3000,
          });
        });
    },
    prev(nomor) {
      var number = nomor - 1;
      this.$router.push("/quiz/" + number + "/" + this.data.id);
    },
    next(nomor) {
      var number = parseInt(nomor) + 1;
      this.$router.push("/quiz/" + number + "/" + this.data.id);
    },
    mulaiExam() {
      this.router.push("/quiz/exam/" + this.data.id);
    },
  },
};
</script>

<style>
.btn-active {
  border: 1px blue solid;
  color: blue;
}
</style>