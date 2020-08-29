<template>
    <div>
        <div v-for="series in this.serieses">
            <h4>{{series.title}}</h4>
            <ul>
                <li v-for="episode in series.episodes">{{episode.title}}</li>
            </ul>
        </div>
    </div>
</template>

<script>

    export default {
        props: ['serieses']
    }
</script>
