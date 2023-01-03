<template>
  <div>
    <el-form
      :model="formData"
      ref="formData"
      :rules="rules"
      label-width="120px"
      label-position="left"
      :inline="false"
      size="normal"
    >
      <el-row :gutter="20">
        <el-col :span="12" :offset="0">
          <el-form-item label="Name" prop="name">
            <el-input v-model="formData.name" placeholder="Name"></el-input>
            <div v-if="rules.name" class="text-danger">
              {{ rules.name[0] }}
            </div>
          </el-form-item>
          <el-form-item label="Email" prop="email">
            <el-input v-model="formData.email" placeholder="Email"></el-input>
            <div v-if="rules.email" class="text-danger">
              {{ rules.email[0] }}
            </div>
          </el-form-item>
          <el-form-item label="Password">
            <el-input
              v-model="formData.password"
              type="password"
              show-password
              placeholder="Password"
            ></el-input>
            <div v-if="rules.password" class="text-danger">
              {{ rules.password[0] }}
            </div>
          </el-form-item>
          <el-form-item label="Role">
            <el-select v-model="formData.role" placeholder="Role">
              <el-option
                v-for="item in roleList"
                :key="item.value"
                :label="item.label"
                :value="item.value"
              >
              </el-option>
            </el-select>
            <div v-if="rules.role" class="text-danger">
              {{ rules.role[0] }}
            </div>
          </el-form-item>
          <el-form-item label="Kelas">
            <el-select v-model="formData.kelas" placeholder="Kelas">
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
          <el-form-item label="Jenis Kelain">
            <el-select v-model="formData.gender" placeholder="Jenis Kelamin">
              <el-option
                v-for="item in ['L', 'P']"
                :key="item"
                :label="item"
                :value="item"
              >
              </el-option>
            </el-select>
            <div v-if="rules.gender" class="text-danger">
              {{ rules.gender[0] }}
            </div>
          </el-form-item>
        </el-col>
        <el-col :span="12" :offset="0">
          <el-form-item label="Telp">
            <el-input v-model="formData.phone" placeholder="Telp"></el-input>
            <div v-if="rules.phone" class="text-danger">
              {{ rules.phone[0] }}
            </div>
          </el-form-item>
          <el-form-item label="Alamat">
            <el-input
              v-model="formData.address"
              placeholder="Alamat"
            ></el-input>
            <div v-if="rules.address" class="text-danger">
              {{ rules.address[0] }}
            </div>
          </el-form-item>
          <el-form-item label="Nomor ID">
            <el-input v-model="formData.id_number" placeholder="Nomor ID">
            </el-input>
            <div v-if="rules.id_number" class="text-danger">
              {{ rules.id_number[0] }}
            </div>
          </el-form-item>
          <el-form-item label="Tempat Lahir">
            <el-input
              v-model="formData.place_of_birth"
              placeholder="Tempat Lahir"
            >
            </el-input>
            <div v-if="rules.place_of_birth" class="text-danger">
              {{ rules.place_of_birth[0] }}
            </div>
          </el-form-item>
          <el-form-item label="Tanggal Lahir">
            <el-date-picker
              v-model="formData.date_of_birth"
              type="date"
              placeholder="Tanggal Lahir"
              value-format="yyyy-MM-dd"
            >
            </el-date-picker>
            <div v-if="rules.date_of_birth" class="text-danger">
              {{ rules.date_of_birth[0] }}
            </div>
          </el-form-item>
        </el-col>
      </el-row>
      <hr />
      <div class="text-center">
        <el-button @click="$emit('close')">Cancel</el-button>
        <el-button
          type="primary"
          @click="save()"
          v-loading.fullscreen.lock="loadingSave"
          >Save</el-button
        >
      </div>
    </el-form>
  </div>
</template>

<script>
import crud from "../../mixins/crud";
import { mapState } from "vuex";
export default {
  props: {
    formData: { type: Object },
  },
  computed: {
    ...mapState(["roleList", "kelasList"]),
  },
  created() {
    this.$store.dispatch("fetchKelas");
  },
  mixins: [crud],

  data() {
    return {
      url: "/api/user",
      form: {},
    };
  },
  methods: {
    save() {
      this.form = this.formData;
      this.saveData();
    },
  },
};
</script>

<style lang="">
</style>