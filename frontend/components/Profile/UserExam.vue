<template >
  <div style="overflow: auto">
    <el-table :data="data.data" style="width: 100%">
      <el-table-column type="expand">
        <template slot-scope="scope">
          <div style="padding-left: 20px; padding-right: 20px">
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <td>Durasi Maximal Pengerjaan</td>
                  <td>{{ scope.row.max_duration }} Menit</td>
                </tr>
                <tr>
                  <td>Waktu Pegerjaan</td>
                  <td>
                    {{
                      konvertMenit(
                        scope.row.max_duration * 60 - scope.row.sisa_durasi
                      )
                    }}
                  </td>
                </tr>
                <tr>
                  <td>Jumlah Soal</td>
                  <td>{{ scope.row.total_quizzes }} Soal</td>
                </tr>
                <tr>
                  <td>Jawaban Benar</td>
                  <td>
                    {{
                      scope.row.exam_quiz.filter((f) => f.status == true).length
                    }}
                    Soal
                  </td>
                </tr>
                <tr>
                  <td>Score Kelulusan</td>
                  <td>{{ scope.row.passing_grade }}</td>
                </tr>
                <tr>
                  <td>Score</td>
                  <td>
                    {{ scope.row.score }}
                  </td>
                </tr>
                <tr>
                  <td>Hasil</td>
                  <td>
                    <el-tag type="success" v-if="scope.row.passed == true">
                      Lulus
                    </el-tag>
                    <el-tag type="danger" v-else>Gagal</el-tag>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </template>
      </el-table-column>
      <el-table-column label="Subject" prop="master_quiz.subject">
      </el-table-column>
      <el-table-column label="Status" prop="status">
        <template slot-scope="scope">
          <el-tag type="success" v-if="scope.row.status == true">
            Selesai
          </el-tag>
          <el-tag type="warning" v-else>Sedang Berjalan</el-tag>
        </template>
      </el-table-column>
      <el-table-column label="Hasil" prop="passed">
        <template slot-scope="scope">
          <el-tag type="success" v-if="scope.row.passed == true">
            Lulus
          </el-tag>
          <el-tag type="danger" v-else>Gagal</el-tag>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>
<script>
import plugin from "../../mixins/plugin";

export default {
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
    getData() {
      this.$axios.$get("/api/exam?type=user").then((r) => {
        this.data = r;
      });
    },
    handleChange(val) {
      console.log(val);
    },
  },
};
</script>
<style lang="">
</style>