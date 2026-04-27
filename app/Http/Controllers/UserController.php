<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        return Inertia::render('Profile/Orders');
    }
    public function reviews() 
    {
        return Inertia::render('Profile/Reviews');
    }
    public function addresses() 
    {
        return Inertia::render('Profile/Addresses');
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
            
            // 2. Явно обновляем поле в БД
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
