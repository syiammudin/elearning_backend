<template>
  <div class="mb-5">
    <el-card shadow="always" :body-style="{ padding: '20px' }">
      <div slot="header">
        <span>
          <b>
            <h1>{{ data.exam_quiz.subject }}</h1>
          </b>
        </span>
      </div>
      <div class="text-center">
        <el-button type="primary" size="default" @click="mulaiExam">
          Mulai Exam
        </el-button>
      </div>
    </el-card>

    <ExamForm :data="data" :show="showForm" @close="close"></ExamForm>
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
      showForm: false,
    };
  },
  methods: {
    mulaiExam() {
      this.showForm = true;
      // this.$router.push("/quiz/1/" + this.data.id);
    },
    close() {
      this.showForm = false;
    },
  },
};
</script>