<template>
  <div>
    <el-card shadow="always" :body-style="{ padding: '20px' }">
      <div slot="header">
        <span> <b>Materi</b> </span>
      </div>
      <!-- card body -->

      <div class="row">
        <div class="col-md-3 mb-3" v-for="(d, index) in data.data" :key="index">
          <el-card @click.native="$router.push('/video/' + d.id)">
            <div class="text-center">
              <el-image
                :src="d.attachment.url"
                fit="cover"
                style="height: 130px"
                :lazy="true"
              ></el-image>
            </div>

            <br />
            <el-rate v-model="d.rating_value" disabled> </el-rate>
            <hr />
            <div>
              <span>
                <strong>{{ d.title }} </strong>
              </span>
              <div class="bottom clearfix">
                <time class="time" style="font-size: 10pt, sy">
                  <i class="el-icon-time"></i> {{ dateFormat(d.created_at) }}
                </time>
              </div>
            </div>
          </el-card>
        </div>
      </div>
    </el-card>
  </div>
</template>

<script>
import plugin from "../../mixins/plugin";

export default {
  name: "IndexPage",
  mixins: [plugin],
  data() {
    return {
      value: [4, 5, 5, 4, 3, 4, 5, 2],
      data: {},
    };
  },
  mounted() {
    this.getData();
  },
  methods: {
    getData() {
      const params = {
        pageSize: 4,
        sort: "created_at",
        order: "desc",
      };
      this.$axios.$get("api/videoContentHomepage", { params }).then((r) => {
        this.data = r;
      });
    },
  },
};
</script>
