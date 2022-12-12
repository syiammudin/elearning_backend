<template>
  <div
    class="justify-content-center"
    style="padding: 10px; display: flex; flex-wrap: wrap"
  >
    <div class="col-md-9 p-5">
      <div
        class="
          mt-8
          bg-white
          overflow-hidden
          shadow
          sm:rounded-lg
          p-5
          text-center
        "
        style="height: calc(100vh - 200px)"
      >
        <h1 v-if="error.statusCode === 404">
          {{ pageNotFound }}
        </h1>
        <h1 v-else>
          {{ otherError }}
        </h1>
        <NuxtLink to="/"> Home page </NuxtLink>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "EmptyLayout",
  layout: "empty",
  props: {
    error: {
      type: Object,
      default: null,
    },
  },
  data() {
    return {
      pageNotFound: "404 Not Found",
      otherError: "An error occurred",
    };
  },
  head() {
    const title =
      this.error.statusCode === 404 ? this.pageNotFound : this.otherError;
    return {
      title,
    };
  },
};
</script>

<style scoped>
h1 {
  font-size: 20px;
}
</style>
