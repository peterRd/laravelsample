<template>
    <div class="container">
        <div class="row border">
            <div class="col-4 pl-0 flex-fill">
                <div class="list-group flex-fill" id="list-tab" role="tablist">
                    <a v-for="instrument in instruments" href="#" @click="updateSelected(instrument)"class="list-group-item list-group-item-action">
                        {{ instrument.name }}
                    </a>
                </div>
            </div>
            <div class="col-8">
                <div class="description border-1">
                    <div id="instrument-content" v-if="selected" v-model="selected">
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
        <readings v-if="selected" :selected="selected"></readings>
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
            selected: null,
            instruments: []
        }
    },
    methods:{
        fetchdata: function() {
            const vm = this;
            axios.get('/instruments').then(function(response, status, request) {
                response.data.forEach((item) => {
                    vm.instruments.push(item)
                })
            });
        },
        updateSelected: function(selected) {
            this.selected = selected;
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
