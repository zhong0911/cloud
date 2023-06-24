$(document).ready(function () {
    pageNumber = $.url.param('pageNumber') ?? '1';
    pageSize = $.url.param('pageSize') ?? $.cookie('pageSize') ?? '20';
    initRecordList(pageNumber, pageSize);
    initPageEvent();
});

let pageSize, pageNumber;
let domainNames = [];

function initRecordList(pageNumber, pageSize) {
    let data = describeDomains({'pageSize': pageSize, 'pageNumber': pageNumber})
    if (data['success']) {
        let domains = data['domains'];
        for (let index in domains) {
            let domainName = domains[index]['domainName'];
            let tags = domains[index]['tags'];
            let recordCount = domains[index]['recordCount'];
            let dns = domains[index]['dns'];
            let versionCode = domains[index]['versionCode'];
            let aliDomain = domains[index]['aliDomain'];
            domainNames.push(domainName);
            let tableData = getTableTemplate(domainName, tags, recordCount, dns, versionCode, aliDomain);
            $("#tbody").append(tableData);
        }
    } else {
        $prompt.error("解析列表获取失败，原因：" + data['message']);
    }
}

function initPageEvent() {
    $("#add-domain").click(function () {
        $('#add-domain-modal-div').load("/static/html/form/add-domain.html", function () {
            initInputEvent();
            $("#add-domain-modal").modal('show');
            $("#add-domain-btn").click(function () {
                addDomainName();
            });
        });
    });
}


function initInputEvent() {
    $("#domain-name").keyup(function () {
        checkDomain();
    })
}


function addDomainName() {
    if (checkDomain()) {
        let domainName = $("#domain-name").val();
        let data = addDomain({domainName: domainName});
        if (data['success']) {
            $prompt.success("添加成功");
            $("#add-domain-modal").modal('hide').remove();
            let tableData = getTableTemplate(domainName, '', '0', '', 'mianfei', false);
            $("#tbody").prepend(tableData);
            domainNames.push(domainName);
        } else {
            let html;
            switch (data['code']) {
                case"InvalidDomainName.Format" :
                    html = '域名格式错误';
                    break;
                case"InvalidDomainName.Duplicate" :
                    html = '域名已存在权威域名列表中，无需再次添加，请在权威域名列表中搜索并查看。';
                    break;
                case "InvalidDomainName.Suffix":
                    html = '很抱歉，云解析不支持该域名后缀解析，建议您使用常规后缀。';
                    break;
                case "DomainAddedByOthers":
                    html = '该域名在其他账号下已存在，无法添加';
                    break;
                case "InvalidDomainName.Unregistered":
                    html = `该域名未注册，<a href="https://domain.buy.cloud.antx.cc/?doamin=${domainName}">注册域名</a>。`;
                    break;
                default:
                    html = '';
            }
            if (html) $("#domain-name-error").html(`${error} ${html}`);
            else $prompt.error(`添加失败, 原因: ${data['message']}, Code: ${data['code']}`);
        }
    }
}


function checkDomain() {
    let domainName = $("#domain-name").val();
    if (domainName) {
        if (isDomainName(domainName)) {
            if (domainNames.includes(domainName)) {
                $("#domain-name-error").html(`${error} 域名已存在权威域名列表中，无需再次添加，请在权威域名列表中搜索并查看。`);
                return false;
            } else {
                $("#domain-name-error").html('');
                return true;
            }
        } else {
            $("#domain-name-error").html(`${error} 域名格式错误`);
            return false;
        }
    } else {
        $("#domain-name-error").html(`${error} 域名不可为空`);
        return false;
    }
}


function deleteDomainName(domainName) {
    $("#delete-domain-modal-div").load("/static/html/form/delete-domain.html", function () {
        $("#delete-domain-modal").modal('show');
        $("#delete-domain-btn").click(function () {
            let data = deleteDomain({domainName: domainName});
            if (data['success']) {
                $prompt.success('删除成功');
                domainNames = domainNames.filter(item => item !== domainName);
                $("#delete-domain-modal").modal('hide');
                $("#" + domainName.replace('.', '-')).remove();
            } else {
                $prompt.error('删除失败');
            }
        });
    });
}


function upgradeDomainName(domainName) {

}

function getTableTemplate(domainName, tags, recordCount, dns, versionCode, aliDomain) {
    return `
        <tr id="${domainName.replace('.', '-')}">
            <td><small><a class="text-decoration-none" href="/records/?domainName=${domainName}">${domainName}</a></small></td>
            <td><small>${targetsSvg}</small></td>
            <td><small>${recordCount}</small></td>
            <td><small>${dns}</small></td>
            <td><small>${versionCode === "mianfei" ? '免费版' : '付费版'}</small></td>
            <td>
                <a class="text-decoration-none small" href="javascript:void(0)" onclick="into('/records/?domainName=${domainName}')">解析设置</a> |
                <a class="text-decoration-none small" href="javascript:void(0)" onclick="">域名检测</a> |
                <a class="text-decoration-none small" type="button" class="link dropdown-toggle" data-bs-toggle="dropdown"><small>更多</small></a>
                <div class="dropdown-menu">
                    <a class="text-decoration-none dropdown-item link small" href="javascript:void(0)" onclick="upgradeDomainName('${domainName}')"><small>升级</small></a>
                    ${aliDomain ? '' : `<a class="text-decoration-none dropdown-item link small" href="javascript:void(0)" onclick="deleteDomainName('${domainName}')"><small>删除</small></a>`}
                </div>
            </td>
        </tr>`;
}