<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        if(!session('pegawai')){
            return view('Login/login');
        }else{
            return view('Dashboard/index');
        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    // public function registration()
    // {
    //     return view('auth.registration');
    // }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postLogin(Request $request)
    {
        $request->validate([
            'NIP' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('NIP', 'password');
        Alert::success('Success Title', 'Success Message');
        if (Auth::attempt($credentials)) {
            session(['pegawai' => Auth::user()]);
            if(Auth::user()->id_role == 1){
                return redirect()->route('dashboard')->withToastSuccess('Selamat Anda Berhasil Login');
            }
            elseif (Auth::user()->id_role == 2) {
                return redirect()->route('dashboard')->withToastSuccess('Selamat Anda Berhasil Login');
            }
        } else {
            return redirect()->route('login')->withToastError('NIP dan Password Tidak Sesuai');
        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */

    /**
     * Write code on Method
     *
     * @return response()
     */

    /**
     * Write code on Method
     *
     * @return response()
     */

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect()->route('login')->withToastSuccess('Anda berhasil Logout');
    }

    public function changePassword(){
        return view('Login/changePass');
    }

    public function updatePassword(Request $request, $id){

        if(Hash::check($request->PassLama, session('pegawai')->password)){
            $data = Hash::make($request->PassBaru);
            Pegawai::where("NIP", $id)->first()->update(['password' => $data]);
            return redirect()->route('pegawai')->withToastSuccess('Berhasil Mengubah Password');
        }
        else{
            return redirect()->route('changePassword.index')->withError('Password Lama tidak Sesuai');
        }

    }
}
