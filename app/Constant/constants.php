<?php

namespace App\Constant;

class Constants
{
    // constant for role
    const TYPE_ADMIN = 1;

    const TYPE_USER = 2;

    const STATE_ACTIVE = 1;
    const STATE_INACTIVE = 2;

    const PAGINATION_COUNT = 10;

    const LOAN_PROCESSING = 1;
    const LOAN_ADMIN_APPROVE = 2;
    const LOAN_ADMIN_REJECT = 3;
    const LOAN_REPAID = 4;

    const REPAYMENT_METHOD_CASH = 1;
    const REPAYMENT_METHOD_ONLINE = 2;

    const WEEKLY_REPAID = 1;
    const WEEKLY_REPAYMENT_PENDING = 2;
}
