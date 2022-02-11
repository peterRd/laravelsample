<template>
    <div class="row border py-3">
        <div class="col-4 pl-0">
            <div class="list-group" id="list-tab" role="tablist">
                <a v-if="readings" v-for="reading in readings" href="#" @click="individualreading=reading"
                   class="list-group-item list-group-item-action" data-toggle="list" role="tab"
                    :class="setActive(reading)">
                    Reading #{{reading.id}}
                </a>
            </div>
        </div>
        <div class="col-4 description border-1">
            <div id="readings-content" v-if="individualreading.id" v-model="individualreading">
                <p>Name: Reading #{{individualreading.id}}</p>
                <p>Azimuth: {{individualreading.azimuth}}</p>
                <p>Dip: {{individualreading.dip}}</p>
                <div v-if="editing">
                    <label for="depth">Depth</label>
                    <input id="depth" name="depth" type="number" v-model="individualreading.depth"/>
                </div>
                <p v-else>Depth: {{individualreading.depth}}</p>
                <div class="mt-3">
                    <button class="btn btn-primary" v-if="!editing" @click="editing=true">Edit</button>
                    <button class="btn btn-primary" v-else @click="updateReading">Save</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    mounted() {
        this.fetchdata();
    },
    props: ['selected'],
    data() {
        return {
            readings: [],
            individualreading: {
                id: "",
                depth: 0
            },
            editing: false,
        }
    },
    watch: {
        selected: function() {
            this.fetchdata()
            this.individualreading = {
                id: "",
                depth: 0
            };
        }
    },
    methods:{
        setActive: function(reading){
            if (this.individualreading.id == reading.id) {
                return {active: true};
            } else if (reading.invalid){
                return {'bg-danger': true};
            }
        },
        fetchdata: function() {
            const vm = this;
            axios.get('/readings/' + this.selected.id).then(function(response, status, request) {
                vm.readings = [];
                response.data.forEach((item) => {
                    vm.readings.push(item)
                })
            });
        },
        updateReading: function() {
            axios.post('/reading/' + this.individualreading.id, this.individualreading).then((res) => {
                if (res.data.success) {
                    this.editing = false;
                    alert('Reading successfully updated');
                } else {
                    alert('Could not update reading.');
                }
            }).catch(() => {
                this.editing = true;
            })
        },
    }
}
</script>
