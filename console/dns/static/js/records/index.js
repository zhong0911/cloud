$(document).ready(function () {
    domainName = $.url.param('domainName') ?? '';
    pageNumber = $.url.param('pageNumber') ?? '1';
    pageSize = $.url.param('pageSize') ?? $.cookie('pageSize') ?? '20';
    initRecordList(domainName, pageNumber, pageSize);
    initPageEvent();
});


let domainName, pageSize, pageNumber;


function initRecordList(domainName, pageNumber, pageSize) {
    if (domainName === '') into("/domains");
    $("#tbody").empty();
    let data = describeDomainRecords({'domainName': domainName, 'pageSize': pageSize, 'pageNumber': pageNumber})
    if (data['success']) {
        let records = data['records'];
        if (records === null) {
            $("#tbody").append(`<tr><div class="text-center text-muted"><img src="https://image.antx.cc/svg/null-data.svg" alt=""/><br/>暂无数据</div></tr>`);
        }
        for (let index in records) {
            let type = records[index]['type'];
            let status = records[index]['status'];
            let remark = records[index]['remark'];
            let TTL = records[index]['TTL'];
            let recordId = records[index]['recordId'];
            let RR = records[index]['RR'];
            let value = records[index]['value'];
            let line = records[index]['line'];
            let tableData = getTableTemplate(recordId, RR, type, line, value, TTL, status, remark);
            $("#tbody").append(tableData);
        }
    } else {
        if (data['code'] === 'ConsoleNeedLogin') $prompt.error("请登录后再试");
        else $prompt.error("解析列表获取失败，原因：" + data['message']);
    }
}

function initPageEvent() {
    $('.check-all').click(function () {
        $('.check-item').prop('checked', this.checked);
        $('.check-all').prop('checked', this.checked);
    });
    $("#bulk-operation").change(function () {
        let value = $("#bulk-operation").val();
        if (value) {
            $('#bulk-operate').prop('disable', false);
        } else {
            $('#bulk-operate').prop('disable', true);
        }
    });
    $("#left")
    $("#add-record").click(function () {
        addRecord();
    });

    $("#pageSize").val('page-' + pageSize).change(function () {
        pageSize = $(this).val().replace("page-", '');
        $.cookie('pageSize', pageSize, {expires: 30, path: "/"});
        $("#tbody").hide().empty();
        initRecordList(domainName, pageSize, pageNumber);
        $("#tbody").show();
    });

    $('.domainNameText').text(domainName);

    $("#next-page").click(function () {
        initRecordList(domainName, pageSize, pageNumber + 1);
        pageNumber++;
        if (pageNumber !== 1) $("#previous-page").removeClass('disabled');
    })
    $("#previous-page").click(function () {
        initRecordList(domainName, pageSize, pageNumber - 1);
        pageNumber--;
        if (pageNumber === 1) $("#previous-page").addClass('disabled');
    })
}


function deleteRecord(recordId) {
    recordId = recordId.replace('recordId-', '');
    $("#delete-record-modal-div").load('/static/html/form/delete-record.html', function () {
        $("#delete-record-modal").modal("show");
        $("#delete-record-btn").click(function () {
            let response = deleteDomainRecord({'recordId': recordId});
            if (response['success']) {
                $prompt.success("删除成功");
                $("#recordId-" + recordId).remove();
                $("#delete-record-modal").modal("hide");
            } else {
                if (data['code'] === 'ConsoleNeedLogin') $prompt.error("请登录后再试");
                else $prompt.error(`删除失败，原因：${response['message']}`);
            }
        });
    });
}


function updateRemark(recordId) {
    recordId = recordId.replace('recordId-', '');
    $("#update-remark-modal-div").load('/static/html/form/update-remark.html', function () {
        $("#update-remark-modal").modal("show");
        let remark = $(`#remark-${recordId}`).text();
        $("#remark").keyup(function () {
            checkRemark();
        }).val(remark);
        $("#update-remark-btn").click(function () {
            if (checkRemark()) {
                let remark = $("#remark").val();
                let data = updateDomainRecordRemark({recordId: recordId, remark: remark});
                if (data['success']) {
                    $prompt.success("操作成功");
                    $(`#remark-${recordId}`).text(remark);
                    $("#update-remark-modal").modal("hide");
                } else {
                    if (data['code'] === 'ConsoleNeedLogin') $prompt.error("请登录后再试");
                    else $prompt.error(`操作失败, 原因: ${data['message']}`);
                }
            }
        });
    });
}

