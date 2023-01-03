<template>
  <div>
    <el-card
      v-loading="loadingSave"
      shadow="always"
      element-loading-text="Loading..."
      :body-style="{ padding: '20px' }"
    >
      <div slot="header">
        <span>Form Add video Content</span>
      </div>
      <!-- card body -->
      <el-form
        :model="form"
        ref="form"
        :rules="rules"
        label-width="120px"
        :inline="false"
        size="normal"
      >
        <el-row :gutter="20">
          <el-col :span="12" :offset="0">
            <el-form-item label="Title" :class="rules.title ? 'is-error' : ''">
              <el-input
                v-model="form.title"
                placeholder="Title of Video"
                clearables
              ></el-input>
              <div class="el-form-item__error" v-if="rules.title">
                {{ rules.title.join(", ") }}
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
            <el-form-item label="Kelas">
              <el-select
                v-model="form.kelas"
                placeholder="Kelas"
                clearable
                filterable
              >
                <el-option
                  v-for="item in kelasList"
                  :key="item.id"
                  :label="item.name"
                  :value="item.id"
                >
                </el-option>
              </el-select>
            </el-form-item>
            <el-form-item label="Type Video">
              <el-select
                v-model="form.type"
                placeholder="Type Upload"
                clearable
                filterable
              >
                <el-option
                  v-for="item in type"
                  :key="item.value"
                  :label="item.text"
                  :value="item.value"
                >
                </el-option>
              </el-select>
            </el-form-item>
            <el-form-item label="Url Youtube" v-if="form.type == 'Embed'">
              <el-input
                v-if="form.type == 'Embed'"
                v-model="form.type_value"
                placeholder="Url Youtube"
                size="normal"
              ></el-input>
            </el-form-item>

            <el-form-item label="Upladod Video" v-if="form.type == 'Upload'">
              <el-button
                type="primary"
                size="default"
                plain
                @click="showVideo = true"
              >
                <i class="el-icon-upload"></i> Upload Video
              </el-button>
              <br />
              <div class="col-md-8 mt-1 p-2" v-if="form.filename">
                <Media
                  :kind="'video'"
                  :src="form.url"
                  :autoplay="false"
                  :controls="true"
                  :loop="false"
                  :ref="'video_player'"
                  width="auto"
                  style="width: 100%"
                ></Media>
              </div>
            </el-form-item>
          </el-col>
          <el-col :span="12" :offset="0">
            <el-form-item label="Descyption" size="normal">
              <el-input
                type="textarea"
                :rows="6"
                v-model="form.description"
                placeholder="Descryption of Video"
                :show-word-limit="false"
                :autosize="{ minRows: 6, maxRows: 10 }"
              >
              </el-input>
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
          </el-col>
        </el-row>
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
  computed: {
    ...mapState(["categoryList", "kelasList"]),
  },
  created() {
    this.$store.dispatch("fetchCategory");
    this.$store.dispatch("fetchKelas");
  },
  data() {
    return {
      url: "/api/videoContent",
      showAttachment: false,
      showVideo: false,
      type: [
        {
          value: "Upload",
          text: "Upload",
        },
        {
          value: "Embed",
          text: "Link Youtube",
        },
        // {
        //   value: "Url",
        //   text: "URL",
        // },
      ],
    };
  },
  mounted() {
    if (this.$route.params.id != 0) {
      this.showData();
    }
  },
  methods: {
    afterSave() {
      this.$router.push("/admin/videoContent");
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