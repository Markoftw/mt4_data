let request = require('request');

let timer = 4; // seconds

let interval = setInterval(function () {
    let d = new Date();
    let req_url = 'https://frx.marefx.com/update';
    if(d.getHours() <= 17 && d.getHours() >= 8 && d.getDay() >= 1 && d.getDay() <= 5) {
        if(timer != 4) {
            timer = 4;
        }
        request(req_url, function (error, response, body) {
            let json = JSON.parse(body);
            console.log('Status code: ' + response.statusCode + ' Time passed: ' + json.timer + ' seconds');
        });
    } else {
        if(timer != 60) {
            timer = 60;
        }
        console.log('Market offline');
    }

}, 1000 * timer);
