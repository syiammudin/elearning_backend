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
            type="text"
            :rows="2"
            :autosize="{ minRows: 2, maxRows: 4 }"
            size="normal"
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

        <el-col class="text-center mb-4">
          <el-button @click="$router.go(-1)">Cancel</el-button>
          <el-button
            type="primary"
            @click="saveData"
            v-loading.lock="loadingSave"
            >{{ form.id ? "Update" : "Save" }}</el-button
          >
        </el-col>
      </el-form>
      <label>Question </label>
      <el-button type="primary" size="default" @click="quizDialog = true">
        Add Quiz
      </el-button>

      <el-dialog
        title="Quiz Dialog"
        :visible.sync="quizDialog"
        width="50%"
        @close="closeForm"
      >
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
                <li
                  v-for="(c, i) in ['A', 'B', 'C', 'D']"
                  class="list-item"
                  :key="i"
                >
                  <el-checkbox label="" :indeterminate="false">
                    {{ c }}
                  </el-checkbox>
                </li>
              </ul>
            </div>
          </el-form-item>
        </el-form>

        <span></span>
        <span slot="footer">
          <el-button @click="quizDialog = false">Cancel</el-button>
          <el-button type="primary">OK</el-button>
        </span>
      </el-dialog>
    </el-card>
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
    ...mapState(["categoryList", "Kelas"]),
  },
  created() {
    this.$store.dispatch("fetchCategory");
  },
  data() {
    return {
      choices: ["", "", "", ""],
      quizDialog: false,
      url: "/api/laboratorium",
      showAttachment: false,
      showVideo: false,
      quiz: {},
      active: "",
      editorConfig: {
        plugin: ["ImageStyle:full"],
        removePlugins: ["Title"],
        simpleUpload: {
          uploadUrl: `${this.$axios.defaults.baseURL}/api/uploadCkEditor`,
          withCredentials: true,
        },
      },
    };
  },
  mounted() {
    if (this.$route.params.id != 0) {
      this.showData();
    }
  },
  methods: {
    afterSave() {
      this.$router.push("/admin/laboratorium");
    },
    showData() {
      this.$axios.$get(this.url + "/" + this.$route.params.id).then((r) => {
        this.form = r;
      });
    },
    addAttachment(data) {
      console.log(data);
      this.form.attachment = data;
      this.showAttachment = false;
    },
    addVideo(data) {
      this.form.filename = data.name;
      this.form.path = data.path;
      this.form.mime = data.mime;
      this.form.size = data.size;
      this.form.url = data.url;
      this.showVideo = false;
    },
  },
};
</script>

<style>
.ck-editor__editable {
  min-height: 500px;
}
</style>