function checkRemark() {
    let remark = $("#remark").val();
    let length = remark.trim().length;
    if (length <= 50) {
        $("#remark-error").html(``);
        return true;
    } else {
        $("#remark-error").html(`${error} 备注字数50字以内`);
        return false;
    }
}


function addRecord() {
    $("#add-record-offcanvas-div").load('/static/html/form/add-record.html', function () {
        initInputEvent();
        $("#mx-priority").hide();
        $('#add-record-offcanvas').offcanvas('show').on('hidden.bs.offcanvas', function () {
            $(this).remove();
        });
        ;
        $('.domainName').text('.' + domainName);
        $("#add-record-btn").click(function () {
            if (checkRR() && checkValue()) {
                let RR = $("#RR").val();
                RR = (RR) ? RR : '@';
                let type = $("#type").val();
                let value = $("#value").val();
                let line = $("#line").val();
                let TTL = $("#TTL").val();
                let priority = $("#priority").val();
                let data = addDomainRecord({
                    domainName: domainName,
                    RR: RR,
                    type: type,
                    value: value,
                    priority: priority,
                    line: line,
                    TTl: TTL
                })
                if (data['success']) {
                    let recordId = data['info']['recordId'];
                    let tableData = getTableTemplate(recordId, RR, type, line, value, TTL, "ENABLE", '');
                    $("#tbody").prepend(tableData);
                    $prompt.success("添加成功");
                    $('#add-record-offcanvas').offcanvas('hide');
                } else {
                    if (data['code'] === 'ConsoleNeedLogin') $prompt.error("请登录后再试");
                    else if (data['code'] === 'DomainRecordDuplicate') $prompt.error(`解析记录已存在`);
                    else $prompt.error(`添加失败，原因：${data['message']}`)
                }
            }
        });
    });
}


function updateRecord(recordId) {
    recordId = recordId.replace('recordId-', '');
    $("#update-record-offcanvas-div").load('/static/html/form/update-record.html', function () {
        initInputEvent();
        $("#mx-priority").hide();
        $("#update-record-offcanvas").offcanvas("show").on('hidden.bs.offcanvas', function () {
            $(this).remove();
        });
        $('.domainName').text('.' + domainName);
        let data = describeDomainRecordInfo({recordId: recordId});
        if (data['success']) {
            let info = data['info'];
            let RR = info['RR'];
            let type = info['type'];
            let value = info['value'];
            let line = info['line'];
            let TTL = info['TTL'];
            let priority = info['priority'] ?? '10';
            $('#RR').val(RR);
            $('#type').val(type);
            $('#value').val(value);
            $('#line').val(line);
            $('#TTL').val(TTL);
            $('#priority').val(priority);
        } else {
            if (data['code'] === 'ConsoleNeedLogin') $prompt.error("请登录后再试");
            else $prompt.error('获取解析记录信息失败');
            return;
        }
        $("#update-record-btn").click(function () {
            if (checkRR() && checkValue()) {
                let RR = $("#RR").val();
                RR = (RR) ? RR : '@';
                let type = $("#type").val();
                let value = $("#value").val();
                let line = $("#line").val();
                let TTL = $("#TTL").val();
                let priority = $("#priority").val();
                let data = updateDomainRecord({
                    recordId: recordId,
                    RR: RR,
                    type: type,
                    value: value,
                    priority: priority,
                    line: line,
                    TTl: TTL
                })
                if (data['success']) {
                    initRecordList(domainName, pageNumber, pageSize);
                    $("#update-record-offcanvas").offcanvas("hide");
                    $prompt.success("修改成功");
                } else {
                    if (data['code'] === 'ConsoleNeedLogin') $prompt.error("请登录后再试");
                    else if (data['code'] === 'DomainRecordDuplicate')  $prompt.error(`解析记录已存在`);
                    else $prompt.error(`修改失败，原因：${data['message']}`)
                }
            }
        });
    });
}

