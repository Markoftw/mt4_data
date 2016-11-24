<template>
    <div class="container">
        <a class="btn btn-sm btn-primary pull-right" href="/" role="button" style="margin-top: 4px;">« Back</a>
        <h5 v-if="countdown > 0" class="pull-right">Force page reload in {{ countdown }}s - {{ update_reason }} &nbsp;</h5>
        <h5><b>Last update:</b> {{ last_update }}</h5>
        <h5><b>Profit:</b> {{ pip_profit }} PIPS</h5>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-top-border table-right-border table-bottom-border table-left-border">
                        <thead>
                        <tr>
                            <th>Pair</th>
                            <th>Date added</th>
                            <th>Order</th>
                            <th>Bid price</th>
                            <th>Order placed</th>
                            <th>M5</th>
                            <th>M15</th>
                            <th>H1</th>
                            <th>Rating</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="row in table_data">
                            <td>{{row.pair.pair}}</td>
                            <td>{{row.created_at}}</td>
                            <td>{{row.order_type}}</td>
                            <td>{{row.bid_price}}</td>
                            <td>{{row.order_placed}}</td>
                            <td v-if="row.m5 === 'ratem5'"><button class="btn btn-xs btn-success" @click="updateRating(row, 'Yes', 'm5')">Yes</button>&nbsp;<button class="btn btn-xs btn-danger" @click="updateRating(row, 'No', 'm5')">No</button></td>
                            <td v-else>{{ row.m5 }}</td>
                            <td v-if="row.m15 === 'ratem15'"><button class="btn btn-xs btn-success" @click="updateRating(row, 'Yes', 'm15')">Yes</button>&nbsp;<button class="btn btn-xs btn-danger" @click="updateRating(row, 'No', 'm15')">No</button></td>
                            <td v-else>{{ row.m15 }}</td>
                            <td v-if="row.h1 === 'rateh1'"><button class="btn btn-xs btn-success" @click="updateRating(row, 'Yes', 'h1')">Yes</button>&nbsp;<button class="btn btn-xs btn-danger" @click="updateRating(row, 'No', 'h1')">No</button></td>
                            <td v-else>{{ row.h1 }}</td>
                            <td v-if="row.rating === 'rate'"><button class="btn btn-xs btn-success" @click="updateRating(row, 'Correct', 'rating')">Correct</button>&nbsp;<button class="btn btn-xs btn-danger" @click="updateRating(row, 'Incorrect', 'rating')">Incorrect</button></td>
                            <td v-else>{{ row.rating }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    var Vue = require('vue');
    export default {
        //props: [''],
        data() {
            return {
                table_data: [],
                pip_profit: 0,
                last_update: 'Loading...',
                countdown: 0,
                update_reason: 'unknown'
            }
        },
        methods: {
            fetchHistoryData() {
                var self = this;
                Vue.http.get('/data/history/signals').then((response) => {
                    if(response.data.length > 0) {
                        _.forEach(response.data, function (item) {
                            self.table_data.push(item);
                        });
                        self.last_update = new Date(response.data[0].created_at).toString();
                        self.updateProfit();
                    }
                });
            },
            updateProfit(){
                var leng = this.table_data.length;
                var self = this;
                for(var i = 0; i < leng; i++) {
                    if(self.table_data[i].rating === 'Correct'){
                        self.pip_profit += 10;
                    } else if(self.table_data[i].rating === 'Incorrect'){
                        self.pip_profit -= 20;
                    }
                }
            },
            refresh_cd() {
                var self = this;
                var cd_timer = setInterval(function() {
                    if(self.countdown == 0) {
                        location.reload();
                        return clearInterval(cd_timer);
                    }
                    self.countdown -= 1
                }, 1000)
            },
            updateRating(row, value, period) {
                //console.log(row, param, period);
                var self = this;
                var form_data = new FormData();
                form_data.append('history_id', row.id);
                form_data.append('history_value', value);
                form_data.append('history_period', period);
                Vue.http.post('/store/history/signals', form_data).then((response) => {
                    //console.log(response);
                });
            },
        },
        created() {
            this.fetchHistoryData();
        },
        mounted() {
            console.log('History component ready.');
            var self = this;
            Echo.channel('force-refresh').listen('ForceRefreshPage', (event) => {
                if(event.refresh.force === true) {
                Vue.set(self.$data, 'countdown', 30);
                Vue.set(self.$data, 'update_reason', event.refresh.reason);
                self.refresh_cd();
                }
            });
            Echo.channel('historysignals').listen('SendHistorySignalsData', (event) => {
                Vue.set(self.$data, 'table_data', event.history);
                Vue.set(self.$data, 'last_update', new Date(event.history[0].created_at).toString());
                self.updateProfit();
            });
        },
        computed: {

        }
    }
</script>
