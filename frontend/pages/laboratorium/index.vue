<template>
  <div>
    <el-card shadow="always" :body-style="{ padding: '20px' }">
      <div slot="header">
        <span>New Content</span>
      </div>
      <!-- card body -->

      <div class="row">
        <div class="col-md-3 mb-3" v-for="(d, index) in data.data" :key="index">
          <el-card @click.native="$router.push('/laboratorium/' + d.id)">
            <el-image :src="d.attachment.url" fit="fit" :lazy="true"></el-image>

            <br />
            <el-rate v-model="d.rating_value" disabled> </el-rate>
            <hr />
            <div>
              <span>
                <strong>{{ d.subject }} </strong>
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
import VueVideoThumbnail from "vue-video-thumbnail";
import plugin from "../../mixins/plugin";

export default {
  name: "IndexPage",
  components: { VueVideoThumbnail },
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
      const params = {
        pageSize: 8,
        sort: "created_at",
        order: "desc",
      };
      this.$axios.$get("api/laboratorium", { params }).then((r) => {
        this.data = r;
      });
    },
  },
};
</script>
