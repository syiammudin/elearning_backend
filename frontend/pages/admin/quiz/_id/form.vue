<template>
  <div>
    <el-card
      v-loading="loadingSave"
      shadow="always"
      element-loading-text="Loading..."
      :body-style="{ padding: '20px' }"
    >
      <div slot="header">
        <span>Form Master Quiz</span>
      </div>
      <el-form
        :model="form"
        ref="form"
        :rules="rules"
        label-width="250px"
        :inline="false"
        size="normal"
      >
        <el-form-item
          label="Subject of Quiz"
          :class="rules.subject ? 'is-error' : ''"
        >
          <el-input v-model="form.subject" placeholder="" size="normal">
          </el-input>
          <div class="el-form-item__error" v-if="rules.subject">
            {{ rules.subject.join(", ") }}
          </div>
        </el-form-item>
        <el-form-item
          label="Description of Quiz"
          :class="rules.description ? 'is-error' : ''"
        >
          <el-input
            v-model="form.description"
            type="textarea"
            :rows="4"
            :autosize="{ minRows: 4, maxRows: 6 }"
            size="small"
          >
          </el-input>
          <div class="el-form-item__error" v-if="rules.description">
            {{ rules.description.join(", ") }}
          </div>
        </el-form-item>
        <el-form-item
          label="Max Duration"
          :class="rules.max_duration ? 'is-error' : ''"
        >
          <el-input-number
            v-model="form.max_duration"
            size="normal"
            label=""
            :min="1"
            :step="1"
            :controls="true"
          >
          </el-input-number>

          <div class="el-form-item__error" v-if="rules.max_duration">
            {{ rules.max_duration.join(", ") }}
          </div>
        </el-form-item>
        <el-form-item
          label="Total Quiz"
          :class="rules.total_quizzes ? 'is-error' : ''"
        >
          <el-input-number
            v-model="form.total_quizzes"
            size="normal"
            label=""
            :min="1"
            :step="1"
            :controls="true"
          >
          </el-input-number>

          <div class="el-form-item__error" v-if="rules.total_quizzes">
            {{ rules.total_quizzes.join(", ") }}
          </div>
        </el-form-item>

        <el-form-item
          label="Pasing grade"
          :class="rules.passing_grade ? 'is-error' : ''"
        >
          <el-input-number
            v-model="form.passing_grade"
            size="normal"
            label=""
            :min="1"
            :step="1"
            :controls="true"
          >
          </el-input-number>

          <div class="el-form-item__error" v-if="rules.passing_grade">
            {{ rules.passing_grade.join(", ") }}
          </div>
        </el-form-item>
        <el-divider direction="horizontal" content-position="left"></el-divider>
        <label>Question </label>
        <el-button type="primary" size="small" @click="quizDialog = true">
          Add Quiz
        </el-button>

        <table class="table table-sm table-bordered">
          <thead>
            <tr>
              <th>No</th>
              <th>Image</th>
              <th>Question</th>
              <th>Choise</th>
              <th>Answer</th>
              <th>#</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in master_quiz_question" :key="index">
              <td>{{ index + 1 }}</td>
              <td>
                <img :src="item.url" :alt="item.name" style="width: 200px" />
              </td>
              <td>{{ item.question }}</td>
              <td>
                <div v-for="(c, i) in item.choices" :key="i">
                  {{ c.jawaban }} {{ c.pilihan }}
                </div>
              </td>
              <td>
                {{ item.correct_answer }}
              </td>
              <td style="width: 40px" class="text-center">
                <el-button
                  type="primary"
                  size="mini"
                  @click="edit(item, index)"
                  icon="el-icon-edit"
                  circle
                >
                </el-button>
                <br />
                <el-button
                  type="danger"
                  icon="el-icon-delete"
                  circle
                  size="mini"
                  @click="deleteQuiz(item.id, index)"
                >
                </el-button>
              </td>
            </tr>
          </tbody>
        </table>
        <br />
        <hr />
        <el-col class="text-center mb-4">
          <el-button @click="$router.go(-1)">Cancel</el-button>
          <el-button type="primary" @click="save" v-loading.lock="loadingSave">
            {{ form.id ? "Update" : "Save" }}
          </el-button>
        </el-col>
      </el-form>

      <el-dialog title="Quiz Dialog" :visible.sync="quizDialog" width="50%">
        <el-form
          :model="quiz"
          ref="quiz"
          :rules="rules"
          label-width="150px"
          size="normal"
        >
          <el-form-item label="Question">
            <el-input
              v-model="quiz.question"
              type="textarea"
              :rows="2"
              placeholder="Please input"
            >
            </el-input>
          </el-form-item>
          <el-form-item label="Anwswer">
            <div class="infinite-list-wrapper" style="overflow: auto">
              <ul class="list" infinite-scroll-disabled="disabled">
                <div v-for="(c, i) in choices" class="row" :key="i">
                  <div>
                    <el-radio v-model="jawaban" :label="c.jawaban">{{
                      c.jawaban
                    }}</el-radio>
                  </div>
                  <div class="col-md-11">
                    <el-input
                      class="mt-1"
                      v-model="c.pilihan"
                      placeholder=""
                      size="small"
                      clearable
                    ></el-input>
                  </div>
                </div>
              </ul>
            </div>
          </el-form-item>
          <el-form-item label="Attachment">
            <el-button
              type="primary"
              size="default"
              plain
              @click="showAttachment = true"
            >
              <i class="el-icon-upload"></i> Upload Gambar
            </el-button>
            <div class="col-md-8 mt-1" v-if="quiz.name">
              {{ quiz.name }}
            </div>
          </el-form-item>
        </el-form>

        <span slot="footer">
          <el-button @click="quizDialog = false">Cancel</el-button>
          <el-button
            type="primary"
            @click="editQuiz == true ? updateQuiz() : tambahQuiz()"
            >{{ editQuiz == true ? "Update" : "Add Quiz" }}</el-button
          >
        </span>
      </el-dialog>
    </el-card>

    <Attachment
      v-if="showAttachment == true"
      type="Quiz/"
      :show="showAttachment"
      @close="showAttachment = false"
      @addAttachment="addAttachment"
    />
  </div>
