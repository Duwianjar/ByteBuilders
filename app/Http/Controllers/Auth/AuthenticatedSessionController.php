<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    public function storeByAdmin(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => "client",
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return redirect()->back()->with('success', 'User added successfully.');
    }

    public function deleteByAdmin(String $id): RedirectResponse
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
            return redirect()->back()->with('success', "User has been successfully deleted.");
        } else {
            return redirect()->back()->with('error', "Failed to delete user.");
        }
    }

    public function updatephoto(Request $request, string $id)
    {
        $request->validate([
            'newPhoto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::findOrFail($id);

        if ($request->hasFile('newPhoto')) {
            $newPhoto = $request->file('newPhoto');

            // Pengecekan apakah file foto ada
            if ($newPhoto->isValid()) {
                // Mengambil nama pengguna untuk digunakan dalam nama foto
                $username = $user->name;

                if ($user->photo) {
                    // Hapus foto lama jika ada
                    $oldPhotoPath = public_path($user->photo);
                    if (File::exists($oldPhotoPath)) {
                        File::delete($oldPhotoPath);
                    }
                }

                // Simpan foto baru dengan nama pengguna dan tanggal sebagai nama file
                $extension = $newPhoto->getClientOriginalExtension();
                $currentDate = date('YmdHis');
                $fileName = $username . '_' . $currentDate . '.' . $extension;

                // Simpan foto ke dalam direktori public/assets/img/pp
                $newPhoto->move(public_path('assets/img/pp'), $fileName);

                // Simpan path foto ke dalam database
                $user->photo = 'assets/img/pp/' . $fileName;

                // Simpan perubahan pada objek pengguna
                $user->save();

                return redirect()->back()->with('success-photo', 'Profil berhasil diperbarui.');
            } else {
                return "Foto tidak valid. Silakan unggah foto yang valid";
            }
        }

        return "error', 'Tidak ada file foto yang diunggah";
    }




    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}