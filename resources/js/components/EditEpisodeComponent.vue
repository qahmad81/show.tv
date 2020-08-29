<template>
<div class="box box-info padding-1">
    <div class="box-body">

        <div class="form-group">
        	 <div>{{episode.title}}</div>
             <vue-editor id="description" name="description" v-model="episode.title" ></vue-editor>
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
</template>
<script>
export default {
  props: ['serieses', 'episode', 'submiturl'],
  data: () => ({
    content: ""
  })
};
</script>