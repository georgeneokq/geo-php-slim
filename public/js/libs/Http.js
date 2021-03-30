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
    post: async function(url, data, headers={}) {
        let response = await fetch(url, {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
                'content-type': 'application/json',
                ...headers
            }
        });
        return await response.json();
    }
};

function toFormData(object, formData = null) {
    if(!formData) {
        formData = new FormData();
    }
    for (let key in object) {
        if(Array.isArray(object[key])) {
            for(let array_item of object[key]) {
                formData.append(key, array_item);
            }
        } else {
            formData.append(key, object[key]);
        }
    }
    return formData;
}