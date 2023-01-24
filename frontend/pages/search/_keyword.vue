<template>
  <div>
    <div class="d-flex mt-2">
      <div class="mr-auto p-2"></div>
      <div class="p-1 text-right">
        <el-input
          placeholder="Search"
          @change="search()"
          v-model="keyword"
          size="small"
          clearable
        >
          <el-button
            slot="append"
            icon="el-icon-search"
            @click="search()"
          ></el-button>
        </el-input>
      </div>
    </div>
    <el-card shadow="always" class="mt-2" :body-style="{ padding: '20px' }">
      <div class="card d-flex">
        <div class="card-body">
          <table class="table table-hover table-forum">
            <tbody>
              <tr v-if="data.length == 0">
                <td class="text-center">No data found</td>
              </tr>
              <tr
                v-else
                v-for="(d, i) in data"
                :key="i"
                @click="$router.push(d.url)"
              >
                <td
                  scope="row"
                  class="text-nowrap text-center"
                  style="width: 200px"
                >
                  <el-image
                    v-if="d.modul != 'Quiz'"
                    :src="d.searcable.attachment.url"
                    fit="cover"
                    style="height: 130px"
                    :lazy="true"
                  ></el-image>
                  <el-avatar
                    v-else
                    shape="square"
                    :size="100"
                    :src="'https://cube.elemecdn.com/e/fd/0fc7d20532fdaf769a25683617711png.png'"
                  ></el-avatar>
                </td>
                <td class="text-start">
                  <span class="font-weight-bold blue-text">
                    {{ d.title }}
                  </span>
                  <div class="my-2">
                    <span href="#" class="blue-text">
                      <strong>{{ d.modul }}</strong>
                    </span>
                  </div>
                  <div>
                    <span class="time">
                      {{ d.searcable.user.name }} -
                      <time class="time" style="font-size: 10pt, sy">
                        <i class="el-icon-time"></i>
                        {{ dateFormat(d.created_at) }}
                      </time>
                    </span>
                  </div>
                </td>
                <td>
                  <el-rate
                    v-if="d.modul != 'Quiz'"
                    v-model="d.searcable.rating_value"
                    disabled
                  >
                  </el-rate>
                </td>
              </tr>
            </tbody>
            <!--Table body-->
          </table>
        </div>
      </div>
    </el-card>
  </div>
</template>
<script>
import plugin from "../../mixins/plugin";

export default {
  mixins: [plugin],
  data() {
    return {
      data: {},
      keyword: this.$route.params.keyword,
    };
  },
  methods: {
    search() {
      this.$router.push("/search/" + this.keyword);
    },
    getData() {
      const params = {
        keyword: this.$route.params.keyword,
      };
      this.$axios.$get("api/searchBox", { params }).then((r) => {
        this.data = r;
      });
    },
  },
  mounted() {
    this.getData();
  },
};
</script>
<style lang="">
</style>