<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Example Component</div>

                    <div class="panel-body">
                        I'm an example component!
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    var Vue = require('vue');

    export default {
        props: [''],
        methods: {

        },
        data() {
            return {
                table_data: [],
                updated_data: []
            }
        },
        mounted() {
            console.log('Component ready.');

            Echo.channel('forextable').listen('SendForexData', (e) => {
               console.log(e);
            });
        }
    }
</script>
