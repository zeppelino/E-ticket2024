<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class NotificacionesCampanaController extends Controller
{

    /*===================
    MARCAR COMO LEIDA
    ===================*/

    public function marcarComoLeida($notificationId)
    {

        $user = auth()->user();
        $notification = $user->notifications()->find($notificationId);

        if ($notification) {
            $notification->markAsRead();
        }

        return response()->json(['count' => $user->unreadNotifications()->count()]);
    }

    /*===========================
    MOSTRAR TABLA NOTIFICACIONES
    ============================*/

    public function verTablaNotificaciones()
    {

        // Obtiene el usuario autenticado
        $user = Auth::user();

        // Recupera las notificaciones del usuario
        $notifications = $user->notifications()->get();

        return view('admin.verNotificaciones', compact('notifications'));
    }

}
