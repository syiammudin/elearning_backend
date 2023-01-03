<template>
  <div class="mb-5">
    <el-divider direction="horizontal" content-position="left"></el-divider>
    <div class="row">
      <div class="col-md-12">
        <el-card shadow="always" :body-style="{ padding: '20px' }">
          <div slot="header">
            <h1>{{ data.subject }}</h1>
          </div>
          <el-image :src="data.attachment.url" fit="fill" :lazy="true">
          </el-image>

          <p v-html="data.description"></p>
        </el-card>
      </div>
      <div class="col-md-9">
        <Comment :data="data" :comment="comment" />
      </div>
      <div class="col-md-3">
        <el-card shadow="always" :body-style="{ padding: '20px' }">
          <div slot="header">
            <span class="title">{{ data.title }}</span> <br />
            <span class="time">
              <i class="el-icon-time"></i> {{ dateTimeFormat(data.created_at) }}
            </span>
          </div>
          <div class="row">
            <div class="col-md-8" @click="rating()">
              <el-rate disabled v-model="data.rating_value" :allow-half="false">
              </el-rate>
            </div>
            <div class="col-md-4 text-right" @click="rating()">
              <a>
                <i class="el-icon-edit time"></i>
              </a>
            </div>
          </div>
          <br />
        </el-card>
      </div>
    </div>

    <Rating
      :data="data"
      :form="form"
      :show="showFormRating"
      @rating="getRating"
    ></Rating>
  </div>
</template>
<script>
import plugin from "../../mixins/plugin";

export default {
  mixins: [plugin],
  async asyncData({ $axios, params, $auth }) {
    const data = await $axios.$get("api/laboratorium/" + params.id);

    const comment = await $axios.$get(
      "api/comment?commentable_id=" +
        data.id +
        "&commentable_type=" +
        data.class
    );
    return { data, comment };
  },
  data() {
    return {
      form: {},
      showFormRating: false,
      loading: false,
    };
  },
  methods: {
    rating() {
      this.showFormRating = true;
      this.form.value = this.data.rating_value;
    },
    getRating(data) {
      this.showFormRating = false;
      this.data.rating_value = data;
    },
  },
};
</script>