<template >
  <div>
    <el-dialog
      title="Edit Profile"
      :visible.sync="show"
      width="60%"
      @close="$emit('close')"
    >
      <el-form
        :model="data"
        ref="data"
        :rules="rules"
        label-width="120px"
        label-position="left"
        :inline="false"
        size="normal"
      >
        <el-row :gutter="20">
          <el-col :span="12" :offset="0">
            <el-form-item label="Name" prop="name">
              <el-input v-model="data.name" placeholder="Name"></el-input>
              <div v-if="rules.name" class="text-danger">
                {{ rules.name[0] }}
              </div>
            </el-form-item>
            <el-form-item label="Email" prop="email">
              <el-input v-model="data.email" placeholder="Email"></el-input>
              <div v-if="rules.email" class="text-danger">
                {{ rules.email[0] }}
              </div>
            </el-form-item>

            <el-form-item label="Kelas">
              <el-select v-model="data.kelas" placeholder="Kelas">
                <el-option
                  v-for="item in kelasList"
                  :key="item.id"
                  :label="item.name"
                  :value="item.id"
                >
                </el-option>
              </el-select>
              <div v-if="rules.kelas" class="text-danger">
                {{ rules.kelas[0] }}
              </div>
            </el-form-item>
            <el-form-item label="Telp">
              <el-input v-model="data.phone" placeholder="Telp"></el-input>
              <div v-if="rules.phone" class="text-danger">
                {{ rules.phone[0] }}
              </div>
            </el-form-item>
            <el-form-item label="Alamat">
              <el-input
                type="textarea"
                v-model="data.address"
                placeholder="Alamat"
              ></el-input>
              <div v-if="rules.address" class="text-danger">
                {{ rules.address[0] }}
              </div>
            </el-form-item>
          </el-col>
          <el-col :span="12" :offset="0">
            <el-form-item label="Tempat Lahir">
              <el-input
                v-model="data.place_of_birth"
                placeholder="Tempat Lahir"
              >
              </el-input>
              <div v-if="rules.place_of_birth" class="text-danger">
                {{ rules.place_of_birth[0] }}
              </div>
            </el-form-item>
            <el-form-item label="Tanggal Lahir">
              <el-date-picker
                v-model="data.date_of_birth"
                type="date"
                placeholder="Tanggal Lahir"
                value-format="yyyy-MM-dd"
              >
              </el-date-picker>
              <div v-if="rules.date_of_birth" class="text-danger">
                {{ rules.date_of_birth[0] }}
              </div>
            </el-form-item>
            <el-form-item label="Photo">
              <el-button
                type="primary"
                size="default"
                plain
                @click="showAttachment = true"
              >
                <i class="el-icon-upload"></i> Upload Photo
              </el-button>
              <div class="col-md-8 mt-1" v-if="data.url">
                <el-image :src="data.url" fit="fit" :lazy="true"></el-image>
              </div>
            </el-form-item>
          </el-col>
        </el-row>
      </el-form>
      <span></span>
      <span slot="footer">
        <el-button size="small" @click="$emit('close')">Cancel</el-button>
        <el-button
          size="small"
          type="primary"
          @click="save()"
          v-loading.fullscreen.lock="loadingSave"
        >
          Update
        </el-button>
      </span>
    </el-dialog>

    <Attachment
      v-if="showAttachment == true"
      type="image/"
      :show="showAttachment"
      @close="showAttachment = false"
      @addAttachment="addAttachment"
    />
  </div>
</template>
<script>
import { mapState } from "vuex";
export default {
  props: ["show", "data"],
  computed: {
    ...mapState(["roleList", "kelasList"]),
  },
  created() {
    this.$store.dispatch("fetchKelas");
  },
  data() {
    return {
      rules: {},
      showAttachment: false,
      loadingSave: false,
    };
  },
  methods: {
    addAttachment(data) {
      this.data.photo = data.path;
      this.data.url = data.url;
      this.showAttachment = false;
    },
    save() {
      this.$axios
        .$put("/api/user/" + this.data.id, this.data)
        .then((r) => {
          this.$emit("save");
        })
        .catch((e) => {
          this.$message({
            message: e.response.data.message,
            type: "danger",
            showClose: true,
            duration: 3000,
          });
        })
        .finally(() => (this.loadingSave = false));
    },
  },
};
</script>
<style lang="">
</style>