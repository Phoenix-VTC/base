<?php

namespace App\Http\Controllers\API\Tracker;

use App\Enums\JobStatus;
use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public User $user;

    public function __construct(Request $request)
    {
        //
    }

    /**
     * Display a listing unverified tracker jobs.
     *
     * @param Request $request
     * @return array
     */
    public function index(Request $request): array
    {
        $this->user = $request->user();

        return $this->user
            ->jobs()
            ->select([
                'id',
                'game_id',
                'started_at',
                'finished_at',
                'distance',
                'load_damage',
                'estimated_income',
                'total_income',
                'status',
                'pickup_city_id',
                'destination_city_id',
                'pickup_company_id',
                'destination_company_id',
                'cargo_id',
                'status',
            ])
            ->where('tracker_job', true)
            ->whereNested(function ($query) {
                $query->where('status', JobStatus::Incomplete)
                    ->orWhere('status', JobStatus::PendingVerification);
            })
            ->with([
                'pickupCity:id,real_name,name,country,dlc,mod,game_id',
                'destinationCity:id,real_name,name,country,dlc,mod,game_id',
                'pickupCompany:id,name,category,specialization,dlc,mod,game_id',
                'destinationCompany:id,name,category,specialization,dlc,mod,game_id',
                'cargo:id,name,dlc,mod,weight,game_id,world_of_trucks'
            ])
            ->orderByDesc('created_at')
            ->get()
            ->toArray();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request): void
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Job $job
     * @return void
     */
    public function show(Job $job): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Job $job
     * @return void
     */
    public function edit(Job $job): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Job $job
     * @return void
     */
    public function update(Request $request, Job $job): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Job $job
     * @return void
     */
    public function destroy(Job $job): void
    {
        //
    }
}
