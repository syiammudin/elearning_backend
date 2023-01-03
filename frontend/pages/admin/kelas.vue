<template>
  <div>
    <el-card shadow="always" :body-style="{ padding: '20px' }">
      <div slot="header">
        <el-row :gutter="20">
          <el-col :span="12" :offset="0">
            <strong> Kelas </strong>
          </el-col>
          <el-col :span="12" :offset="0" class="text-right">
            <el-button type="primary" size="small" @click="showForm = true">
              <i class="el-icon-plus"></i> Add New Category
            </el-button>
            <el-input
              style="width: 200px"
              v-model="filters.search"
              placeholder="Search"
              size="small"
              clearable
              @change="getData()"
            ></el-input>
          </el-col>
        </el-row>
      </div>

      <el-table
        @sort-change="sortChange"
        :default-sort="{ prop: sort, order: order }"
        :data="tableData.data"
        style="width: 100%"
        v-loading="loading"
      >
        <el-table-column prop="name" label="Name" sortable />
        <el-table-column prop="keterangan" label="keterangan" />
        <el-table-column prop="status" label="Status">
          <template slot-scope="scope">
            <el-tag size="mini" :type="scope.row.status ? 'success' : 'danger'">
              {{ scope.row.status ? "Active" : "Non Active" }}
            </el-tag>
          </template>
        </el-table-column>
        <el-table-column prop="created_at" label="Created at">
          <template slot-scope="scope">
            {{ dateFormat(scope.row.created_at) }}
          </template>
        </el-table-column>
        <el-table-column fixed="right" label="#" width="40">
          <template slot-scope="scope">
            <div>
              <el-dropdown>
                <span class="el-dropdown-link">
                  <i class="el-icon-arrow-down el-icon--right"></i>
                </span>
                <el-dropdown-menu slot="dropdown">
                  <el-dropdown-item @click.native="deleteData(scope.row.id)">
                    <i class="el-icon-delete text-danger"></i>
                    Hapus</el-dropdown-item
                  >
                  <el-dropdown-item @click.native="editData(scope.row)">
                    <i class="el-icon-edit text-success"></i>
                    Edit</el-dropdown-item
                  >
                </el-dropdown-menu>
              </el-dropdown>
            </div>
          </template>
        </el-table-column>
      </el-table>
      <el-pagination
        background
        @size-change="
          (s) => {
            pageSize = s;
            getData();
          }
        "
        @current-change="
          (p) => {
            page = p;
            getData();
          }
        "
        :page-size="pageSize"
        :page-sizes="[5, 10, 25, 50, 100]"
        layout="prev, pager, next, sizes, total"
        :total="tableData.total"
      >
      </el-pagination>
    </el-card>

    <el-dialog
      title="Add User"
      :visible.sync="showForm"
      width="30%"
      @close="closeForm"
    >
      <el-form
        :model="form"
        ref="form"
        :rules="rules"
        label-width="100px"
        :inline="false"
        size="normal"
      >
        <el-form-item label="Name">
          <el-input v-model="form.name"></el-input>
          <div v-if="rules.name" class="text-danger">{{ rules.name[0] }}</div>
        </el-form-item>
        <el-form-item label="Keterangan">
          <el-input
            type="textarea"
            :rows="2"
            v-model="form.keterangan"
            placeholder="keterangan"
            :maxlength="-1"
            :show-word-limit="false"
            :autosize="{ minRows: 2, maxRows: 4 }"
          >
          </el-input>

          <div v-if="rules.keterangan" class="text-danger">
            {{ rules.keterangan[0] }}
          </div>
        </el-form-item>
        <el-form-item label="Status">
          <el-switch
            v-model="form.status"
            active-color="#13ce66"
            inactive-color="#ff4949"
            active-text="Active"
            inactive-text="Non Active"
          >
          </el-switch>

          <div v-if="rules.status" class="text-danger">
            {{ rules.status[0] }}
          </div>
        </el-form-item>
        <el-form-item>
          <el-button
            type="primary"
            @click="saveData"
            :disable="loading == true"
            v-loading.fullscreen.lock="loading"
            >Save</el-button
          >
          <el-button @click="closeForm">Cancel</el-button>
        </el-form-item>
      </el-form>
    </el-dialog>
  </div>
</template>
<script>
import crud from "../../mixins/crud";
import plugin from "../../mixins/plugin";
export default {
  mixins: [crud, plugin],
  layout: "adminLayout",
  data() {
    return {
      url: "/api/kelas",
    };
  },
  methods: {
    editData(item) {
      if (item.status == 1) {
        item.status = true;
      } else {
        item.status = false;
      }
      this.form = { ...item };
      this.showForm = true;
    },
  },
};
</script>