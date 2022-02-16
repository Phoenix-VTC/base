<?php

namespace App\Http\Resources\Multiplayer;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class PlayerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            'truckersmp_id' => $this['MpId'],
            'player_id' => $this['PlayerId'],
            'name' => $this['Name'],
            'x' => $this['X'],
            'y' => $this['Y'],
            'direction' => $this['Heading'],
            'server_id' => $this['ServerId'],
            'time' => Carbon::parse($this['Time']),
        ];
    }
}
