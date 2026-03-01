<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    // Hiển thị trang hồ sơ
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    // Cập nhật thông tin
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:500',
        ]);

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return back()->with('success', 'Cập nhật thông tin cá nhân thành công!');
    }
}