<template>
    <div class="container">
    <div class="row">
        <div class="col-4">
            <div class="list-group" id="list-tab" role="tablist">
                <a v-for="reading in readings" href="#" @click="updateSelected(reading)"class="list-group-item list-group-item-action active">
                    {{ reading.created_at }}
                </a>
            </div>
        </div>
        <div class="col-8">
            <div class="tab-content" id="nav-tabContent" v-model="selected">
                <div class="tab-pane">
                    <span>Depth: {{selected.depth}}</span>
                    <span>Depth: {{selected.depth}}</span>
                    <span>Depth: {{selected.depth}}</span>
                    <span>Depth: {{selected.depth}}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="list-group">
            <a v-for="reading in readings" href="#" class="list-group-item list-group-item-action active">
                {{ reading.created_at }}
            </a>
        </div>
    </div>
    </div>
</template>
<script>
export default {
    mounted() {
        this.fetchdata()
        console.log('Component mounted.')
    },
    data() {
        return {
            errors: [],
            selected: {
                name: "",
                depth: ""
            },
            readings: []
        }
    },
    methods:{
        fetchdata: function() {
            const vm = this;
            axios.get('/instruments').then(function(response, status, request) {
                // vm.$set(vm.$data.readings, response.data);
                response.data.forEach((item) => {
                //     vm.$set(vm.readings, vm.readings.length, item);
                //     // vm.$data.readings.push(item);
                    vm.readings.push(item)
                })
                // vm.$set(vm, 'readings', response.data)

            });
        },
        updateSelected: function(selected) {
            this.$data.selected = selected;
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
