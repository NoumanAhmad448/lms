<?php

namespace Eren\Lms\Controllers;

use Eren\Lms\Action\InstructorAction;
use Eren\Lms\Action\OfflinePaymentAction;
use Eren\Lms\Action\SettingAction;
use Eren\Lms\Action\WithdrawPaymentAction;
use Eren\Lms\Contracts\PaymentGatewayContract;
use Eren\Lms\Models\InstructorPayment;
use Eren\Lms\Models\OfflinePayment;
use Eren\Lms\Models\Setting;
use Eren\Lms\Models\WithdrawPayment;
use Eren\Lms\Rules\IsScriptAttack;
use Eren\Lms\Rules\ValidPhoneNumber;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Pipeline;
use Illuminate\Support\Facades\Validator;

class InstructorPaymentController extends Controller
{

    public function paymentGateways()
    {
        $data = [];
        return (new Pipeline(app()))->send($data)->through(array_filter([
            InstructorAction::class,
            SettingAction::class,
            OfflinePaymentAction::class,
            WithdrawPaymentAction::class,
        ]))->then(function ($data) {
            return app(PaymentGatewayContract::class, ["data" => $data]);
        });
    }

    public function storeBankPayment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'b_name' => ['required', 'string', new IsScriptAttack],
                'b_swift_code' => ['required', 'string', new IsScriptAttack],
                'b_account_name' => ['required', 'string', new IsScriptAttack],
                'b_account_no' => ['required', 'string', new IsScriptAttack],
                'b_branch_name' => ['required', 'string', new IsScriptAttack],
                'b_branch_addr' => ['required', 'string', new IsScriptAttack],
                'b_iban' => ['required', 'string', new IsScriptAttack],
            ], [], [
                'b_name' => 'bank name',
                'b_swift_code' => 'swift code',
                'b_account_name' => 'account name',
                'b_account_no' => 'Account number',
                'b_branch_name' => 'branch name',
                'b_branch_addr' => 'branch address',
                'b_iban' => 'IBAN',

            ]);



            if ($validator->fails()) {
                return  redirect()->route('i-payment-setting', ['#bank-form'])
                    ->withErrors($validator)
                    ->withInput();
            }
        } catch (\Throwable $th) {
            return back();
        }

        try {
            $setting = InstructorPayment::where('user_id', auth()->id())->first();
            if (!$setting) {
                $data = $request->all();
                $data['user_id'] = auth()->id();
                InstructorPayment::create($data);
            } else {

                $setting->b_name = $request->b_bank_name;
                $setting->b_swift_code = $request->b_swift_code;
                $setting->b_account_name = $request->b_account_name;
                $setting->b_account_no = $request->b_account_no;
                $setting->b_branch_name = $request->b_branch_name;
                $setting->b_branch_addr = $request->b_branch_addr;
                $setting->b_iban = $request->b_iban;
                $setting->save();
            }
        } catch (Exception $e) {
            return redirect()->route('i-payment-setting', ['#bank-form'])->with('error', 'Server Error' . $e->getMessage());
        }

        return redirect()->route('i-payment-setting', ['#bank-form'])->with('status', 'saved');
    }
    public function storePaypalPayment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'paypal_account' => ['required', 'email', new IsScriptAttack]
            ], [], ['paypal_account' => 'Paypal Account Email']);

            if ($validator->fails()) {
                return redirect()->route('i-payment-setting', ['#paypal-form'])
                    ->withErrors($validator)
                    ->withInput();
            }
        } catch (\Throwable $th) {
            return back();
        }

        try {
            $setting = InstructorPayment::where('user_id', auth()->id())->first();
            if (!$setting) {
                $data = $request->all();
                $data['user_id'] = auth()->id();
                InstructorPayment::create($data);
            } else {
                $setting->paypal_account = $request->paypal_account;
                $setting->save();
            }
        } catch (Exception $e) {
            return redirect()->route('i-payment-setting', ['#paypal-form'])->with('error', 'Server Error');
        }

        return redirect()->route('i-payment-setting', ['#paypal-form'])->with('status', 'saved');
    }
    public function storePayoneerPayment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'payoneer_account' => ['required', 'email', new IsScriptAttack]
            ], [], ['payoneer_account' => 'Paypal Account Email']);

            if ($validator->fails()) {
                return redirect()->route('i-payment-setting', ['#payoneer-form'])
                    ->withErrors($validator)
                    ->withInput();
            }
        } catch (\Throwable $th) {
            return back();
        }

        try {
            $setting = InstructorPayment::where('user_id', auth()->id())->first();
            if (!$setting) {
                $data = $request->all();
                $data['user_id'] = auth()->id();
                InstructorPayment::create($data);
            } else {
                $setting->payoneer_account = $request->payoneer_account;
                $setting->save();
            }
        } catch (Exception $e) {
            return redirect()->route('i-payment-setting', ['#payoneer-form'])->with('error', 'Server Error');
        }

        return redirect()->route('i-payment-setting', ['#payoneer-form'])->with('status', 'saved');
    }
    public function storeJazzcashPayment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'j_account' => ['required', 'numeric', new ValidPhoneNumber],
            ], [], ['j_account' => 'jazzcash account']);

            if ($validator->fails()) {
                return redirect()->route('i-payment-setting', ['#jazzcash_form'])
                    ->withErrors($validator)
                    ->withInput();
            }
        } catch (\Throwable $th) {
            return back();
        }

        try {
            $setting = InstructorPayment::where('user_id', auth()->id())->first();
            if (!$setting) {
                $data = $request->all();
                $data['user_id'] = auth()->id();
                InstructorPayment::create($data);
            } else {
                $setting->j_account = $request->j_account;
                $setting->save();
            }
        } catch (Exception $e) {
            return redirect()->route('i-payment-setting', ['#jazzcash_form'])->with('error', 'Server Error');
        }

        return redirect()->route('i-payment-setting', ['#jazzcash_form'])->with('status', 'saved');
    }
    public function storeEasypaisaPayment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'e_account' => ['required', 'numeric', new ValidPhoneNumber],
            ], [], ['e_account' => 'easypaisa account']);

            if ($validator->fails()) {
                return  redirect()->route('i-payment-setting', ['#easypaisa_form'])
                    ->withErrors($validator)
                    ->withInput();
            }
        } catch (\Throwable $th) {
            return back();
        }

        try {
            $setting = InstructorPayment::where('user_id', auth()->id())->first();
            if (!$setting) {
                $data = $request->all();
                $data['user_id'] = auth()->id();
                InstructorPayment::create($data);
            } else {

                $setting->e_account = $request->e_account;
                $setting->save();
            }
        } catch (Exception $e) {
            return redirect()->route('i-payment-setting', ['#easypaisa_form'])->with('error', 'Server Error');
        }

        return redirect()->route('i-payment-setting', ['#easypaisa_form'])->with('status', 'saved');
    }
}
