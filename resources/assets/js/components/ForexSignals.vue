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
                            <td>{{row.m5}}</td>
                            <td>{{row.m15}}</td>
                            <td>{{row.h1}}</td>
                            <td>{{row.rating}}</td>
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
                    }
                });
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
            }
        },
        created() {
            this.fetchHistoryData();
        },
        mounted() {
            console.log('Component ready.');
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
            });
        },
        computed: {}
    }
</script>
