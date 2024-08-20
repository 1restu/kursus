<?php

namespace App\Http\Controllers\Auth;

use App\Models\AdminModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{

    protected $redirectTo = '/login'; 

    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'min:5', 'max:255', 'unique:admin', 'regex:/^[a-zA-Z\s]+$/'],
            'username' => ['required', 'string', 'max:255', 'min:5', 'unique:admin', 'regex:/[a-zA-Z]/'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.unique' => 'nama telah digunakan oleh admin lain, silakan gunakan nama yang berbeda.',
            'name.string' => 'Nama harus berupa string.',
            'name.min' => 'Nama harus memiliki minimal setidaknya 5 karakter.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'name.regex' => 'Nama hanya boleh terdiri dari huruf.',
            'username.required' => 'Username wajib diisi.',
            'username.string' => 'Username harus berupa string.',
            'username.max' => 'Username tidak boleh lebih dari 255 karakter.',
            'username.min' => 'Username harus memiliki setidaknya 5 karakter',
            'username.unique' => 'Username telah digunakan oleh admin lain, silakan gunakan username yang berbeda.',
            'username.regex' => 'Username harus mengandung minimal satu huruf.',
            'password.required' => 'Password wajib diisi.',
            'password.string' => 'Password harus berupa string.',
            'password.min' => 'Password harus memiliki minimal setidaknya 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);
    }

    protected function create(array $data)
    {
        try {
            return AdminModel::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'password' => $data['password'],
            ]);
        } catch (\Exception $e) {
            // Log error jika terjadi kesalahan
            Log::error('Error creating admin: ' . $e->getMessage());
            return null;
        }
    }

    public function register(Request $request)
    {
        // Validasi input
        $this->validator($request->all())->validate();

        // Proses registrasi
        $admin = $this->create($request->all());

        if ($admin) {
            return redirect($this->redirectTo)->with('success', 'Registrasi berhasil, silakan login.');
        }

        return back()->with('error', 'Registrasi gagal, silakan coba lagi.');
    }
}