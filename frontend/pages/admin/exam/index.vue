<template>
  <div>
    <el-card shadow="always" :body-style="{ padding: '20px' }">
      <div slot="header">
        <el-row :gutter="20">
          <el-col :span="12" :offset="0">
            <strong> Exam </strong>
          </el-col>
          <el-col :span="12" :offset="0" class="text-right">
            <el-button
              type="primary"
              size="small"
              @click="$router.push('exam/0/form')"
            >
              <i class="el-icon-plus"></i> Add New
            </el-button>
            <el-input
              style="width: 200px"
              v-model="filters.serach"
              placeholder="Search"
              size="small"
              clearable
              @change="getData()"
            ></el-input>
          </el-col>
        </el-row>
      </div>

      <el-table
        @sort-change="sortChange"
        :default-sort="{ prop: sort, order: order }"
        :data="tableData.data"
        style="width: 100%"
        v-loading="loading"
        @cell-dblclick="showData"
      >
        <el-table-column
          prop="master_quiz.subject"
          label="Subject Exam"
          sortable
        />
        <el-table-column prop="user.name" label="User" sortable />
        <el-table-column prop="created_at" label="Created at">
          <template slot-scope="scope">
            {{ dateFormat(scope.row.created_at) }}
          </template>
        </el-table-column>
        <el-table-column prop="passed" label="Status">
          <template slot-scope="scope">
            <el-tag
              :type="scope.row.passed ? 'success' : 'danger'"
              size="small"
              effect="dark"
            >
              {{ scope.row.passed ? "Lulus" : "Gagal" }}
            </el-tag>
          </template>
        </el-table-column>
      </el-table>
      <el-pagination
        background
        @size-change="
          (s) => {
            pageSize = s;
            getData();
          }
        "
        @current-change="
          (p) => {
            page = p;
            getData();
          }
        "
        :page-size="pageSize"
        :page-sizes="[5, 10, 25, 50, 100]"
        layout="prev, pager, next, sizes, total"
        :total="tableData.total"
      >
      </el-pagination>
    </el-card>

    <el-dialog
      title="Detail"
      :visible.sync="showDetail"
      width="30%"
      v-if="showDetail == true"
    >
      <table class="table table-bordered">
        <thead>
          <tr>
            <th colspan="2">Hasil Pengerjaan Exam {{ data.user.name }}</th>
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
              <el-tag type="success" v-if="data.passed == true"> Lulus </el-tag>
              <el-tag type="danger" v-else>Gagal</el-tag>
            </td>
          </tr>
        </tbody>
      </table>
      <span slot="footer">
        <el-button @click="showDetail = false">close</el-button>
      </span>
    </el-dialog>
  </div>
</template>
<script>
import crud from "../../../mixins/crud";
import plugin from "../../../mixins/plugin";
export default {
  mixins: [crud, plugin],
  layout: "adminLayout",
  data() {
    return {
      url: "/api/exam",
      data: {},
      showDetail: false,
    };
  },
  methods: {
    showData(item) {
      this.data = { ...item };
      this.showDetail = true;
    },
    editData(id) {
      this.$router.push("/admin/exam/" + id + "/form");
    },
  },
};
</script>