<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FoodResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $userAdded = $this->relationLoaded('userAdded') ? $this->whenLoaded('userAdded') : null;
        $userAccepts = $this->relationLoaded('userAccepts') ? $this->whenLoaded('userAccepts') : null;

        return [
            'id'                        => $this->id,
            'name'                      => $this->name,
            'amount'                    => $this->amount,
            'kcal'                      => $this->kcal,
            'protein'                   => $this->protein,
            'fat'                       => $this->fat,
            'hydrates'                  => $this->hydrates,
            'iduser_added'              => $this->iduser_added,
            $this->mergeWhen($userAdded, fn () => [
                'user_added_email'      => $userAdded->email
            ]),
            'iduser_accepts'            => $this->iduser_accepts,
            $this->mergeWhen($userAccepts, fn () => [
                'user_accepts_email'    => $userAccepts->email
            ]),
            'status'                    => $this->status
        ];
    }
}