function displayRecord(recordId) {
    recordId = recordId.replace('recordId-', '');
    $("#display-remark-modal-div").load('/static/html/form/display-record.html', function () {
        let data = describeDomainRecordInfo({recordId: recordId});
        if (data['success']) {
            let info = data['info'];
            let RR = info['RR'];
            let type = info['type'];
            let value = info['value'];
            let line = info['line'];
            let TTL = info['TTL'];
            let priority = info['priority'] ?? '10';
            $('.domainName').text('.' + domainName);
            $('#RR').val(RR);
            $('#type').val(type);
            $('#value').val(value);
            $('#line').val(line);
            $('#TTL').val(TTL);
            $('#priority').val(priority);
            $("#display-record-modal").modal('show').on('hidden.bs.modal', function () {
                $(this).remove();
            });
        } else {
            if (data['code'] === 'ConsoleNeedLogin') $prompt.error("请登录后再试");
            else $prompt.error('操作失败');
        }
    });
}

function stopRecord(recordId) {
    recordId = recordId.replace('recordId-', '');
    let data = setDomainRecordStatus({recordId: recordId, status: "DISABLE"});
    if (data['success']) {
        $prompt.success("操作成功");
        $(`#status-text-${recordId}`).text(`暂停`).removeClass("text-success").addClass("text-warning");
        $(`#change-status-${recordId}`).html(`<a href="javascript:void(0)" class="text-decoration-none" onclick="startRecord('recordId-${recordId}')"><small>启用</small></a>`)
    } else {
        if (data['code'] === 'ConsoleNeedLogin') $prompt.error("请登录后再试");
        else $prompt.error("操作失败");
    }
}

function startRecord(recordId) {
    recordId = recordId.replace('recordId-', '');
    let data = setDomainRecordStatus({recordId: recordId, status: "ENABLE"});
    if (data['success']) {
        $prompt.success("操作成功");
        $(`#status-text-${recordId}`).text(`正常`).removeClass("text-warning").addClass("text-success");
        $(`#change-status-${recordId}`).html(`<a href="javascript:void(0)" class="text-decoration-none" onclick="stopRecord('recordId-${recordId}')"><small>暂停</small></a>`)
    } else {
        if (data['code'] === 'ConsoleNeedLogin') $prompt.error("请登录后再试");
        else $prompt.error("操作失败");
    }
}


function initInputEvent() {
    $("#RR").keyup(function () {
        checkRR();
    });
    $("#value").keyup(function () {
        checkValue();
    });
    $("#priority").keyup(function () {
        checkMXPriority();
    });
    $("#type").change(function () {
        let value = $("#value").val();
        if ($("#type").val() === "MX") {
            $("#mx-priority").show();
            if (value)
                checkValue();
            else {
                $("#value-error").html(``);
            }
        } else {
            $("#mx-priority").hide();
            if (value)
                checkValue();
            else {
                $("#value-error").html(`${error} 主机记录值不可为空`);
            }
        }
    })
}

function checkRR() {
    let RR = $("#RR").val();
    if (RR) {
        if (isDomainRecord(RR)) {
            $("#RR-error").html('');
            return true;
        } else {
            $("#RR-error").html(`${error} 主机记录（RR）值不能以\\“."、\\“-"开头或结尾 主机记录（RR）值不能有连续的"."。 .分割的每个字符串长度不能超过63字符`);
            return false;
        }
    } else {
        return true;
    }
}

function checkValue() {
    let type = $("#type").val();
    let value = $("#value").val();
    switch (type) {
        case"A": {
            if (isARecordValue(value)) {
                $("#value-error").html('');
                return true;
            } else {
                $("#value-error").html(`${error} A记录的记录值为IPv4形式（如10.10.10.10）`);
                return false;
            }
        }
        case"CHAME": {
            if (isCHAMERecordValue(value)) {
                $("#value-error").html('');
                return true;
            } else {
                $("#value-error").html(`${error} CNAME记录的记录值为域名形式（如abc.example.com）`);
                return false;
            }
        }
        case"AAAA": {
            if (isAAAARecordValue(value)) {
                $("#value-error").html('');
                return true;
            } else {
                $("#value-error").html(`${error} AAAA记录的记录值为IPv6形式（如ff03:0:0:0:0:0:0:c1）`);
                return false;
            }
        }
        case"NS": {
            if (isNSRecordValue(value)) {
                $("#value-error").html('');
                return true;
            } else {
                $("#value-error").html(`${error} NS记录的记录值为域名形式（如ns1.example.com）`);
                return false;
            }
        }
        case"MX": {
            if (isMXRecordValue(value)) {
                $("#value-error").html('');
                return true;
            } else {
                $("#value-error").html(`${error} MX记录的记录值为域名形式（如abc.example.com）`);
                return false;
            }
        }
        case"SRV": {
            if (isSRVRecordValue(value)) {
                $("#value-error").html('');
                return true;
            } else {
                $("#value-error").html(`${error} SRV记录格式为： 优先级 权重 端口 目标地址 ，每项中间需以空格分隔。例如 “0 5 5060 sipserver.example.com”。`);
                return false;
            }
        }
        case"TXT": {
            if (isTXTRecordValue(value)) {
                $("#value-error").html('');
                return true;
            } else {
                $("#value-error").html(`${error} TXT记录格式错误`);
                return false;
            }
        }
        case"CAA": {
            if (isCAARecordValue(value)) {
                $("#value-error").html('');
                return true;
            } else {
                $("#value-error").html(`${error} CAA记录的记录值为字符串形式（只能包含字母、数字、*?-_~=:;.@+^/!”）, 如：0 issue "ca.example.com"`);
                return false;
            }
        }
        default: {
            refresh();
        }
    }
}

