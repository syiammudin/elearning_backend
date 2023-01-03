<template>
  <div>
    <el-card
      v-loading="loadingSave"
      shadow="always"
      element-loading-text="Loading..."
      :body-style="{ padding: '20px' }"
    >
      <div slot="header">
        <span>Form Exam</span>
      </div>
      <!-- card body -->
      <el-form
        :model="form"
        ref="form"
        :rules="rules"
        label-width="250px"
        :inline="false"
        size="normal"
      >
        <el-form-item
          label="Master Quiz"
          :class="rules.master_quiz_id ? 'is-error' : ''"
        >
          <el-select
            v-model="form.master_quiz_id"
            placeholder="Master Quiz"
            clearable
            filterable
            size="small"
            remote
            :remote-method="masterQuiz"
            :loading="loading"
          >
            <el-option
              v-for="item in dataQuiz"
              :key="item.id"
              :label="item.subject"
              :value="item.id"
            >
            </el-option>
          </el-select>
          <div class="el-form-item__error" v-if="rules.master_quiz_id">
            {{ rules.master_quiz_id.join(", ") }}
          </div>
        </el-form-item>
        <el-form-item label="Kelas" :class="rules.subject ? 'is-error' : ''">
          <el-select
            v-model="form.master_quiz_id"
            placeholder="Master Quiz"
            clearable
            filterable
            size="small"
          >
            <el-option
              v-for="item in kelasList"
              :key="item.id"
              :label="item.name"
              :value="item.id"
            >
            </el-option>
          </el-select>
          <div class="el-form-item__error" v-if="rules.subject">
            {{ rules.subject.join(", ") }}
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
    ...mapState(["categoryList", "kelasList"]),
  },
  created() {
    this.$store.dispatch("fetchCategory");
    this.$store.dispatch("fetchKelas");
  },
  data() {
    return {
      url: "/api/exam",
      dataQuiz: [],
      loading: false,
    };
  },
  mounted() {
    this.masterQuiz();
    if (this.$route.params.id != 0) {
      this.showData();
    }
  },
  methods: {
    masterQuiz(data) {
      const params = {
        search: data,
      };

      this.loading = true;

      this.$axios.$get("/api/masterQuiz", { params }).then((r) => {
        this.dataQuiz = r.data;
        this.loading = false;
      });
    },
    afterSave() {
      this.$router.push("/admin/exam");
    },
  },
};
</script>

<style>
.ck-editor__editable {
  min-height: 500px;
}
</style>