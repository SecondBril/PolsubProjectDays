<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class NotificationController extends Controller
{
    /**
     * Helper: Ambil user yang sedang login dengan type hint yang benar
     * Mencegah error Intelephense P1013 & memastikan user ada
     */
    private function getUser(): User
    {
        $user = Auth::user();

        if (!$user instanceof User) {
            abort(403, 'Unauthorized');
        }

        return $user;
    }

    /**
     * Tampilkan semua notifikasi user (untuk halaman /notifications)
     */
    public function index()
    {
        $user = $this->getUser();

        $notifications = $user->notifications()->paginate(20);
        $unreadCount   = $user->unreadNotifications->count();

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    /**
     * Mark satu notifikasi sebagai sudah dibaca & redirect ke URL terkait
     */
    public function markAsRead(string $id)
    {
        $user = $this->getUser();

        $notification = $user->notifications()->findOrFail($id);
        $notification->markAsRead();

        $url = $notification->data['url'] ?? route('dashboard');

        return redirect($url);
    }

    /**
     * Mark semua notifikasi sebagai sudah dibaca
     */
    public function markAllAsRead()
    {
        $user = $this->getUser();
        $user->unreadNotifications->markAsRead();

        return back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }

    /**
     * Hapus satu notifikasi
     */
    public function destroy(string $id)
    {
        $user = $this->getUser();

        $notification = $user->notifications()->findOrFail($id);
        $notification->delete();

        return back()->with('success', 'Notifikasi berhasil dihapus.');
    }

    /**
     * Hapus semua notifikasi
     */
    public function clearAll()
    {
        $user = $this->getUser();
        $user->notifications()->delete();

        return back()->with('success', 'Semua notifikasi telah dihapus.');
    }

    /**
     * API endpoint untuk Livewire/JS: Ambil unread count (JSON)
     */
    public function unreadCount()
    {
        $user = $this->getUser();

        return response()->json([
            'count' => $user->unreadNotifications->count(),
        ]);
    }
}
