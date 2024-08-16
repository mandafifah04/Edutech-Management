<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * begin::login user and admin
     */
    public function halamanLogin()
    {
        try {

            if (!$this->cekSetelahLoginUser()) {
                return $this->Response('anda sudah login user dan tidak perlu kembali ke halaman login', 'dashboard.utama', 'success');
            }

            if (!$this->cekSetelahLoginAdmin()) {
                return $this->Response('anda sudah login admin dan tidak perlu kembali ke halaman login', 'admin.dashboard', 'success');
            }

            return $this->tampilanLogin();
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'login', 'error');
        }
    }

    public function JalankanLogikaLogin(Request $request): RedirectResponse
    {
        $this->validasiInputYangDimasukan($request);
        try {

            if ($this->rulesLoginYangDiPilih($request)) {
                if ($this->cekParameterLoginUser($this->parameterLoginDenganEmail($request))) {
                    $user = $this->parameterLoginDenganEmail($request);
                } elseif ($this->cekParameterLoginUser($this->parameterLoginDenganUsername($request))) {
                    $user = $this->parameterLoginDenganUsername($request);
                } else {
                    return $this->responseErrorKetikaLoginInvalidUser();
                }
                $this->membuatSessionUntukLoginUser($user);
                return $this->arahakanKeSebuahHalamanSetelahLoginSuksesUser();
            } else {

                if ($this->cekParameterLoginAdmin($this->parameterLoginDenganEmail($request))) {
                    $this->membuatSessionUntukLoginAdmin();
                } elseif ($this->cekParameterLoginAdmin($this->parameterLoginDenganUsername($request))) {
                    $this->membuatSessionUntukLoginAdmin();
                } else {
                    return $this->responseErrorKetikaLoginInvalidAdmin();
                }
                return $this->arahakanKeSebuahHalamanSetelahLoginSuksesAdmin();
            }
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'login', 'error');
        }
    }

    private function tampilanLogin(): view
    {
        return view('dashboard.auth.login');
    }

    private function cekSetelahLoginUser(): bool
    {
        return !Auth::guard('user')->check() ? true : false;
    }

    private function cekSetelahLoginAdmin(): bool
    {
        return !Auth::guard('admin')->check() ? true : false;
    }

    private function validasiInputYangDimasukan($request)
    {
        return $request->validate([
            'umail' => 'required|string',
            'password' => 'required|string',
            'statelogin' => 'required|string',
        ], [
            'required' => ':attribute wajib di isi'
        ]);
    }

    private function responseErrorKetikaLoginInvalidUser(): RedirectResponse
    {
        return $this->Response('credential user berupa email/username atau password salah', 'login', 'error');
    }

    private function responseErrorKetikaLoginInvalidAdmin(): RedirectResponse
    {
        return $this->Response('credential admin berupa email/username atau password salah', 'login', 'error');
    }

    private function rulesLoginYangDiPilih($request): bool
    {
        return $request->input('statelogin') == 'user' ? true : false;
    }

    private function parameterLoginDenganEmail($request): array
    {
        return array('email' => $request->umail, 'password' => $request->password);
    }

    private function parameterLoginDenganUsername($request): array
    {
        return array('username' => $request->umail, 'password' => $request->password);
    }

    private function cekParameterLoginUser($request): bool
    {
        return Auth::guard('user')->attempt($request) ? true : false;
    }

    private function cekParameterLoginAdmin($request): bool
    {
        return Auth::guard('admin')->attempt($request) ? true : false;
    }

    private function arahakanKeSebuahHalamanSetelahLoginSuksesUser(): RedirectResponse
    {
        return redirect()->intended('user/dashboard');
    }

    private function arahakanKeSebuahHalamanSetelahLoginSuksesAdmin(): RedirectResponse
    {
        return redirect()->intended('admin/dashboard');
    }

    private function membuatSessionUntukLoginUser($request): void
    {
        $simpanSessionUser = Auth::getProvider()->retrieveByCredentials($request);
        Auth::guard('user')->login($simpanSessionUser);
    }

    private function membuatSessionUntukLoginAdmin()
    {
        return Auth::guard('admin')->user();
    }
    /**
     * end::login user and admin
     */
}
