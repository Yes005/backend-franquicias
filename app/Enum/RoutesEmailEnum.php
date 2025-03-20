<?php

namespace App\Enum;

enum RoutesEmailEnum: string {
    case VER_FRANQUICIA = '/ver-franquicia/{id}';
    case EDITAR_FRANQUICIA = '/editar-franquicia/{id}';
    case LOGIN = '/login';
    

    public function getUrl(array $params = []): string
    {
        $url = $this->value;

        foreach ($params as $key => $value) {
            $url = str_replace('{' . $key . '}', $value, $url);
        }

        return $url;
    }
}