<template>
    <div class="container">
        <a class="btn btn-sm btn-primary pull-right" href="/history" role="button" style="margin-top: 4px">View history »</a>
        <h5 v-if="countdown > 0" class="pull-right">Force page reload in {{ countdown }}s - {{ update_reason }} &nbsp;</h5>
        <h5 class="pull-left"><b>Last refresh:</b> {{ last_refresh }}</h5>
        <div class="row">
            <div class="col-lg-10">
                <div class="table-responsive">
                    <table class="table table-hover table-top-border table-right-border table-bottom-border table-left-border">
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
                        <tr v-for="row in table_data"
                            :class="{'danger': signal(row) === 'SELL', 'success': signal(row) === 'BUY'}">
                            <td data-original-title="Pair" data-container="body" data-toggle="tooltip"
                                data-placement="right">{{row.pair.pair}}
                            </td>
                            <td data-original-title="CS Signal" data-container="body" data-toggle="tooltip"
                                data-placement="right">{{row.cs_signal}}
                            </td>
                            <td data-original-title="Period M5" data-container="body" data-toggle="tooltip"
                                data-placement="right">{{row.p_m5}}
                            </td>
                            <td data-original-title="Period M15" data-container="body" data-toggle="tooltip"
                                data-placement="right">{{row.p_m15}}
                            </td>
                            <td data-original-title="Period M30" data-container="body" data-toggle="tooltip"
                                data-placement="right">{{row.p_m30}}
                            </td>
                            <td data-original-title="Period H1" data-container="body" data-toggle="tooltip"
                                data-placement="right">{{row.p_h1}}
                            </td>
                            <td data-original-title="TD M5" data-container="body" data-toggle="tooltip"
                                data-placement="right">{{row.TD_m5}}
                            </td>
                            <td data-original-title="TD M15" data-container="body" data-toggle="tooltip"
                                data-placement="right">{{row.TD_m15}}
                            </td>
                            <td data-original-title="TD H1" data-container="body" data-toggle="tooltip"
                                data-placement="right">{{row.TD_h1}}
                            </td>
                            <td data-original-title="TD LTS" data-container="body" data-toggle="tooltip"
                                data-placement="right">{{row.TD_LTS}}
                            </td>
                            <td data-original-title="TD HTS" data-container="body" data-toggle="tooltip"
                                data-placement="right">{{row.TD_HTS}}
                            </td>
                            <td data-original-title="TD TS" data-container="body" data-toggle="tooltip"
                                data-placement="right">{{row.TD_TS}}
                            </td>
                            <td data-original-title="EVO M5" data-container="body" data-toggle="tooltip"
                                data-placement="right">{{row.EVO_5}}
                            </td>
                            <td data-original-title="EVO M15" data-container="body" data-toggle="tooltip"
                                data-placement="right">{{row.EVO_15}}
                            </td>
                            <td v-html="signal_td(row)" data-original-title="Signal" data-container="body"
                                data-toggle="tooltip" data-placement="right"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-2">
                <table class="table table-hover table-top-border table-right-border table-bottom-border table-left-border">
                    <thead>
                    <tr>
                        <th>Settings</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <div class="form-group">
                                <label for="diff_setting">Difference</label>
                                <input type="text" class="form-control" id="diff_setting" placeholder="1.5"
                                       name="diff_setting" v-model="diff_data">
                            </div>
                            <button type="submit" class="btn btn-primary pull-right" @click="sendDiff()"
                                    :disabled="btn_disabled">Submit
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table class="table table-hover table-top-border table-right-border table-bottom-border table-left-border">
                    <thead>
                    <tr>
                        <th>History</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-if="history_data.length > 0" v-for="row in history_data"
                        :class="{'danger': row.order_type === 'SELL', 'success': row.order_type === 'BUY'}">
                        <td>
                            {{ row.order_type }} - {{ row.pair.pair }} @ {{ row.bid_price }}<br/>
                        </td>
                    </tr>
                    <tr v-if="history_data.length === 0">
                        <td>
                            NONE - NONE @ NONE
                        </td>
                    </tr>
                    </tbody>
                </table>
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
                history_data: [],
                last_refresh: 'Loading...',
                diff_data: 1.5,
                btn_disabled: false,
                countdown: 0,
                update_reason: 'unknown',
            }
        },
        methods: {
            fetchTableData() {
                var self = this;
                Vue.http.get('/data/signals').then((response) => {
                    //console.log(response);
                    _.forEach(response.data, function (item) {
                        self.table_data.push(item);
                    });
                    self.last_refresh = new Date(response.data[0].updated_at).toString();
                    self.diff_data = response.data[0].razlika;
                    Vue.nextTick(() => {
                        $('[data-toggle="tooltip"]').tooltip()
                    });
                });
            },
            fetchHistoryData() {
                var self = this;
                Vue.http.get('/data/history').then((response) => {
                    //console.log(response);
                    if(response.data.length > 0) {
                        _.forEach(response.data, function (item) {
                            self.history_data.push(item);
                        });
                    }
                });
            },
            signal(pair) {
                if (pair.cs_signal === 'SELL' && pair.p_m5 === 'SELL' && pair.p_m15 === 'SELL' && pair.p_m30 === 'SELL'
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
                var one_hr = 60 * 60 * 1000;
                var date_now = Date.now();
                var self = this;
                if (pair.cs_signal === 'SELL' && pair.p_m5 === 'SELL' && pair.p_m15 === 'SELL' && pair.p_m30 === 'SELL'
                        && pair.p_h1 === 'SELL' && pair.TD_m5 === 'SELL' && pair.TD_m15 === 'SELL' && pair.TD_h1 === 'SELL'
                        && pair.TD_LTS === 'SELL' && pair.TD_HTS === 'SELL' && pair.TD_TS === 'SELL' && pair.EVO_5 === 'SELL' && pair.EVO_15 === 'SELL') {
                    // store history
                    return '<b>SELL</b> <img src=\'img/down.ico\' width=\'17\' height=\'20\'/>';
                } else if (pair.cs_signal === 'BUY' && pair.p_m5 === 'BUY' && pair.p_m15 === 'BUY' && pair.p_m30 === 'BUY'
                        && pair.p_h1 === 'BUY' && pair.TD_m5 === 'BUY' && pair.TD_m15 === 'BUY' && pair.TD_h1 === 'BUY'
                        && pair.TD_LTS === 'BUY' && pair.TD_HTS === 'BUY' && pair.TD_TS === 'BUY' && pair.EVO_5 === 'BUY' && pair.EVO_15 === 'BUY') {
                    // store history
                    return '<b>BUY</b> <img src=\'img/up.ico\' width=\'17\' height=\'20\'/>';
                } else {
                    return 'NO';
                }
            },
            sendDiff() {
                var self = this;
                this.btn_disabled = true;
                var diff_setting = new FormData();
                diff_setting.append('data_type', 'razlika');
                diff_setting.append('data_value', this.diff_data);
                Vue.http.post('/store/setting', diff_setting).then((response) => {
                    //console.log(response);
                    self.btn_disabled = false;
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
            this.fetchTableData();
            this.fetchHistoryData();
        },
        mounted() {
            console.log('Component ready.');
            var self = this;
            Echo.channel('forextable').listen('SendForexData', (event) => {
                //console.log(event);
                if (event.signals.length > 1) {
                    Vue.set(self.$data, 'table_data', event.signals);
                    Vue.set(self.$data, 'last_refresh', new Date(event.signals[0].updated_at).toString());
                } else {
                    Vue.set(self.$data, 'table_data', event);
                    Vue.set(self.$data, 'last_refresh', new Date(event[0].updated_at).toString());
                }
            });
            Echo.channel('forexsetting').listen('SendSettingData', (event) => {
                //console.log(event);
                Vue.set(self.$data, 'diff_data', event.setting.razlika);
            });
            Echo.channel('forexhistory').listen('SendHistoryData', (event) => {
                //console.log(event);
                if (event.history.length > 1) {
                    Vue.set(self.$data, 'history_data', event.history);
                } else {
                    Vue.set(self.$data, 'history_data', event);
                }
            });
            Echo.channel('force-refresh').listen('ForceRefreshPage', (event) => {
                if(event.refresh.force === true) {
                    Vue.set(self.$data, 'countdown', 30);
                    Vue.set(self.$data, 'update_reason', event.refresh.reason);
                    self.refresh_cd();
                }
            });
        },
        computed: {}
    }
</script>
