let describeDomainRecordsResult;

function describeDomainRecords(params) {
    params['action'] = 'describeDomainRecords';
    $.post({
        url: "https://dns.api.cloud.antx.cc/api/record/index.php",
        data: params,
        success:
            function (data) {
                describeDomainRecordsResult = data;
            },
        dataType: 'json',
        type: "POST",
        async: false,
        xhrFields: {
            withCredentials: true
        },
    });
    return describeDomainRecordsResult;
}

let deleteDomainRecordsResult;

function deleteDomainRecord(params) {
    params['action'] = 'deleteDomainRecord';
    $.post({
        url: "https://dns.api.cloud.antx.cc/api/record/index.php",
        data: params,
        success:
            function (data) {
                deleteDomainRecordsResult = data;
            },
        dataType: 'json',
        type: "POST",
        async: false,
        xhrFields: {
            withCredentials: true
        },
    });
    return deleteDomainRecordsResult;
}

let addDomainRecordsResult;

function addDomainRecord(params) {
    params['action'] = 'addDomainRecord';
    $.post({
        url: "https://dns.api.cloud.antx.cc/api/record/index.php",
        data: params,
        success:
            function (data) {
                addDomainRecordsResult = data;
            },
        dataType: 'json',
        type: "POST",
        async: false,
        xhrFields: {
            withCredentials: true
        },
    });
    return addDomainRecordsResult;
}

let setRecordStatusResult;

function setDomainRecordStatus(params) {
    params['action'] = 'setDomainRecordStatus';
    $.post({
        url: "https://dns.api.cloud.antx.cc/api/record/index.php",
        data: params,
        success:
            function (data) {
                setRecordStatusResult = data;
            },
        dataType: 'json',
        type: "POST",
        async: false,
        xhrFields: {
            withCredentials: true
        },
    });
    return setRecordStatusResult;
}

let getDomainRecordInfoResult;

function describeDomainRecordInfo(params) {
    params['action'] = 'describeDomainRecordInfo';
    $.post({
        url: "https://dns.api.cloud.antx.cc/api/record/index.php",
        data: params,
        success:
            function (data) {
                getDomainRecordInfoResult = data;
            },
        dataType: 'json',
        type: "POST",
        async: false,
        xhrFields: {
            withCredentials: true
        },
    });
    return getDomainRecordInfoResult;
}

let updateDomainRecordResult;

function updateDomainRecord(params) {
    params['action'] = 'updateDomainRecord';
    $.post({
        url: "https://dns.api.cloud.antx.cc/api/record/index.php",
        data: params,
        success:
            function (data) {
                updateDomainRecordResult = data;
            },
        dataType: 'json',
        type: "POST",
        async: false,
        xhrFields: {
            withCredentials: true
        },
    });
    return updateDomainRecordResult;
}

let updateDomainRemarkResult;

function updateDomainRecordRemark(params) {
    params['action'] = 'updateDomainRecordRemark';
    $.post({
        url: "https://dns.api.cloud.antx.cc/api/record/index.php",
        data: params,
        success:
            function (data) {
                updateDomainRemarkResult = data;
            },
        dataType: 'json',
        type: "POST",
        async: false,
        xhrFields: {
            withCredentials: true
        },
    });
    return updateDomainRemarkResult;
}
