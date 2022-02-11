<template>
    <div class="container">
        <div class="row border py-3">
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
            instruments: []
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
