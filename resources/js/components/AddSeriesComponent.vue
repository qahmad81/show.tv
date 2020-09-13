<template>
    <div>
        <form method="post" enctype="multipart/form-data" @submit.prevent="submitSeries">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" 
                    placeholder="Please Enter Title there" v-model="form1.title"
                    :class="{ 'is-invalid' : form1.errors.has('title') }"
                    @keydown="form1.errors.clear('title')">
                    <div class="invalid-feedback" v-show="form1.errors.has('title')"
                        v-text="form1.errors.get('title')"></div>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <vue-editor id="description" name="description" v-model="form1.description"
                    :class="{ 'is-invalid' : form1.errors.has('description') }"
                    @keydown="form1.errors.clear('description')"  >
                </vue-editor>
                    <div class="invalid-feedback" v-show="form1.errors.has('description')"
                        v-text="form1.errors.get('description')"></div>
            </div>

            <div class="form-group">
                <label for="airing_time">Airing Time</label>
                <input type="text" class="form-control" id="airing_time" name="airing_time" 
                     v-model="form1.airing_time" placeholder="Please set Airing Time her"
                    :class="{ 'is-invalid' : form1.errors.has('airing_time') }"
                    @keydown="form1.errors.clear('airing_time')">
                    <div class="invalid-feedback" v-show="form1.errors.has('airing_time')"
                        v-text="form1.errors.get('airing_time')"></div>
            </div>

            <button type="submit" class="btn btn-primary">Submit The Series</button>
        </form>
        <div v-if="this.loading" id="background-looding"></div>
    </div>
</template>

<script>
    export default {
        props: ['submiturl'],
        data() {
            return{
                loading: '',
                form1: new Form({
                    title: '',
                    description: '',
                    airing_time: '',
                })
            }
        },
        methods:{
            submitSeries() {
                let data = new FormData();
                data.append('title', this.form1.title);
                data.append('description', this.form1.description);
                data.append('airing_time', this.form1.airing_time);
                this.loading = '1';
                axios.post(this.submiturl, data)
                .then( (response) =>{
                    this.form1.reset();
                    alert('Data sent');
                    this.loading = '';
                })
                .catch(error => this.form1.errors.record(error.response.data))
            }
        }

    };
</script>
