<template>
  <div>
    <el-dialog
      title="Quiz"
      :close-on-click-modal="false"
      :visible.sync="show"
      :fullscreen="true"
      @close="close()"
      :show-close="false"
    >
      <el-card shadow="always" :body-style="{ padding: '20px' }">
        <div slot="header" class="d-flex justify-content-between">
          <div>
            <h5>
              Number : {{ nomor }} of
              {{ data.exam_quiz.length }}
            </h5>
          </div>
          <div>
            <vac :left-time="data.sisa_durasi * 1000">
              <span slot="process" slot-scope="{ timeObj }">{{
                `Timer: ${timeObj.m}:${timeObj.s}`
              }}</span>
              <span slot="finish">Finish</span>
            </vac>
          </div>
        </div>

        <div class="row">
          <div v-if="data.exam_quiz[nomor - 1].path != null" class="col-md-4">
            <el-image
              :src="data.exam_quiz[nomor - 1].url"
              fit="fill"
              :lazy="true"
            ></el-image>
          </div>
          <div class="col-md-8">
            <h5>{{ data.exam_quiz[nomor - 1].question }} ?</h5>
            <ul class="list" infinite-scroll-disabled="disabled">
              <div
                v-for="(c, i) in data.exam_quiz[nomor - 1].choices"
                class="row"
                :key="i"
              >
                <div>
                  <el-radio
                    v-model="data.exam_quiz[nomor - 1].user_answer"
                    :label="c.jawaban"
                    @change="answer(data.exam_quiz[nomor - 1])"
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
                  v-if="nomor != 1"
                  type="text"
                  size="small"
                  icon="el-icon-arrow-left"
                  @click="prev(nomor)"
                >
                  Prev
                </el-button>
              </div>
              <div>
                <el-button
                  v-for="(item, index) in data.exam_quiz.length"
                  :key="index"
                  type="icon"
                  size="mini"
                  :class="nomor == item ? 'btn-active' : ''"
                  @click="paging(item)"
                >
                  {{ item }}
                </el-button>
              </div>
              <div>
                <el-button
                  type="text"
                  size="small"
                  v-if="nomor != data.exam_quiz.length"
                  @click="next(nomor)"
                >
                  Next
                  <i class="el-icon-arrow-right"></i>
                </el-button>
              </div>
            </div>
          </div>
        </div>
      </el-card>
      <span slot="footer">
        <el-button @click="onClose">Simpan dan lanjut nanti</el-button>
        <el-button
          type="primary"
          size="default"
          @click="finish"
          v-if="data.exam_quiz.filter((f) => f.user_answer == null).length == 0"
        >
          Finish
        </el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
export default {
  props: ["data", "show"],
  data() {
    return {
      nomor: 1,
    };
  },
  mounted() {
    window.addEventListener("beforeunload", this.onClose);
    this.countDownTimer();
  },
  methods: {
    countDownTimer() {
      if (this.data.sisa_durasi > 0) {
        setTimeout(() => {
          this.data.sisa_durasi -= 1;
          this.countDownTimer();
        }, 1000);
      } else {
        this.finishCundown();
      }
    },
    finishCundown() {
      console.log("ok bisa jalan");
      alert("selesai");
    },
    onClose() {
      this.$axios
        .$get(
          "/api/updateTime/" +
            this.data.id +
            "?sisa_durasi=" +
            this.data.sisa_durasi
        )
        .then((r) => {
          this.close();
        });
    },
    finish() {
      this.data.exam_quiz = this.data.exam_quiz.map((m) => {
        if (m.correct_answer == m.user_answer) {
          m.status = true;
        } else {
          m.status = false;
        }

        return m;
      });

      this.data.type = "finish";

      this.$axios.$put("/api/exam/" + this.data.id, this.data).then((r) => {
        this.close();
      });
    },
    close() {
      this.$emit("close");
    },
    paging(nomor) {
      this.nomor = nomor;
    },
    prev(nomor) {
      this.nomor = nomor - 1;
    },
    next(nomor) {
      this.nomor = parseInt(nomor) + 1;
    },
    answer(data) {
      this.$axios.$put("/api/saveQuiz/" + data.id, data).then((r) => {
        console.log(r);
      });
    },
  },
};
</script>

<style>
.btn-active {
  border: 1px solid #409eff;
  color: #409eff;
}
</style>