<template>
  <div>
    <el-card
      v-loading="loadingSave"
      shadow="always"
      element-loading-text="Loading..."
      :body-style="{ padding: '20px' }"
    >
      <div slot="header">
        <span>Form Laboratorium</span>
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
          label="Subject of Laboratorium"
          :class="rules.subject ? 'is-error' : ''"
        >
          <el-input v-model="form.subject" placeholder="" size="normal">
          </el-input>
          <div class="el-form-item__error" v-if="rules.subject">
            {{ rules.subject.join(", ") }}
          </div>
        </el-form-item>
        <el-form-item label="Category">
          <el-select
            v-model="form.category_id"
            placeholder="Category Video"
            clearable
            filterable
          >
            <el-option
              v-for="item in categoryList"
              :key="item.id"
              :label="item.name"
              :value="item.id"
            >
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item
          label="Description"
          :class="rules.description ? 'is-error' : ''"
        >
          <ckeditor-nuxt v-model="form.description" :config="editorConfig" />
          <div class="el-form-item__error" v-if="rules.description">
            {{ rules.description.join(", ") }}
          </div>
        </el-form-item>
        <el-form-item label="Poster">
          <el-button
            type="primary"
            size="default"
            plain
            @click="showAttachment = true"
          >
            <i class="el-icon-upload"></i> Upload Poster
          </el-button>
          <div class="col-md-8 mt-1" v-if="form.attachment">
            <el-image
              :src="form.attachment.url"
              fit="fit"
              :lazy="true"
            ></el-image>
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

    <Attachment
      v-if="showAttachment == true"
      type="image/"
      :show="showAttachment"
      @close="showAttachment = false"
      @addAttachment="addAttachment"
    />

    <Attachment
      v-if="showVideo == true"
      type="video/"
      :show="showVideo"
      @close="showVideo = false"
      @addAttachment="addVideo"
    />
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
    ...mapState(["categoryList", "Kelas"]),
  },
  created() {
    this.$store.dispatch("fetchCategory");
  },
  data() {
    return {
      url: "/api/laboratorium",
      showAttachment: false,
      showVideo: false,
      editorConfig: {
        plugin: ["ImageStyle:full"],
        removePlugins: ["Title"],
        simpleUpload: {
          uploadUrl: `${this.$axios.defaults.baseURL}/api/uploadCkEditor`,
          withCredentials: true,
        },
      },
    };
  },
  mounted() {
    if (this.$route.params.id != 0) {
      this.showData();
    }
  },
  methods: {
    afterSave() {
      this.$router.push("/admin/laboratorium");
    },
    showData() {
      this.$axios.$get(this.url + "/" + this.$route.params.id).then((r) => {
        this.form = r;
      });
    },
    addAttachment(data) {
      console.log(data);
      this.form.attachment = data;
      this.showAttachment = false;
    },
    addVideo(data) {
      this.form.filename = data.name;
      this.form.path = data.path;
      this.form.mime = data.mime;
      this.form.size = data.size;
      this.form.url = data.url;
      this.showVideo = false;
    },
  },
};
</script>

<style>
.ck-editor__editable {
  min-height: 500px;
}
</style>