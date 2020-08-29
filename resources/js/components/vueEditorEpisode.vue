<template>
  <vue-editor id="description" name="description" v-model="episode.description" />
</template>

<script>
export default {
  props: ['episode']
};
</script>