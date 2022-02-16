<?php

namespace App\Http\Resources\Multiplayer;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class ServerResource extends JsonResource
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
            'id' => $this['id'],
            'game' => $this['game'],
            'ip' => $this['ip'],
            'port' => $this['port'],
            'name' => $this['name'],
            'shortname' => $this['shortname'],
            'id_prefix' => $this['idprefix'],
            'online' => $this['online'],
            'players_online' => $this['players'],
            'queue' => $this['queue'],
            'max_players' => $this['maxplayers'],
            'map_id' => $this['mapid'],
            'display_order' => $this['displayorder'],
            'speedlimiter' => (bool)$this['speedlimiter'],
            'collisions' => $this['collisions'],
            'cars_for_players' => $this['carsforplayers'],
            'afk_enabled' => $this['afkenabled'],
            'event_server' => $this['event'],
            'special_event' => $this['specialEvent'],
            'promods' => $this['promods'],
            'mod' => $this['promods'] ? 'ProMods' : null,
            'syncdelay' => $this['syncdelay'],
        ];
    }
}
