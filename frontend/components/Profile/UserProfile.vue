<template >
  <div>
    <div class="d-flex justify-content-between mb-3">
      <div>
        <h5><b>Profile</b></h5>
      </div>
      <div></div>
      <div>
        <el-button
          type="text"
          icon="el-icon-edit"
          size="mini"
          @click="edit(data)"
          >Edit</el-button
        >
      </div>
    </div>
    <table class="table table-sm">
      <tbody>
        <tr>
          <td style="width: 200px">Name</td>
          <td>{{ data.name }}</td>
          <td rowspan="6" class="text-center align-middle">
            <el-image
              style="width: 120px; height: 180px"
              :src="data.url"
              fit="cover"
            ></el-image>
          </td>
        </tr>
        <tr>
          <td style="width: 200px">Kelas</td>
          <td>{{ data.kelas }}</td>
        </tr>
        <tr>
          <td style="width: 200px">Phone</td>
          <td>{{ data.phone }}</td>
        </tr>
        <tr>
          <td style="width: 200px">Tempat, Tanggal lahir</td>
          <td>{{ data.place_of_birth }}, {{ data.date_of_birth }}</td>
        </tr>
        <tr>
          <td style="width: 200px">Address</td>
          <td>{{ data.address }}</td>
        </tr>
      </tbody>
    </table>

    <ProfileForm
      v-if="showDialog == true"
      :show="showDialog"
      :data="data"
      @close="showDialog = false"
      @save="save"
    />
  </div>
</template>
<script>
export default {
  data() {
    return {
      showDialog: false,
      data: {},
    };
  },
  mounted() {
    this.getData();
  },
  methods: {
    save() {
      this.getData();
      this.showDialog = false;
    },
    edit(data) {
      this.showDialog = true;
    },
    getData() {
      this.$axios.$get("/api/user/" + this.$auth.user.id).then((r) => {
        this.data = r;
      });
    },
  },
};
</script>
<style lang="">
</style>