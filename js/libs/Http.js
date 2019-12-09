var Http = {
    get: function(url, callback) {
        var request = new XMLHttpRequest();
        request.open('GET', url);
        request.setRequestHeader('content-type', 'application/json');
        request.onload = function() {
            callback(this);
        };
        request.send();
    },
    post: function(url, data, callback) {
        var request = new XMLHttpRequest();
        request.open('POST', url);
        request.setRequestHeader('content-type', 'application/json');
        request.onload = function() {
            callback(this);
        };
        request.send(JSON.stringify(data));
    }
};

const Http2 = {
    get: async function(url) {
        let response = await fetch(url);
        return await response.json();
    },
    post: async function(url, data) {
        let response = await fetch(url, {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
                'content-type': 'application/json'
            }
        });
        return await response.json();
    }
};
