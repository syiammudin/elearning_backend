<template>
  <div>
    <el-card shadow="always" :body-style="{ padding: '20px' }">
      <div slot="header">
        <span>Komentar</span>
      </div>
      <el-input
        type="textarea"
        :rows="2"
        v-model="form.comment"
        placeholder="Tulis komentar disini"
        :show-word-limit="false"
        :autosize="{ minRows: 2, maxRows: 4 }"
      ></el-input>
      <div class="text-right mb-2">
        <el-button
          class="mt-1"
          @click.native="addComment"
          type="primary"
          size="small"
        >
          Comment
        </el-button>
      </div>
      <br />
      <div v-for="(c, index) in comment" :key="index">
        <el-divider direction="horizontal" content-position="left"></el-divider>
        <div class="d-flex">
          <div class="p-2">
            <el-avatar class="mt-2"> {{ c.user.initial_name }} </el-avatar>
          </div>
          <div class="mr-auto p-2">
            <span class="title"> {{ c.user.name }} <br /> </span>
            <span class="time mb-2" style="margin-top: -100px">
              <i class="el-icon-time"></i> {{ dateTimeFormat(c.created_at) }}
            </span>
            <p
              v-html="c.comment.replace(/(?:\r\n|\r|\n)/g, '<br />')"
              class="mt-2"
            ></p>
          </div>
          <div class="p-1 text-right">
            <a v-if="c.user_id == $auth.user.id" @click="deleteComment(c.id)">
              <i class="el-icon-delete"></i>
            </a>
          </div>
        </div>
      </div>
    </el-card>
  </div>
</template>

<script>
import plugin from "../mixins/plugin";

export default {
  props: ["data", "comment"],
  mixins: [plugin],
  data() {
    return { form: {} };
  },
  methods: {
    getComment() {
      this.$axios
        .$get(
          "api/comment?commentable_id=" +
            this.data.id +
            "&commentable_type=" +
            this.data.class
        )
        .then((r) => {
          this.comment = r;
        });
    },
    addComment() {
      this.loading = true;
      this.form.commentable_id = this.data.id;
      this.form.commentable_type = this.data.class;
      this.$axios
        .$post("api/comment", this.form)
        .then((r) => {
          this.getComment();
          this.$message({
            message: "Rating update",
            type: "success",
            showClose: true,
            duration: 3000,
          });
          this.form = {};
        })
        .catch((e) => {
          this.$message({
            message: e.response.data.message,
            type: "danger",
            showClose: true,
            duration: 3000,
          });
        })
        .finally(() => {
          this.loading = false;
        });
    },
    deleteComment(id) {
      this.$confirm("apakah yakin mau menghapus comment", "Warning", {
        confirmButtonText: "OK",
        cancelButtonText: "Cancel",
        type: "success",
      }).then((action) => {
        this.$axios.$delete("api/comment/" + id).then((r) => {
          this.getComment();
        });
      });
    },
  },
};
</script>