<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Repositories\Eloquents\{BookingRepository, BankAccountRepository, PaymentRepository};
use Auth;
use Stripe\{Stripe, Charge};

class UserController extends Controller
{
    protected $bookingRepository;
    protected $bankAccountRepository;
    protected $paymentRepository;
    protected $userId;

    public function __construct(
        BookingRepository $bookingRepository,
        BankAccountRepository $bankAccountRepository,
        PaymentRepository $paymentRepository
    ) {
        $this->middleware('auth');
        $this->bookingRepository = $bookingRepository;
        $this->bankAccountRepository = $bankAccountRepository;
        $this->paymentRepository = $paymentRepository;
        $this->userId = Auth::user()->id;
    }

    public function getBooking()
    {
        $bookings = $this->bookingRepository->getByUserId($this->userId);
        $bankAccounts = $this->bankAccountRepository->listByUserId($this->userId);
        if ($bookings && $bankAccounts['status']) {
            return view('user.cart', [
                'bookings' => $bookings,
                'bankAccounts' => $bankAccounts['data']->toArray(),
            ]);
        }

        return view('user.cart', [
            config('common.flash_notice') => trans('user.message.error_get_booking'),
            config('common.flash_level_key') => config('common.flash_level.danger')
        ]);
    }

    public function postCancelBooking(Request $request)
    {
        $boookingRequest = $this->bookingRepository
            ->where('user_id', $this->userId)
            ->where('status', config('user.booking.new'))
            ->find($request->bookingId);
        if ($boookingRequest['status']) {
            if ($this->bookingRepository->delete($request->bookingId)['status']) {
                return response()->json([
                    'success' => trans('user.message.success_del_request'),
                ]);
            }
        }

        return response()->json([
            'err' => trans('user.message.failed'),
        ]);
    }

    public function postCheckout(Request $request)
    {
        $status = false;
        Stripe::setApiKey(env('STRIPE_KEY_SECRET'));
        $booking = $this->bookingRepository
            ->where('user_id', $this->userId)
            ->where('status', config('user.booking.new'))
            ->find($request->bookingId);
        if ($booking['status']) {
            try {
                Charge::create([
                    'amount' => $request->cost * 100,
                    'currency' => 'usd',
                    'source' => $request->stripeToken,
                    'description' => trans('user.message.user_paid_bill', [
                        'name' => Auth::user()->name,
                        'id' => $request->bookingId,
                    ]),
                ]);
                $status = true;
            } catch (Stripe\Error\Base $e) {
                $err[] = $e->getMessage();
            } catch (\Exception $e) {
                $err[] = $e->getMessage();
            }

            if ($status) {
                $currentBooking = $this->bookingRepository->update(
                    [
                        'status' => config('user.booking.paid')
                    ],
                    $request->bookingId
                );
                $payment = $this->paymentRepository->create([
                    'bank_account_id' => $request->bankAccountId,
                    'tour_id' => $booking['data']->tourSchedule->tour_id,
                ]);
                if (!$currentBooking['status'] || !$payment['status']) {
                    $err[] = trans('user.message.success_payment_but');
                } else {
                    return redirect()->back()->with([
                        config('common.flash_notice') => trans('user.message.success_payment'),
                        config('common.flash_level_key') => config('common.flash_level.success'),
                    ]);
                }
            }
        } else {
            $err[] = trans('user.message.failed');
        }

        return redirect()->back()->withErrors($err);
    }
}
