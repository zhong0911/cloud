$(document).ready(function () {
    initPageEvent();
    initDomainList();
    initDomainSuffix();
});


let keyword;
let suffix;
let suffixes;

function initPageEvent() {
    keyword = $.url.param("keyword") ?? '';
    suffix = $.url.param("suffix") ?? '';
    suffixes = describeDomainSuffixes();
    if (!suffixes.includes(suffix)) {
        into(`${$.url.attr("protocol")}://${$.url.attr("host")}${$.url.attr('path')}?keyword=${keyword}&suffix=com`);
    }
    if (!keyword) into("./index.html");
    suffixes = suffixes.filter(item => item !== suffix);
    suffixes.unshift(suffix);
    $("#keyword").val(keyword);
    $("#suffix").val(suffix);
    $("#query").click(
        function () {
            let suffixes = describeDomainSuffixes();
            let keyword = $("#keyword").val();
            let suffix = $('#suffix').val();
            if (keyword) {
                let arr = keyword.split('.');
                if (suffixes.includes(arr[arr.length - 1])) {
                    into(`./query.html?keyword=${arr[0]}&suffix=${arr[arr.length - 1]}`);
                } else {
                    into(`./query.html?keyword=${keyword}&suffix=${suffix}`);
                }
            }
        }
    );
}

function initDomainList() {
    for (let index in suffixes) {
        if (index > 10) {
            return;
        }
        let suffix = suffixes[index];
        let domainName = `${keyword}.${suffix}`;
        $.post({
            url: "https://domain.api.cloud.antx.cc/api/domain/index.php",
            data: {action: 'checkdomain', domainName: domainName},
            success:
                function (data) {
                    suffixes = suffixes.filter(item => item !== suffix);
                    if (data['success']) {
                        let avail, price, premium, reason;
                        let info = data['info'];
                        avail = info['avail'];
                        price = info['price'];
                        premium = info['premium'];
                        reason = info['reason'];
                        let html = getDataTemplate(domainName, avail, price, premium, reason);
                        $("#domain-list").append(html);
                    }
                },
            dataType: 'json',
            type: "POST",
            async: true
        });
    }
}


let checkDomainResult;

function checkDomain(params) {
    params['action'] = 'checkdomain';
    $.post({
        url: "https://domain.api.cloud.antx.cc/api/domain/index.php",
        data: params,
        success:
            function (data) {
                checkDomainResult = data;
            },
        dataType: 'json',
        type: "POST",
        async: false
    });
    return checkDomainResult;
}

function getDataTemplate(domainName, avail, price, premium, reason) {
    let text;
    switch (avail) {
        case 1: {
            text = `<span class="badge bg-success">未注册</span>`;
            break;
        }
        case 0: {
            text = `  <span class="badge bg-secondary">已注册</span>`;
            break;
        }
        default: {
            break;
        }
    }
    let btn;
    switch (avail) {
        case 1: {
            btn = `<button type="button" class="btn btn-sm btn-outline-primary">加入清单</button>`;
            break;
        }
        case 3: {
            btn = `<button type="button" class="btn btn-sm btn-outline-primary">立即登记</button>`;
            break;
        }
        case 4: {
            btn = `<button type="button" class="btn btn-sm btn-outline-primary">可删除预订</button>`;
            break;
        }
        case 0: {
            btn = `<button class="mx-2 btn btn-sm btn-custom"><a class="text-decoration-none" href="https://whois.cloud.antx.cc/whois/?domainName=${domainName}">Whois</a></button><button type="button" class="btn btn-sm btn-outline-primary">立即询价</button>`;
            break;
        }
        default: {
            break;
        }
    }
    return `
        <li class="list-group-item">
           <div>
              <span  class="text-dark">${domainName}  <small>${text}</small></span>
              <span class="pull-right">${btn}</span>
           </div>
       </li>
       
    `;
}

function initDomainSuffix() {
    let prefixes = describeDomainSuffixes();
    for (let index in prefixes) {
        let suffix = prefixes[index];
        let item = `<option id="${suffix}" value="${suffix}">.${suffix}</option>`;
        $("#suffix").append(item);
    }
}