<?php

namespace App\Http\Controllers\API\Select2;

use App\Http\Controllers\Controller;
use App\Models\Cargo;
use App\Models\City;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameDataController extends Controller
{
    public function indexCities(Request $request, int $game)
    {
        return City::where('game_id', $game)
            ->where('real_name', 'like', '%' . $request->input('q') . '%')
            ->select([
                'id',
                // This is a fucking mess lol TODO: Find something better
                // Anyway, this query concats the real_name + capitalizes the mod *if* it exists
                DB::raw("CONCAT(real_name, ' ', UPPER(SUBSTRING(COALESCE(`mod`, ''), 1, 1)), LOWER(SUBSTRING(COALESCE(`mod`, ''), 2))) AS text")
            ])->paginate(10);
    }

    public function indexCompanies(Request $request, int $game)
    {
        return Company::where('game_id', $game)
            ->where('name', 'like', '%' . $request->input('q') . '%')
            ->select([
                'id',
                // This is a fucking mess lol TODO: Find something better
                // Anyway, this query concats the name + capitalizes the mod *if* it exists
                DB::raw("CONCAT(name, ' ', UPPER(SUBSTRING(COALESCE(`mod`, ''), 1, 1)), LOWER(SUBSTRING(COALESCE(`mod`, ''), 2))) AS text")
            ])->paginate(10);
    }

    public function indexCargos(Request $request, int $game)
    {
        return Cargo::where('game_id', $game)
            ->where('name', 'like', '%' . $request->input('q') . '%')
            ->select([
                'id',
                // This is a fucking mess lol TODO: Find something better
                // Anyway, this query concats the name + capitalizes the mod *if* it exists
                DB::raw("CONCAT(name, ' ', UPPER(SUBSTRING(COALESCE(`mod`, ''), 1, 1)), LOWER(SUBSTRING(COALESCE(`mod`, ''), 2))) AS text")
            ])->paginate(10);
    }
}
