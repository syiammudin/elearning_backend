<template >
  <div>
    <el-card shadow="always" :body-style="{ padding: '20px' }">
      <div slot="header">
        <el-row :gutter="20">
          <el-col :span="12" :offset="0">
            <strong> User </strong>
          </el-col>
          <el-col :span="12" :offset="0" class="text-right">
            <el-button type="primary" size="small" @click="showForm = true">
              <i class="el-icon-plus"></i> Add New User
            </el-button>
            <el-input
              style="width: 200px"
              v-model="filters.serach"
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
      >
        <el-table-column prop="name" label="Name" sortable />
        <el-table-column prop="email" label="Email" />
        <el-table-column prop="role_name" label="Role" />
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
      width="50%"
      @close="closeForm"
    >
      <UserForm
        :formData="form"
        @close="closeForm"
        @save="getData(), (showForm = false)"
      />
    </el-dialog>
  </div>
</template>

<script>
import crud from "../../mixins/crud";
import plugin from "../../mixins/plugin";

export default {
  mixins: [plugin, crud],
  layout: "adminLayout",
  data() {
    return {
      url: "/api/user",
    };
  },
  methods: {},
};
</script>