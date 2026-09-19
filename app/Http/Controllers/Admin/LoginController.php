<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Exception;


class LoginController extends Controller
{
    protected $redirectTo = 'admin/login';

    public function __construct()
    {
        try {
            $this->middleware('guest', ['except' => 'logout']);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function login()
    {
        try {
            Auth()->guard('admin')->logout();
            return view('admin.login.login');
        } catch (Exception $e) {
            return response()->json(
                array(
                    'status' => 400,
                    'errors' => $e->getMessage()
                )
            );
        }
    }

    public function logout()
    {
        try {
            Auth()->guard('admin')->logout();
            return redirect()->route('admin.login')
                ->with('success', __('label.logout_successfully'));
        } catch (Exception $e) {
            return response()->json(
                array(
                    'status' => 400,
                    'errors' => $e->getMessage()
                )
            );
        }
    }

    public function postlogin(Request $request)
    {
        try {
            $input = $request->only(
                [
                    'email',
                    'password',]
            );

            $rules = [
                'email' => 'required|max:255',
                'password' => 'required|max:20|min:4',
            ];

            $messages = [
                'email.required' => __('admin/login.required', ['field' => 'Email']),
                'email.max' => __('admin/login.max_255', ['field' => 'Email']),
                'password.required' => __('admin/login.required', ['field' => 'Password']),
                'password.max' => __('admin/login.max_255', ['field' => 'Password']),
                'password.min' => __('admin/login.min_4', ['field' => 'Password']),
            ];

            $validator = Validator::make(
                $input,
                $rules,
                $messages
            );

            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(
                    array(
                        'status' => 400,
                        'errors' => $errs
                    )
                );
            }

            $requestData = $request->all();
            if (Auth()->guard('admin')->attempt(
                [
                    'email' => $requestData['email'],
                    'password' => $requestData['password']
                ]
            )) {
                $user = auth()->guard('admin')->user();

                if ($user->active != 1) {
                    auth()->guard('admin')->logout();
                    return response()->json(
                        array(
                            'status' => 403,
                            'errors' => __('label.inactive_account')
                        )
                    );
                }

                if ($user->type == 1) {
                    $this->middleware('checkadmin');
                }

                return response()->json(
                    array(
                        'status' => 200,
                        'success' => __('label.success_login')
                    )
                );
            } else {
                return response()->json(
                    array(
                        'status' => 400,
                        'errors' => __('label.error_login')
                    )
                );
            }
        } catch (Exception $e) {
            return response()->json(
                array(
                    'status' => 400,
                    'errors' => $e->getMessage()
                )
            );
        }
    }
}
