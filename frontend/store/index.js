
export const state = () => ({
  roleList: [
    {value: 0, label: 'USER'},
    {value: 10, label: 'ADMIN'},
    {value: 99, label: 'SUPERADMIN'},
  ],
  kelasList: [],
  categoryList: [],
});


export const mutations = {
  setCategoryList(state, data) {
      state.categoryList = data;
  },
  setKelasList(state, data) {
      state.kelasList = data;
  },
};

export const actions = {
  async fetchCategory({ commit }, params = { 'type': 'list' }) {
      const category = await this.$axios.$get("/api/category", { params });
      commit("setCategoryList", category);
  },
  async fetchKelas({ commit }, params = { 'type': 'list' }) {
      const kelas = await this.$axios.$get("/api/kelas", { params });
      commit("setKelasList", kelas);
  },
};
