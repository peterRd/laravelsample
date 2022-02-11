<template>
    <div class="container">
        <div class="row border py-3">
            <h2>Instruments</h2>
            <div class="col-4 pl-0 flex-fill">
                <div class="list-group flex-fill" id="list-tab" role="tablist">
                    <a v-for="instrument in instruments" href="#" @click="selected=instrument"class="list-group-item list-group-item-action" :class="setActive(instrument)">
                        {{ instrument.name }}
                    </a>
                </div>
            </div>
            <div class="col-8">
                <div class="description border-1">
                    <div id="instrument-content" v-if="selected.id" v-model="selected">
                        <p>Name: {{selected.name}}</p>
                        <p>Depth: {{selected.hole_description}}</p>
                        <p>Azimuth: {{selected.azimuth}}</p>
                        <p>Dip: {{selected.dip}}</p>
                        <p>Lat: {{selected.latitude}}</p>
                        <p>Long: {{selected.longtitude}}</p>
                    </div>
                </div>
                <div v-if="selected.id" id="map">
                    <l-map style="height: 300px" :zoom="zoom" :center="[selected.latitude, selected.longtitude]">
                        <l-tile-layer :url="url" :attribution="attribution"></l-tile-layer>
                        <l-marker :lat-lng="[selected.latitude, selected.longtitude]"></l-marker>
                    </l-map>
                </div>
            </div>
        </div>
        <readings v-if="selected.id" :selected="selected"></readings>
    </div>
</template>
<script>
export default {
    mounted() {
        this.fetchdata();
    },
    data() {
        return {
            errors: [],
            selected: {
                id: ""
            },
            instruments: [],
            url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            attribution: '<a target="_blank" href="http://osm.org/copyright">OpenStreetMap</a> contributors',
            zoom: 10,
        }
    },
    methods:{
        setActive: function(reading){
            if (this.selected.id == reading.id) {
                return {active: true};
            }
        },
        fetchdata: function() {
            const vm = this;
            axios.get('/instruments').then(function(response, status, request) {
                response.data.forEach((item) => {
                    vm.instruments.push(item)
                })
            });
        }
    }
}
</script>
