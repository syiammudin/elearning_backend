<template>
  <div class="mb-5">
    <el-card shadow="always" :body-style="{ padding: '20px' }">
      <div slot="header">
        <span>
          <b>
            <h3>{{ data.master_quiz.subject }}</h3>
          </b>
        </span>
      </div>
      <div class="text-center" v-if="data.status == false">
        <div class="d-flex justify-content-between">
          <div></div>
          <div class="col-md-6">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th colspan="2">Ketentuan Pengerjaan</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Score Kelulusan</td>
                  <td>{{ data.passing_grade }}</td>
                </tr>
                <tr>
                  <td>Durasi Pengerjaan</td>
                  <td>{{ data.max_duration }} Menit</td>
                </tr>
                <tr>
                  <td>Total Quiz</td>
                  <td>{{ data.total_quizzes }} Soal</td>
                </tr>
                <tr>
                  <td>Sisa Durasi Pengerjaan</td>
                  <td>{{ konvertMenit(data.sisa_durasi) }} Menit</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div></div>
        </div>
        <el-divider direction="horizontal" content-position="left"></el-divider>
        <el-button size="small" @click="$router.go(-1)" icon="el-icon-back">
          Back
        </el-button>
        <el-button
          type="primary"
          size="small"
          @click="mulaiExam"
          icon="el-icon-check"
        >
          {{ data.exam_section.length >= 1 ? "Lanjut Kerjakan" : "Mulai Exam" }}
        </el-button>
        <el-divider direction="horizontal" content-position="left"></el-divider>
      </div>
      <div class="text-center d-flex justify-content-between" v-else>
        <div></div>
        <div class="col-md-6">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th colspan="2">Hasil Pengerjaan Exam</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Total Quiz</td>
                <td>{{ data.total_quizzes }} Soal</td>
              </tr>
              <tr>
                <td>Score Kelulusan</td>
                <td>{{ data.passing_grade }}</td>
              </tr>
              <tr>
                <td>Durasi Maximal Pengerjaan</td>
                <td>{{ data.max_duration }} Menit</td>
              </tr>
              <tr>
                <td>Waktu Pegerjaan</td>
                <td>
                  {{ konvertMenit(data.max_duration * 60 - data.sisa_durasi) }}
                </td>
              </tr>
              <tr>
                <td>Jawaban Benar</td>
                <td>
                  {{ data.exam_quiz.filter((f) => f.status == true).length }}
                  Soal
                </td>
              </tr>
              <tr>
                <td>Score</td>
                <td>
                  {{ data.score }}
                </td>
              </tr>
              <tr>
                <td>Hasil</td>
                <td>
                  <el-tag type="success" v-if="data.passed == true">
                    Lulus
                  </el-tag>
                  <el-tag type="danger" v-else>Gagal</el-tag>
                </td>
              </tr>
            </tbody>
          </table>
          <el-button size="small" @click="$router.go(-1)" icon="el-icon-back">
            Back
          </el-button>
        </div>
        <div></div>
      </div>
    </el-card>

    <ExamForm
      v-if="showForm == true"
      :data="data"
      :show="showForm"
      @close="close"
    ></ExamForm>
  </div>
</template>

<script>
import plugin from "../../mixins/plugin";

export default {
  async asyncData({ $axios, params, $auth }) {
    const data = await $axios.$get("api/exam/" + params.id);
    return { data };
  },
  mixins: [plugin],
  data() {
    return {
      url: "/api/exam",
      showForm: false,
    };
  },
  methods: {
    mulaiExam() {
      this.$confirm("Yakin ingin mengerjakan Exam ?", "Perthatian", {
        confirmButtonText: "Kerjakan",
        cancelButtonText: "Cancel",
        type: "success",
      }).then((action) => {
        this.$axios
          .$put("api/sectionExam/" + this.data.id)
          .then((r) => {
            this.showForm = true;
          })
          .catch((e) => {
            console.log(e);
          });
      });
      // this.$router.push("/quiz/1/" + this.data.id);
    },
    getData() {
      const loading = this.$loading({
        lock: true,
        text: "Loading",
      });
      this.$axios.$get("api/exam/" + this.$route.params.id).then((r) => {
        this.data = r;
        loading.close();
        this.$forceUpdate();
      });
    },
    close() {
      this.showForm = false;
      this.getData();
    },
  },
};
</script>