<template lang="">
    <div>
      <el-dialog
        :title="'Upload File ' + type.replace('/','').toUpperCase()"
        :visible.sync="show"
        :before-close="beforeclose"
        width="540px"
        @close="$emit('close')">
          <el-card shadow="always" >
            <div class="text-center" @click="clickHandler" >
              <div class="pa-3 ma-auto text-center"> 
                <i class="el-icon-upload text-primary display-2" type="primary" ></i>
                 <p v-if="!showProgress">Click to upload File...</p>
                 <p v-else>
                  Uploading file... ({{ uploadPercentage }}%) <br>
                  </p>
                  <div v-if="attachment">
                    {{ attachment.name }}
                  </div>
              </div>
            </div>
          </el-card>
        <span slot="footer">
          <el-button :disabled="showProgress" @click="$emit('close')">Cancel</el-button>
          <el-button :disabled="showProgress" type="primary" @click="$emit('addAttachment', attachment)">OK</el-button>
        </span>
      </el-dialog>
    </div>
</template>
<script>
export default {
  props: {
    show: { type: Boolean, default: false },
    type: { type: String, default: null },
  },
  data() {
    return {
      attachment: [],
      showRemark: false,
      showProgress: false,
      uploadPercentage: 0,
    };
  },
  methods: {
    beforeclose() {
      this.$emit("close");
    },
    clickHandler(ev) {
      const el = document.createElement("input");
      el.type = "file";
      el.multiple = true;
      if (this.type == "video/") {
        el.accept = ".mp4,.mov";
      } else {
        el.accept = ".jpg,.jpeg";
      }

      el.addEventListener("change", (event) => {
        for (let i = 0; i < event.target.files.length; i++) {
          this.uploadFile(event.target.files[i]);
        }
      });

      el.click();
    },
    uploadFile(file) {
      this.showProgress = true;
      this.fileName = "Uploading...";
      const formData = new FormData();
      formData.append("file", file);

      this.$axios
        .$post(`/api/attachment?type=` + this.type, formData, {
          headers: { "Content-Type": "multipart/form-data" },
          onUploadProgress: function (progressEvent) {
            this.showProgress = true;
            this.uploadPercentage = parseInt(
              Math.round((progressEvent.loaded / progressEvent.total) * 100)
            );
          }.bind(this),
        })
        .then((r) => {
          this.attachment = r;
          this.showProgress = false;
          this.$forceUpdate();
        })
        .catch((e) => {
          this.showProgress = false;
          this.$dialog.message.error(e.response.data.message, {
            position: "top",
          });
        });
    },
  },
};
</script>
<style lang="">
</style>