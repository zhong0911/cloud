<?php

// This file is auto-generated, don't edit it. Thanks.

namespace AlibabaCloud\SDK\Domain\V20180129\Models\SaveBatchTaskForCreatingOrderRenewRequest;

use AlibabaCloud\Tea\Model;

class orderRenewParam extends Model
{
    /**
     * @var int
     */
    public $currentExpirationDate;

    /**
     * @var string
     */
    public $domainName;

    /**
     * @var int
     */
    public $subscriptionDuration;
    protected $_name = [
        'currentExpirationDate' => 'CurrentExpirationDate',
        'domainName'            => 'DomainName',
        'subscriptionDuration'  => 'SubscriptionDuration',
    ];

    public function validate()
    {
    }

    public function toMap()
    {
        $res = [];
        if (null !== $this->currentExpirationDate) {
            $res['CurrentExpirationDate'] = $this->currentExpirationDate;
        }
        if (null !== $this->domainName) {
            $res['DomainName'] = $this->domainName;
        }
        if (null !== $this->subscriptionDuration) {
            $res['SubscriptionDuration'] = $this->subscriptionDuration;
        }

        return $res;
    }

    /**
     * @param array $map
     *
     * @return orderRenewParam
     */
    public static function fromMap($map = [])
    {
        $model = new self();
        if (isset($map['CurrentExpirationDate'])) {
            $model->currentExpirationDate = $map['CurrentExpirationDate'];
        }
        if (isset($map['DomainName'])) {
            $model->domainName = $map['DomainName'];
        }
        if (isset($map['SubscriptionDuration'])) {
            $model->subscriptionDuration = $map['SubscriptionDuration'];
        }

        return $model;
    }
}
