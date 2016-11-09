<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Repositories\Eloquents\BankAccountRepository;
use App\Http\Requests\BankAccountCreateRequest;
use Auth;

class BankAccountController extends Controller
{
    protected $userId;
    protected $bankAccountRepository;

    public function __construct(BankAccountRepository $bankAccountRepository)
    {
        $this->middleware('auth');
        $this->userId = Auth::user()->id;
        $this->bankAccountRepository = $bankAccountRepository;
    }

    public function store(BankAccountCreateRequest $request)
    {
        $message = '';
        $bankAccount = $this->bankAccountRepository->where('account', $request->account)->first();
        if ($bankAccount['status'] && $bankAccount['data']) {
            $message = trans('user.message.create_on_exist_bank');
        } elseif (!$bankAccount['data']) {
            $newBankAccount = $this->bankAccountRepository->create([
                'account' => $request->account,
                'user_id' => $this->userId,
            ]);
            if ($newBankAccount['status']) {
                return redirect()->route('getProfile')->with([
                    config('common.flash_notice') => trans('user.message.success_add_bank'),
                    config('common.flash_level_key') => config('common.flash_level.success'),
                ]);
            }
        }

        return redirect()->route('getProfile')->with([
            config('common.flash_notice') => trans('user.message.fail') . $message,
            config('common.flash_level_key') => config('common.flash_level.danger'),
        ]);
    }

    public function destroy($id)
    {
        $deleteResult = $this->bankAccountRepository->delete($id);

        return ['status' => $deleteResult['status']];
    }
}
