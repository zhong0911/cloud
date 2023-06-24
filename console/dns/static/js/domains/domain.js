
let describeDomainsResult;

function describeDomains(params) {
    params['action'] = 'describeDomains';
    $.post({
        url: "https://dns.api.cloud.antx.cc/api/domain/index.php",
        data: params,
        success:
            function (data) {
                describeDomainsResult = data;
            },
        dataType: 'json',
        type: "POST",
        async: false,
            xhrFields: {
                withCredentials: true
            },
    });
    return describeDomainsResult;
}

let addDomainResult;

function addDomain(params) {
    params['action'] = 'addDomain';
    $.post({
        url: "https://dns.api.cloud.antx.cc/api/domain/index.php",
        data: params,
        success:
            function (data) {
                addDomainResult = data;
            },
        dataType: 'json',
        type: "POST",
        async: false,
        xhrFields: {
            withCredentials: true
        },
    });
    return addDomainResult;
}

let deleteDomainResult;

function deleteDomain(params) {
    params['action'] = 'deleteDomain';
    $.post({
        url: "https://dns.api.cloud.antx.cc/api/domain/index.php",
        data: params,
        success:
            function (data) {
                deleteDomainResult = data;
            },
        dataType: 'json',
        type: "POST",
        async: false,
            xhrFields: {
                withCredentials: true
            },
    });
    return deleteDomainResult;
}

