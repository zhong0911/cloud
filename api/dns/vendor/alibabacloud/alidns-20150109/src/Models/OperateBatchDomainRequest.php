<?php

// This file is auto-generated, don't edit it. Thanks.

namespace AlibabaCloud\SDK\Alidns\V20150109\Models;

use AlibabaCloud\SDK\Alidns\V20150109\Models\OperateBatchDomainRequest\domainRecordInfo;
use AlibabaCloud\Tea\Model;

class OperateBatchDomainRequest extends Model
{
    /**
     * @var string
     */
    public $lang;

    /**
     * @var string
     */
    public $userClientIp;

    /**
     * @var string
     */
    public $type;

    /**
     * @var domainRecordInfo[]
     */
    public $domainRecordInfo;
    protected $_name = [
        'lang'             => 'Lang',
        'userClientIp'     => 'UserClientIp',
        'type'             => 'Type',
        'domainRecordInfo' => 'DomainRecordInfo',
    ];

    public function validate()
    {
    }

    public function toMap()
    {
        $res = [];
        if (null !== $this->lang) {
            $res['Lang'] = $this->lang;
        }
        if (null !== $this->userClientIp) {
            $res['UserClientIp'] = $this->userClientIp;
        }
        if (null !== $this->type) {
            $res['Type'] = $this->type;
        }
        if (null !== $this->domainRecordInfo) {
            $res['DomainRecordInfo'] = [];
            if (null !== $this->domainRecordInfo && \is_array($this->domainRecordInfo)) {
                $n = 0;
                foreach ($this->domainRecordInfo as $item) {
                    $res['DomainRecordInfo'][$n++] = null !== $item ? $item->toMap() : $item;
                }
            }
        }

        return $res;
    }

    /**
     * @param array $map
     *
     * @return OperateBatchDomainRequest
     */
    public static function fromMap($map = [])
    {
        $model = new self();
        if (isset($map['Lang'])) {
            $model->lang = $map['Lang'];
        }
        if (isset($map['UserClientIp'])) {
            $model->userClientIp = $map['UserClientIp'];
        }
        if (isset($map['Type'])) {
            $model->type = $map['Type'];
        }
        if (isset($map['DomainRecordInfo'])) {
            if (!empty($map['DomainRecordInfo'])) {
                $model->domainRecordInfo = [];
                $n                       = 0;
                foreach ($map['DomainRecordInfo'] as $item) {
                    $model->domainRecordInfo[$n++] = null !== $item ? domainRecordInfo::fromMap($item) : $item;
                }
            }
        }

        return $model;
    }
}
