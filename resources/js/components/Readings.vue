<template>
    <div class="row border">
        <div class="col-4 pl-0 flex-fill">
            <div class="list-group" id="list-tab" role="tablist">
                <a v-if="readings" v-for="reading in readings" href="#" @click="updateSelected(reading)"class="list-group-item list-group-item-action">
                    Reading #{{reading.id}}
                </a>
            </div>
        </div>
        <div class="col-4 description border-1">
            <div id="readings-content" v-if="individualreading" v-model="individualreading">
                <p>Name: Reading #{{individualreading.id}}</p>
                <p>Azimuth: {{individualreading.azimuth}}</p>
                <p>Dip: {{individualreading.dip}}</p>
                <p>Depth: {{individualreading.depth}}</p>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    mounted() {
        this.fetchdata();
    },
    updated() {
        this.fetchdata();
    },
    props: ['selected'],
    data() {
        return {
            errors: [],
            readings: [],
            individualreading: null,
        }
    },
    methods:{
        fetchdata: function() {
            const vm = this;
            axios.get('/readings/' + this.selected.id).then(function(response, status, request) {
                vm.readings = [];
                response.data.forEach((item) => {
                    vm.readings.push(item)
                })
            });
        },
        updateSelected: function(selected) {
            this.individualreading = selected;
        },
        checkForm: function (e) {
            this.errors = [];
            if (!this.email) {
                this.errors.push('Email required.');
            }

            if (!this.password) {
                this.errors.push('Password required.');
            }

            if (!this.errors.length){
                axios.post('/login', {'email': this.$data.email, 'password': this.$data.password}).then(function(response, status, request) {
                    window.location.href = "/home";
                }, function() {
                    console.log('failed');
                });
            }

            e.preventDefault();
        }
    }
}
</script>