function checkMXPriority() {
    let priority = $("#priority").val();
    if (priority !== "") {
        if (1 <= priority && priority <= 50) {
            $("#priority-error").html(``);
        } else {
            $("#priority-error").html(`${error} MX优先级在1~50之间`);
        }
    } else {
        $("#priority-error").html(`${error} MX优先级不可为空`);
    }
}


function getTableTemplate(recordId, RR, type, line, value, TTL, status, remark) {
    let len = value.length;
    if (len > 64) {
        value = value.substring(0, 30) + `<a href='javascript:void(0)' class='text-decoration-none' onclick="displayRecord('recordId-${recordId}')"> ..... </a>"` + value.substring(len - 30, len);
    }
    let line_CN
    switch (line) {
        case"default":
            line_CN = '默认';
            break;
        case"unicom":
            line_CN = '中国联通';
            break;
        case"telecom":
            line_CN = '中国电信';
            break;
        case"mobile":
            line_CN = '中国移动';
            break;
        case"edu":
            line_CN = '中国教育网';
            break;
        case"oversea":
            line_CN = '海外';
            break;
        case"baidu":
            line_CN = '百度';
            break;
        case"biying":
            line_CN = '必应';
            break;
        case"google":
            line_CN = '谷歌';
            break;
        case"youdao":
            line_CN = '有道';
            break;
        case"yahoo":
            line_CN = '雅虎';
            break;
        case"aliyun":
            line_CN = '阿里云';
            break;
        case"search":
            line_CN = '搜索引擎';
            break;
        default:
            line_CN = line;
            break;
    }
    return `
        <tr id="recordId-${recordId}">
        <td><input type="checkbox" class="check-item"></td>
        <td><small>${RR}</small></td>
        <td><small>${type}</small></td>
        <td><small>${line_CN}</small></td>
        <td><small id="value-${recordId}">${value}</small></td>
        <td><small>${TTL / 60} 分钟</small></td>
        <td><small id="status-text-${recordId}" class="${status === 'ENABLE' ? 'text-success' : 'text-warning'}">${status === 'ENABLE' ? `正常` : `暂停`}</small></td>
        <td><small id="remark-${recordId}">${remark ?? ''}</small></td>
        <td>
            <a href="javascript:void(0)" class="text-decoration-none" onclick="updateRecord('recordId-${recordId}')"><small>修改</small></a> |
            <span id="change-status-${recordId}">${status === 'ENABLE' ? `<a href="javascript:void(0)" class="text-decoration-none" onclick="stopRecord('recordId-${recordId}')"><small>暂停</small></a>` : `<a href="javascript:void(0)" class="text-decoration-none" onclick="startRecord('recordId-${recordId}')"><small>启用</small></a>`}</span> |
            <a href="javascript:void(0)" class="text-decoration-none deleteRecordBtn"
               onclick="deleteRecord('recordId-${recordId}')"><small>删除</small></a> |
            <a href="javascript:void(0)" class="text-decoration-none" onclick="updateRemark('recordId-${recordId}')"><small>备注</small></a> |
            <a href="https://ping.aliyun.com/detect/dns?spm=a2c1d.8251892.domain-setting.ddetect.66415b76vWQa9J&target=${RR}.antx.cc&type=${type}"
               class="text-decoration-none" target="_blank"><small>生效检测</small></a>
        </td>
        </tr>`;
}