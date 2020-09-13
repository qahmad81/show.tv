<template>
    <div>
        <form method="post" id="f1" enctype="multipart/form-data" @submit.prevent="submitEpisode">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" 
                    placeholder="Please Enter Title there" v-model="form1.title"
                    :class="{ 'is-invalid' : form1.errors.has('title') }"
                    @keydown="form1.errors.clear('title')">
                    <div class="invalid-feedback" v-show="form1.errors.has('title')"
                        v-text="form1.errors.get('title')"></div>
            </div>

            <div class="form-group mt-4">
                <label for="series_id">Select Series</label>
                <select class="form-control" id="series_id" name="series_id" v-model="form1.series_id"
                    :class="{ 'is-invalid' : form1.errors.has('series_id') }"
                    @keydown="form1.errors.clear('title')">
                    <option value=""></option>
                    <option v-for="series in this.serieses" :value="series.id">{{series.title}}</option>
                </select>
                    <div class="invalid-feedback" v-show="form1.errors.has('series_id')"
                        v-text="form1.errors.get('series_id')"></div>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <vue-editor id="description" name="description" v-model="form1.description"
                    :class="{ 'is-invalid' : form1.errors.has('description') }"
                    @keydown="form1.errors.clear('description')">
                </vue-editor>
                    <div class="invalid-feedback" v-show="form1.errors.has('description')"
                        v-text="form1.errors.get('description')"></div>
            </div>

            <div class="form-group">
                <label for="duration">Duration</label>
                <input type="text" class="form-control" id="duration" name="duration" 
                    v-model="form1.duration" placeholder="Please set Duration her as Number"
                    :class="{ 'is-invalid' : form1.errors.has('duration') }"
                    @keydown="form1.errors.clear('duration')">
                    <div class="invalid-feedback" v-show="form1.errors.has('duration')"
                        v-text="form1.errors.get('duration')"></div>
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

            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class="form-control-file" id="image"
                    :class="{ 'is-invalid' : form1.errors.has('image') }">
                    <div class="invalid-feedback" v-show="form1.errors.has('image')"
                        v-text="form1.errors.get('image')"></div>
            </div>

            <div class="form-group">
                <label for="video">Video</label>
                <input type="file" class="form-control-file" id="video"
                    :class="{ 'is-invalid' : form1.errors.has('video') }">
                    <div class="invalid-feedback" v-show="form1.errors.has('video')"
                        v-text="form1.errors.get('video')"></div>
            </div>

            <button type="submit" class="btn btn-primary">Submit The Series</button>

        </form>
    </div>
</template>


<script>
    export default {
        props: ['serieses', 'submiturl'],
        data() {
            return{
                form1: new Form({
                    title: '',
                    description: '',
                    duration: '',
                    airing_time: '',
                    series_id: '',
                    video: '',
                })
            }
        },
        methods:{
            submitEpisode() {
                let data = new FormData();
                data.append('title', this.form1.title);
                data.append('description', this.form1.description);
                data.append('duration', this.form1.duration);
                data.append('airing_time', this.form1.airing_time);
                data.append('series_id', this.form1.series_id);
                data.append('video', this.form1.video);
                if (document.getElementById('image').files[0])
                    data.append('image', document.getElementById('image').files[0]);
                if (document.getElementById('video').files[0])
                    data.append('video', document.getElementById('video').files[0]);
                axios.post(this.submiturl, data)
                .then( (response) =>{
                    this.form1.reset();
                    document.getElementById('f1').reset();
                    alert('Data sent');
                })
                .catch(error => this.form1.errors.record(error.response.data))
            }
        }

    };
</script>