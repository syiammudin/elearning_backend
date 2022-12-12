import { list } from "postcss";
export const state = () => ({
  roleList: [
    {value: 0, label: 'USER'},
    {value: 10, label: 'ADMIN'},
    {value: 99, label: 'SUPERADMIN'},
  ],
  Kelas: [
    {value: '7', label: 'VII'},
    {value: '8', label: 'VIII'},
    {value: '9', label: 'IX'},
    {value: '10', label: 'X'},
    {value: '11', label: 'XI'},
    {value: '12', label: 'XII'},
  ],
  categoryList: [],
});


export const mutations = {
  setCategoryList(state, data) {
      state.categoryList = data;
  },
};

export const actions = {
  async fetchCategory({ commit }, params = { 'type': 'list' }) {
      const category = await this.$axios.$get("/api/category", { params });
      commit("setCategoryList", category);
  },
};
