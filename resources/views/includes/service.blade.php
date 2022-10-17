<script>
    // Riski Maulana Rahman
    apiurl = window.location.origin+'/api';
    valusername = $('#valusername').val();
    valuserid = $('#valuserid').val();
    role = $('.roleuser').val();
    function sendRequest(url, method, data) {
        var d = $.Deferred();
    
        method = method || "GET";
    
    
        $.ajax(url+'?_token=' + '{{ csrf_token() }}', 
        {
            method: method || "GET",
            data: data,
            headers: {"Accept": "application/json"},
            cache: false,
            xhrFields: { withCredentials: true }
        }).done(function(result) {
            // console.log(result);
            d.resolve(method === "GET" ? result.data : result);
    
            var type = (result.status == "success" ? "success" : "error"),
            text = result.message;
            time = (result.status == "success" ? 2000 : 5000)
    
            if(method !== "GET" && result.status == "success") {
                logSuccess(valusername, method, url, data);
            } else if(method !== "GET" && result.status == "error") {
                logError(valusername, method, url, text);
            }
            if(result.status !== "show") {

                DevExpress.ui.notify(text, type, time);
            }
        }).fail(function(xhr) {
            d.reject(xhr.responseJSON ? xhr.responseJSON.Message : xhr.statusText);
        });
    
        return d.promise();
    }

    function filter(sce) {
        $.filter('html', function(sce) {
            return function(val) {
                return sce.trustAsHtml(val);
            };
        });
    }
        
    //get list
    
    listKlien = {
        store: new DevExpress.data.CustomStore({
            key: "id",
            loadMode: "raw",
            load: function() {
                return $.post(apiurl + "/list-klien");
            }
        }),
        sort: "nama_lengkap_klien"
    }

    listPengurusanjasa = {
        store: new DevExpress.data.CustomStore({
            key: "id",
            loadMode: "raw",
            load: function() {
                return $.post(apiurl + "/list-pengurusanjasa");
            }
        }),
        sort: "nama_pengurusan"
    }

    listDokumenklien = {
        store: new DevExpress.data.CustomStore({
            key: "id",
            loadMode: "raw",
            load: function() {
                return $.post(apiurl + "/list-dokumenklien");
            }
        }),
        sort: "nama_dokumen_klien"
    }

    listTahapanproses = {
        store: new DevExpress.data.CustomStore({
            key: "id",
            loadMode: "raw",
            load: function() {
                return $.post(apiurl + "/list-tahapanproses");
            }
        }),
        sort: "nama_tahapan_proses"
    }

    listUraianbayar = {
        store: new DevExpress.data.CustomStore({
            key: "id",
            loadMode: "raw",
            load: function() {
                return $.post(apiurl + "/list-uraianbayar");
            }
        }),
        sort: "nama_tahapan_proses"
    }
    
    
    //log
    function logSuccess(valusername, method, url, data, token) {
        var d = $.Deferred();
    
        var logUrl = window.location.origin+'/api';
    
        $.ajax(logUrl+"/logsuccess", 
        {
            method: "POST",
            data: {user:valusername,url:url,action:method,values:JSON.stringify(data)},
            headers: {"Accept": "application/json","Authorization" : "Bearer "+token},
            cache: false,
        });
    
        return d.promise();
    
    }
    
    function logError(valusername, method, url, text, token) {
        var d = $.Deferred();
    
        var logUrl = window.location.origin+'/api';
    
        $.ajax(logUrl+"/logerror", 
        {
            method: "POST",
            data: {user:valusername,url:url,action:method,values:JSON.stringify(text)},
            headers: {"Accept": "application/json","Authorization" : "Bearer "+token},
            cache: false,
        });
    
        return d.promise();
    
    }
</script>