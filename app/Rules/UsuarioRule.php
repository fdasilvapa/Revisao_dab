<?php

namespace App\Rules;

use App\Constants\Geral;
use Illuminate\Support\Facades\Auth;

class UsuarioRule
{
    public function isAdmin(): bool
    {
        if (!Auth::check()) {
            return false;
        }
        
        return auth()->user()->tipo->tipo == 'Admin';
    }

    public function isProprietario()
    {
        $isProprietario = auth()->user()->tipo->tipo == 'Proprietário';

        if($isProprietario == false){
            $this->failedAuthorization();
        }

        return $isProprietario;
    }

    private function failedAuthorization()
    {
        $message = Geral::USUARIO_SEM_PERMISSAO;
        abort(403, $message);
    }
}
