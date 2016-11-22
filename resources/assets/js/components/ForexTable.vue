<template>
    <div>
        <div>
            <h5><b>Last refresh:</b> {{ last_refresh }}</h5>
        </div>
        <div style="width: 80%">
            <table class="table table-hover table-top-border table-right-border table-bottom-border">
                <thead>
                <tr>
                    <th style="width: 8.5%;">Pair</th>
                    <th style="width: 6.5%;">CS Signal</th>
                    <th style="width: 6.5%;">Period M5</th>
                    <th style="width: 6.5%;">Period M15</th>
                    <th style="width: 6.5%;">Period M30</th>
                    <th style="width: 6.5%;">Period H1</th>
                    <th style="width: 6.5%;">TD M5</th>
                    <th style="width: 6.5%;">TD M15</th>
                    <th style="width: 6.5%;">TD H1</th>
                    <th style="width: 6.5%;">TD LTS</th>
                    <th style="width: 6.5%;">TD HTS</th>
                    <th style="width: 6.5%;">TD TS</th>
                    <th style="width: 6.5%;">EVO M5</th>
                    <th style="width: 6.5%;">EVO M15</th>
                    <th style="width: 7%;">SIGNAL</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="row in table_data" :class="{'danger': signal(row) === 'SELL', 'success': signal(row) === 'BUY'}">
                    <td>{{row.pair.pair}}</td>
                    <td>{{row.cs_signal}}</td>
                    <td>{{row.p_m5}}</td>
                    <td>{{row.p_m15}}</td>
                    <td>{{row.p_m30}}</td>
                    <td>{{row.p_h1}}</td>
                    <td>{{row.TD_m5}}</td>
                    <td>{{row.TD_m15}}</td>
                    <td>{{row.TD_h1}}</td>
                    <td>{{row.TD_LTS}}</td>
                    <td>{{row.TD_HTS}}</td>
                    <td>{{row.TD_TS}}</td>
                    <td>{{row.EVO_5}}</td>
                    <td>{{row.EVO_15}}</td>
                    <td v-html="signal_td(row)"></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div style="width: 20%">

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
                last_mt4_update: 'Updating...',
                last_refresh: 'Updating...',
            }
        },
        methods: {
            fetchTableData() {
                var self = this;
                Vue.http.get('/data').then((response) => {
                    //console.log(response);
                    _.forEach(response.data, function(item){
                        self.table_data.push(item);
                    });
                    self.last_refresh = new Date(response.data[0].updated_at).toString();
                });
            },
            signal(pair) {
                if(pair.cs_signal === 'SELL' && pair.p_m5 === 'SELL' && pair.p_m15 === 'SELL' && pair.p_m30 === 'SELL'
                    && pair.p_h1 === 'SELL' && pair.TD_m5 === 'SELL' && pair.TD_m15 === 'SELL' && pair.TD_h1 === 'SELL'
                    && pair.TD_LTS === 'SELL' && pair.TD_HTS === 'SELL' && pair.TD_TS === 'SELL' && pair.EVO_5 === 'SELL' && pair.EVO_15 === 'SELL') {
                    return 'SELL';
                } else if (pair.cs_signal === 'BUY' && pair.p_m5 === 'BUY' && pair.p_m15 === 'BUY' && pair.p_m30 === 'BUY'
                        && pair.p_h1 === 'BUY' && pair.TD_m5 === 'BUY' && pair.TD_m15 === 'BUY' && pair.TD_h1 === 'BUY'
                        && pair.TD_LTS === 'BUY' && pair.TD_HTS === 'BUY' && pair.TD_TS === 'BUY' && pair.EVO_5 === 'BUY' && pair.EVO_15 === 'BUY') {
                    return 'BUY';
                } else {
                    return 'NO';
                }
            },
            signal_td(pair) {
                if(pair.cs_signal === 'SELL' && pair.p_m5 === 'SELL' && pair.p_m15 === 'SELL' && pair.p_m30 === 'SELL'
                        && pair.p_h1 === 'SELL' && pair.TD_m5 === 'SELL' && pair.TD_m15 === 'SELL' && pair.TD_h1 === 'SELL'
                        && pair.TD_LTS === 'SELL' && pair.TD_HTS === 'SELL' && pair.TD_TS === 'SELL' && pair.EVO_5 === 'SELL' && pair.EVO_15 === 'SELL') {
                    // store history
                    var store_sell = new FormData();
                    store_sell.append('pair_name', pair.pair.pair);
                    store_sell.append('order_type', 'SELL');
                    store_sell.append('pair_id', pair.id);
                    Vue.http.post('/store/history', store_sell).then((response) => {
                        //console.log(response);
                    });
                    return '<b>SELL</b> <img src=\'img/down.ico\' width=\'17\' height=\'20\'/>';
                } else if (pair.cs_signal === 'BUY' && pair.p_m5 === 'BUY' && pair.p_m15 === 'BUY' && pair.p_m30 === 'BUY'
                        && pair.p_h1 === 'BUY' && pair.TD_m5 === 'BUY' && pair.TD_m15 === 'BUY' && pair.TD_h1 === 'BUY'
                        && pair.TD_LTS === 'BUY' && pair.TD_HTS === 'BUY' && pair.TD_TS === 'BUY' && pair.EVO_5 === 'BUY' && pair.EVO_15 === 'BUY') {
                    // store history
                    var store_buy = new FormData();
                    store_buy.append('pair_name', pair.pair.pair);
                    store_buy.append('order_type', 'BUY');
                    store_buy.append('pair_id', pair.id);
                    Vue.http.post('/store/history', store_buy).then((response) => {
                        //console.log(response);
                    });
                    return '<b>BUY</b> <img src=\'img/up.ico\' width=\'17\' height=\'20\'/>';
                } else {
                    return 'NO';
                }
            }
        },
        created() {
            this.fetchTableData();
        },
        mounted() {
            console.log('Component ready.');
            var self = this;
            Echo.channel('forextable').listen('SendForexData', (event) => {
               //console.log(event);
                if(event.signals.length > 1) {
                    Vue.set(self.$data, 'table_data', event.signals);
                    Vue.set(self.$data, 'last_refresh', new Date(event.signals[0].updated_at).toString());
                 } else {
                    Vue.set(self.$data, 'table_data', event);
                    Vue.set(self.$data, 'last_refresh', new Date(event[0].updated_at).toString());
                 }
            });
        },
        computed: {
        }
    }
</script>
