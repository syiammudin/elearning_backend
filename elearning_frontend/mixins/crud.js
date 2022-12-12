export default {
    data() {
        return {
            form: {},
            testing: {}, 
            filters: {},
            showForm: false, 
            rules: {},
            sort: "created_at",
            order: "descending",
            page: 1,
            pageSize: 10,
            paginate: {
                page: 1,
                pageSize: 10,
            },
            tableData: {},
            loading: false,
            loadingSave: false
        }
    },
    mounted() {
        this.getData()
    },
    methods: {
        searchData(filters = {}) {
            this.filters = { ...this.filters, ...filters }
            this.getData()
        },

        getData(afterRefresh = false) {
            this.loading = true;
            const params = {
                pageSize: this.pageSize,
                page: this.page,
                sort: this.sort,
                order: this.order,
                ...this.options,
                ...this.filters,
                ...this.defaultFilters
            };

            this.$axios.$get(this.url, { params }).then(r => {
                this.tableData = r
                this.$forceUpdate();
            })
            .catch(e => {
                this.$message({
                    message: e.response.data.message,
                    type: 'danger',
                    showClose: true,
                    duration: 3000,
                });         
           
            })
            .finally(() => (this.loading = false));
        },

        clearSearch() {
            this.paginate.page = 1;
            this.filters.search = '';
            this.getData()
        },

        saveData(additionalData = {}, NoCloseForm = false, NoRefreshData = false) {
            
            this.loadingSave = true
            this.$axios({
                method: this.form.id ? "put" : "post",
                url: this.form.id ? `${this.url}/${this.form.id}` : this.url,
                data: { ...this.form, ...additionalData },
            }).then((r) => {
               
                
                this.getData();
                this.form = {}
                this.rules = {}
                this.afterSave();
                this.showForm = false;
                this.$emit('save');
                this.$message({
                        message: r.data.message,
                        type: 'success',
                        showClose: true,
                        duration: 3000,
                });
            }).catch(e => {
                if (e.response.status == 422) {
                    this.rules = e.response.data.errors;
                    this.$refs['formData'].validate();
                }
                
                this.$message({
                    message: e.response.data.message,
                    type: 'danger',
                    showClose: true,
                    duration: 3000,
                });
                
            }).finally(() => {
                this.loadingSave = false
            })
        },


         deleteData(id) {
            this.$confirm('Anda yakin akan menghapus data ini?', 'Warning !', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'success',
            }).then(action => {
                this.loading = true
                this.$axios.$delete(`${this.url}/${id}`).then(r => {

                    this.getData();
                    this.$message({
                        message: r.message,
                        type: 'info',
                        showClose: true,
                        duration: 3000,
                    });

                }).catch(e => {
                    if (e.response.status) {
                    this.$dialog.message.error(e.response.data.message, {
                        position: 'top-center'
                    })
                    }
                }).finally(() => this.loading = false)
            }).catch(() => {
                
            });
            
        },

         sortChange(c) {
            if (c.prop != this.sort || c.order != this.order) {
                this.sort = c.prop;
                this.order = c.order;
                this.getData();
            }
        },
         
        afterSave() {
            
        },
         
        editData(item) {
            this.form = { ...item };
            this.showForm = true;
        },

        closeForm() {
            this.showForm = false;
            this.form = {}
            this.rules = {}
        },
        handleClose() {
         
        }
    },
}