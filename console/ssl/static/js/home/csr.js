function initCSRTable() {
    $.ajax({
        url: 'https://ssl.api.cloud.antx.cc/api/csr/',
        type: 'POST',
        data: {action: 'describeCSRRecords'},
        dataType: 'json',
        async: true,
        xhrFields: {
            withCredentials: true
        },
        success: function (data) {
            $("#csr-tbody").empty();
            if (data['success']) {
                let records = data['records'];
                for (let i in records) {
                    let csrId = records[i]['id'];
                    let csrName = records[i]['name'];
                    let domainName = records[i]['common_name'];
                    let privateKeyType = records[i]['private_key_type'];
                    let privateKeyBits = records[i]['private_key_bits'];
                    let generationTime = records[i]['generation_time'];
                    let tdata = getTableTemplate(csrId, csrName, domainName, privateKeyType, privateKeyBits, generationTime)
                    $("#csr-tbody").append(tdata);
                }
            } else {
                if (data['code'] === 'ConsoleNeedLogin') $prompt.error("请登录后再试");
                else $prompt.error("列表获取失败");
            }
        },
        error: function () {
            $prompt.error("请求失败");
        }
    });
}

function generateCSR() {
    $("#generate-csr-offcanvas-div").load("/static/html/form/generate-csr.html", function () {
        $("#generate-csr-offcanvas").offcanvas("show").on('hidden.bs.offcanvas', function () {
            $(this).remove();
        });
        $("domain").keyup(function () {
            checkDomainName();
        });
        $('#global-location').cxSelect({
            url: 'https://cdn.antx.cc/libs/jquery-cxselect/1.0.0/global-data.min.json',
            selects: ['country', 'state', 'city', 'region'],
            nodata: 'none'
        });
        let callback = function () {
            $('#generate-csr-captcha-modal').on('hidden.bs.modal', function () {
                $(this).remove();
            }).modal('hide');
            let email = $("#email").val();
            let name = $("#csr-name").val();
            let domain = $("#domain").val();
            let country = pinyin.getCamelChars($("#country").val() ?? '');
            let status = pinyin.getFullChars($("#state").val() ?? '');
            let city = pinyin.getFullChars($("#city").val() ?? '');
            let org = $("#org").val();
            let unit = $("#unit").val();
            let digest_alg = $("#digest-alg").val();
            let private_key_type = $("#private-key-type").val();
            let private_key_bits = parseInt($("#private-key-bits").val());
            let config = {
                digest_alg: digest_alg,
                private_key_type: private_key_type,
                private_key_bits: private_key_bits
            };
            let distinguished_names = {
                email_address: email,
                common_name: domain,
                country_name: country,
                state_or_province_name: status,
                locality_name: city,
                organization_name: org,
                organizational_unit_name: unit
            }
            $.ajax({
                url: "https://ssl.api.cloud.antx.cc/api/csr/index.php",
                type: 'POST',
                data: {
                    action: 'generateCsr',
                    name: name,
                    config: JSON.stringify(config),
                    distinguished_names: JSON.stringify(distinguished_names)
                },
                dataType: 'json',
                async: true,
                xhrFields: {
                    withCredentials: true
                },
                success: function (data) {
                    if (data['success']) {
                        $("#generate-csr-offcanvas").offcanvas('hide');
                        alertCSRInfo(data);
                        $("#csr-tbody").empty();
                        initCSRTable();
                        $prompt.success("CSR生成成功");
                    } else {
                        if (data['code'] === 'ConsoleNeedLogin') $prompt.error("请登录后再试");
                        else $prompt.error("CSR生成失败");
                    }
                },
                error: function () {
                    $prompt.error("请求失败");
                }
            });
        }
        $("#generate-csr-btn").click(function () {
            $.captcha({callback: callback, modalId: 'generate-csr-captcha-modal'});
        });
    });
}

function displayCSRInfo(csrId) {
    $.ajax({
        url: 'https://ssl.api.cloud.antx.cc/api/csr/index.php',
        type: 'POST',
        data: {action: 'describeCSRRecordInfo', csr_id: csrId},
        dataType: 'json',
        async: true,
        xhrFields: {
            withCredentials: true
        },
        success: function (data) {
            if (data['success']) {
                $("#display-csr-info-offcanvas-div").load('/static/html/form/display-csr-info.html', function () {
                    let info = data['info'][0];
                    let csrNme = info['name'];
                    let domain = info['common_name'];
                    let country = info['country_name'];
                    let stateOrProvinceName = info['state_or_province_name'];
                    let localityName = info['locality_name'];
                    let emailAddress = info['email_address'];
                    let privateKeyType = info['private_key_type'];
                    let privateKeyBits = info['private_key_bits'];
                    let generationTime = info['generation_time'];
                    let organizationName = info['organization_name'];
                    let organizationalUnitName = info['organizational_unit_name'];
                    let csr = info['csr'];
                    let privateKey = info['private_key'];
                    $("#csr-name").text(csrNme);
                    $("#domain").text(domain);
                    $("#private-key-type").text(privateKeyType);
                    $("#private-key-bits").text(privateKeyBits);
                    $("#generation-time").text(generationTime);
                    $("#email-address").text(emailAddress);
                    $("#organization-name").text(organizationName);
                    $("#organizational-unit-name").text(organizationalUnitName);
                    $("#country-name").text(country);
                    $("#state-or-province-name").text(stateOrProvinceName);
                    $("#locality-name").text(localityName);
                    $("#display-csr-and-private-key").click(function () {
                        $(this).hide();
                        $("#csr").text(csr);
                        $("#private-key").text(privateKey);
                    });
                    $("#display-csr-info-offcanvas").offcanvas("show").on('hidden.bs.offcanvas', function () {
                        $(this).remove();
                    });
                });
            } else {
                if (data['code'] === 'ConsoleNeedLogin') $prompt.error("请登录后再试");
                else $prompt.error("列表获取失败");
            }
        },
        error: function () {
            $prompt.error("请求失败");
        }
    });
}

function alertCSRInfo(data) {
    $("#display-csr-info-div").load('/static/html/form/alert-csr-info.html', function () {
        let private_key = data['private_key'];
        let csr = data['csr'];
        $("#private-key").val(private_key)
        $("#csr").val(csr)
        $("#display-csr-info-modal").modal('show').on('hidden.bs.modal', function () {
            $(this).remove();
        });
    });
}

function checkDomainName() {
    let domain = $("domain").val();
    if (domain) {
        if (isDomainName(domain)) {
            $("domain-error").html(``);
            return true;
        } else {
            $("domain-error").html(`${error} 域名格式错误`);
            return false;
        }
    } else {
        $("domain-error").html(`${error} 域名不可为空`);
        return false;
    }
}


function getTableTemplate(csrId, csrName, domainName, privateKeyType, privateKeyBits, generationTime) {
    return `
        <tr id="csrId-${csrId}">
            <td><small>${csrName}</small></td>
            <td><small>${domainName}</small></td>
            <td><small>${privateKeyType}</small></td>
            <td><small>${privateKeyBits}</small></td>
            <td><small>${generationTime}</small></td>
            <td>
                <small>
                    <a class="text-decoration-none small" href="javascript:void(0)" onclick="deleteCSR('${csrId}')">删除</a> |
                    <a class="text-decoration-none small" href="javascript:void(0)" onclick="displayCSRInfo('${csrId}')">详情</a>
                </small>
            </td>
        </tr>`;
}