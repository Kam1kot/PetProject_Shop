<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('Profile/Profile');
    }
    public function orders() 
    {
        $orders = auth()->user()->orders()->latest()->get();
        return Inertia::render('Profile/Orders', [
            'orders' => $orders,
        ]);
    }
    public function reviews() 
    {
        return Inertia::render('Profile/Reviews');
    }
    public function addresses() 
    {
        return Inertia::render('Profile/Addresses');
    }
    public function updateData(Request $request) {
        $data = $request->validate([
            'name' => 'required|max:255|min:3',
            'surname' => 'required|max:255|min:3',
            'nickname' => 'required|max:255|min:3',
        ]);
        auth()->user()->update($data);
    }
    public function passwordReset (Request $request) {
        $user = auth()->user();

        if (!Hash::check($request->oldPassword,$user->password)) {
            return back()->withErrors(['oldPassword' => 'Неверный текущий пароль']);
        }

        $request->validate([
            'newPassword' => 'required|min:5',
        ]);

        $user->password = Hash::make($request->newPassword);
        $user->save();

        return back()->with('success', 'Пароль успешно изменен');
    }
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'nullable|image|max:2048',
        ]);

        $user = $request->user();

        if ($request->hasFile('avatar')) {
            // Удаляем старый, если есть
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Сохраняем новый файл
            $path = $request->file('avatar')->store('avatars', 'public');
            
            // Явно обновляем поле в БД
            $user->avatar = $path;
            $user->save();
        }

        return back();
    }
    public function deleteAvatar(Request $request) {
        $user = $request->user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }
        $user->avatar = null;
        $user->save();
    }
}
