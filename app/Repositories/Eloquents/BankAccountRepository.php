<?php

namespace App\Repositories\Eloquents;

use App\Models\BankAccount;

class BankAccountRepository extends BaseRepository
{

    public function __construct(BankAccount $bankAccount)
    {
        parent::__construct();
        $this->model = $bankAccount;
    }

    public function model()
    {
        return BankAccount::class;
    }

    public function listByUserId($userId)
    {
        return $this->where('user_id', $userId)->lists('account', 'id');
    }
}
