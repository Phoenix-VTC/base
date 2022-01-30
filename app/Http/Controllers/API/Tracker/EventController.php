<?php

namespace App\Http\Controllers\API\Tracker;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Display a listing of the events.
     *
     * @return void
     */
    public function index(): void
    {
        //
    }

    /**
     * Display the specified event.
     *
     * @param int $id
     * @return void
     */
    public function show($id): void
    {
        //
    }

    /**
     * Display the next event.
     *
     * @return JsonResponse
     */
    public function showNext(): JsonResponse
    {
        try {
            // Query the upcoming event
            $event = Event::query()
                ->where('start_date', '>=', now())
                ->where('published', true)
                ->orderBy('start_date')
                ->select([
                    'id',
                    'name',
                    'description',
                    'start_date',
                    'featured_image_url',
                    'game_id',
                ])
                ->firstOrFail();

            // Strip the HTML from the description, except <br>
            $description = strip_tags($event->description, ['<br>']);
            // If there's multiple <br> tags, replace them with just one
            $description = preg_replace('/(<br>\s*)+/', '<br>', $description);
            // Limit the description to the first 200 characters
            $description = Str::limit($description, 200);

            // Add the event description and URL to the array
            $event = array_merge($event->toArray(), [
                'description' => strip_tags($description, ['<br>']),
                'url' => route('events.show', [$event->id, $event->slug]),
            ]);

            return response()->json($event);
        } catch (ModelNotFoundException) {
            return response()->json([
                'error' => 'No upcoming events found.'
            ], 404);
        }
    }
}