</template>
<script>
import crud from "../../../../mixins/crud";
import plugin from "../../../../mixins/plugin";
import { mapState } from "vuex";

export default {
  layout: "adminLayout",
  mixins: [crud, plugin],
  components: {
    "ckeditor-nuxt": () => {
      if (process.client) {
        return import("@blowstack/ckeditor-nuxt");
      }
    },
  },
  computed: {
    ...mapState(["categoryList", "kelasList"]),
  },
  created() {
    this.$store.dispatch("fetchCategory");
    this.$store.dispatch("fetchKelas");
  },
  data() {
    return {
      jawaban: "",
      choices: [
        {
          jawaban: "A",
          pilihan: "",
        },
        {
          jawaban: "B",
          pilihan: "",
        },
        {
          jawaban: "C",
          pilihan: "",
        },
        {
          jawaban: "D",
          pilihan: "",
        },
      ],
      quizDialog: false,
      url: "/api/masterQuiz",
      showAttachment: false,
      showVideo: false,
      quiz: {},
      active: "",
      master_quiz_question: [],
      editorConfig: {
        plugin: ["ImageStyle:full"],
        removePlugins: ["Title"],
        simpleUpload: {
          uploadUrl: `${this.$axios.defaults.baseURL}/api/uploadCkEditor`,
          withCredentials: true,
        },
      },
      editQuiz: false,
      indexQuiz: null,
    };
  },
  mounted() {
    if (this.$route.params.id != 0) {
      this.showData();
    }
  },
  methods: {
    edit(data, i) {
      this.quiz = JSON.parse(JSON.stringify(data));
      this.jawaban = data.correct_answer;
      this.editQuiz = true;
      this.choices = data.choices;
      this.quizDialog = true;
      this.indexQuiz = i;
    },
    updateQuiz() {
      this.master_quiz_question[this.indexQuiz].name = this.quiz.name;
      this.master_quiz_question[this.indexQuiz].path = this.quiz.path;
      this.master_quiz_question[this.indexQuiz].mime = this.quiz.mime;
      this.master_quiz_question[this.indexQuiz].size = this.quiz.size;
      this.master_quiz_question[this.indexQuiz].type = this.quiz.type;
      this.master_quiz_question[this.indexQuiz].url = this.quiz.url;
      this.master_quiz_question[this.indexQuiz].choices = this.choices;
      this.master_quiz_question[this.indexQuiz].correct_answer = this.jawaban;
      this.closeQuiz();
    },
    deleteQuiz(id, index) {
      if (id == undefined) {
        this.master_quiz_question.splice(index, 1);
      } else {
        this.$confirm("Anda yakin ingin manghapus", "Warning", {
          confirmButtonText: "OK",
          cancelButtonText: "Cancel",
          type: "success",
        }).then((action) => {
          this.$axios.$delete("api/masterQuizQuestion/" + id).then((r) => {
            this.master_quiz_question.splice(index, 1);
            this.$message({
              message: r.message,
              type: "success",
              showClose: true,
              duration: 3000,
            });
          });
        });
      }
    },
    showData() {
      this.$axios.$get(this.url + "/" + this.$route.params.id).then((r) => {
        this.form = r;
        this.master_quiz_question = r.master_quiz_question;
      });
    },
    afterSave() {
      this.quiz = {};
      this.$router.push("/admin/quiz");
    },
    tambahQuiz() {
      this.quiz.choices = this.choices;
      this.quiz.correct_answer = this.jawaban;
      this.master_quiz_question.push(this.quiz);
      this.closeQuiz();
    },
    closeQuiz() {
      this.jawaban = "";
      this.choices = [
        {
          jawaban: "A",
          pilihan: "",
        },
        {
          jawaban: "B",
          pilihan: "",
        },
        {
          jawaban: "C",
          pilihan: "",
        },
        {
          jawaban: "D",
          pilihan: "",
        },
      ];
      this.quiz = {};
      this.quizDialog = false;
      this.indexQuiz = null;
    },
    save() {
      this.form.master_quiz_question = this.master_quiz_question;
      this.saveData();
    },
    addAttachment(data) {
      this.quiz.name = data.name;
      this.quiz.path = data.path;
      this.quiz.mime = data.mime;
      this.quiz.size = data.size;
      this.quiz.type = data.type;
      this.quiz.url = data.url;
      this.showAttachment = false;
    },
  },
};
</script>

<style>
.ck-editor__editable {
  min-height: 500px;
}
</style>