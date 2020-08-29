<template>

  <vue-editor  @text-change="update_editor_content" v-model="series.description" />
</template>

<script>
export default {
  props: ['series'],
  methods:{
            update_editor_content() {

			}
}
};
</script>