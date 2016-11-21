<template>
    <div>
        <div>
            <b>Last MetaTrader4 update:</b> {{ last_mt4_update }}
            <br/>
            <b>Last refresh:</b> {{ last_refresh }}
            <br/>
            <b>Possible orders: </b> {{ possible_orders }}
        </div>
        <br/>
        <table class="table table-hover table-top-border">
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
            <tr v-for="row in table_data" v-bind:class="{'danger': sell_order, 'success': buy_order}">
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
                <td v-html="signal(row)"></td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    var Vue = require('vue');
    export default {
        props: [''],
        data() {
            return {
                table_data: [],
                updated_data: [],
                possible_orders: 0,
                buy_order: false,
                sell_order: false,
                last_mt4_update: 'Updating...',
                last_refresh: 'Updating...',
            }
        },
        methods: {
            fetchTableData() {
                var self = this;
                Vue.http.get('/data').then((response) => {
                    _.forEach(response.data, function(item){
                        self.table_data.push(item);
                    });
                    self.last_mt4_update = new Date(response.data[0].updated_at).toString();
                });
            },
            signal(pair) {
                if(pair.cs_signal === 'SELL' && pair.p_m5 === 'SELL' && pair.p_m15 === 'SELL' && pair.m_30 === 'SELL'
                    && pair.p_h1 === 'SELL' && pair.TD_m5 === 'SELL' && pair.TD_m15 === 'SELL' && pair.TD_h1 === 'SELL'
                    && pair.TS_LTS === 'SELL' && pair.TD_HTS === 'SELL' && pair.TD_TS === 'SELL' && pair.EVO_5 === 'SELL' && pair.EVO15 === 'SELL') {
                    this.sell_order = true;
                    return '<b>SELL</b> <img src=\'img/down.ico\' width=\'17\' height=\'20\'/>';
                } else if (pair.cs_signal === 'BUY' && pair.p_m5 === 'BUY' && pair.p_m15 === 'BUY' && pair.m_30 === 'BUY'
                        && pair.p_h1 === 'BUY' && pair.TD_m5 === 'BUY' && pair.TD_m15 === 'BUY' && pair.TD_h1 === 'BUY'
                        && pair.TS_LTS === 'BUY' && pair.TD_HTS === 'BUY' && pair.TD_TS === 'BUY' && pair.EVO_5 === 'BUY' && pair.EVO15 === 'BUY') {
                    this.buy_order = true;
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
               console.log(event);
                if(event.signals.length > 1) {
                    Vue.set(self.$data, 'table_data', event.signals);
                    Vue.set(self.$data, 'last_mt4_update', new Date(event.signals[0].updated_at).toString());
                 } else {
                    Vue.set(self.$data, 'table_data', event);
                    Vue.set(self.$data, 'last_mt4_update', new Date(event[0].updated_at).toString());
                 }
                /*if(event.signals.length > 1) {
                    _.forEach(event.signals, function(item){
                     self.table_data.push(item);
                     });
                } else {
                    self.table_data.push(event.signals);
                }*/
            });
        },
        computed: {

        }
    }
</script>
