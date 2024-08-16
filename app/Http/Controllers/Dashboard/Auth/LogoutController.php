<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LogoutController extends Controller
{
    public function jalankanLogoutUser(): RedirectResponse
    {
        try {
            $this->hapusSessionUser();
            return $this->arahakanKeHalamanLoginSetelahLogoutUser();
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'dashboard.utama', 'error');
        }
    }

    public function jalankanLogoutAdmin(): RedirectResponse
    {
        try {
            $this->hapusSessionAdmin();
            return $this->arahakanKeHalamanLoginSetelahLogoutAdmin();
        } catch (\Exception $errors) {
            return $this->Response($errors->getMessage(), 'dashboard.utama', 'error');
        }
    }

    private function hapusSessionUser()
    {
        return Auth::guard('user')->logout();
    }

    private function hapusSessionAdmin()
    {
        return Auth::guard('admin')->logout();
    }

    private function arahakanKeHalamanLoginSetelahLogoutUser(): RedirectResponse
    {
        return $this->Response('Berhasil Logout Dari User', 'login');
    }

    private function arahakanKeHalamanLoginSetelahLogoutAdmin(): RedirectResponse
    {
        return $this->Response('Berhasil Logout Dari Admin', 'login');
    }
}
