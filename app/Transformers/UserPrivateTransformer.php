<?php


namespace App\Transformers;

use App\Ship\Parents\Transformer;

class UserPrivateTransformer extends Transformer
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'response-content' => $this->token['response-content'],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}