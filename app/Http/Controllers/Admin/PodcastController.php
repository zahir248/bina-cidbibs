<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Podcast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PodcastController extends Controller
{
    public function index()
    {
        $binaPodcasts = Podcast::query()->bina();
        $fmPodcasts = Podcast::query()->fm();
        
        return view('admin.podcasts.index', compact('binaPodcasts', 'fmPodcasts'));
    }

    public function create()
    {
        return view('admin.podcasts.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'type' => 'required|in:bina,fm',
                'episode_number' => 'required|string',
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'youtube_url' => 'nullable|url',
                'panelists' => 'nullable|string',
                'is_live_streaming' => 'boolean',
                'live_streaming_event' => 'nullable|string',
                'is_coming_soon' => 'boolean',
                'display_order' => 'integer',
                'image' => 'nullable|url',
                'is_special' => 'boolean',
                'special_position' => 'nullable|required_if:is_special,1|in:above,below'
            ]);

            // Convert panelists textarea to array
            if (!empty($validated['panelists'])) {
                $panelists = array_filter(explode("\n", $validated['panelists']));
                $validated['panelists'] = array_map('trim', $panelists);
            } else {
                $validated['panelists'] = [];
            }

            // Handle special episode position
            if (!empty($validated['is_special']) && !empty($validated['special_position'])) {
                $validated['display_order'] = $this->calculateSpecialDisplayOrder(
                    $validated['type'],
                    $validated['episode_number'],
                    $validated['special_position']
                );
            }

            Podcast::create($validated);

            return redirect()->route('admin.podcasts.index')
                ->with('success', 'Podcast created successfully.');

        } catch (\Exception $e) {
            \Log::error('Failed to create podcast', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withInput()
                ->with('error', 'Failed to upload image: ' . $e->getMessage());
        }
    }

    public function edit(Podcast $podcast)
    {
        return view('admin.podcasts.edit', compact('podcast'));
    }

    public function update(Request $request, Podcast $podcast)
    {
        try {
            $validated = $request->validate([
                'type' => 'required|in:bina,fm',
                'episode_number' => 'required|string',
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'youtube_url' => 'nullable|url',
                'panelists' => 'nullable|string',
                'is_live_streaming' => 'boolean',
                'live_streaming_event' => 'nullable|string',
                'is_coming_soon' => 'boolean',
                'display_order' => 'integer',
                'image' => 'nullable|url',
                'is_special' => 'boolean',
                'special_position' => 'nullable|required_if:is_special,1|in:above,below'
            ]);

            // Convert panelists textarea to array
            if (!empty($validated['panelists'])) {
                $panelists = array_filter(explode("\n", $validated['panelists']));
                $validated['panelists'] = array_map('trim', $panelists);
            } else {
                $validated['panelists'] = [];
            }

            // Handle special episode position
            if (!empty($validated['is_special']) && !empty($validated['special_position'])) {
                $validated['display_order'] = $this->calculateSpecialDisplayOrder(
                    $validated['type'],
                    $validated['episode_number'],
                    $validated['special_position']
                );
            }

            $podcast->update($validated);

            return redirect()->route('admin.podcasts.index')
                ->with('success', 'Podcast updated successfully.');

        } catch (\Exception $e) {
            \Log::error('Failed to update podcast', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withInput()
                ->with('error', 'Failed to update podcast: ' . $e->getMessage());
        }
    }

    public function destroy(Podcast $podcast)
    {
        if ($podcast->image) {
            Storage::disk('public')->delete($podcast->image);
        }
        
        $podcast->delete();

        return redirect()->route('admin.podcasts.index')
            ->with('success', 'Podcast deleted successfully.');
    }

    public function updateOrder(Request $request)
    {
        $validated = $request->validate([
            'podcasts' => 'required|array',
            'podcasts.*.id' => 'required|exists:podcasts,id',
            'podcasts.*.display_order' => 'required|integer'
        ]);

        foreach ($validated['podcasts'] as $podcastData) {
            Podcast::where('id', $podcastData['id'])
                ->update(['display_order' => $podcastData['display_order']]);
        }

        return response()->json(['message' => 'Order updated successfully']);
    }

    /**
     * Calculate display order for special episodes
     */
    private function calculateSpecialDisplayOrder($type, $episodeNumber, $position)
    {
        $baseEpisode = Podcast::where('type', $type)
            ->where('episode_number', $episodeNumber)
            ->where('is_special', false)
            ->first();

        if (!$baseEpisode) {
            return 0;
        }

        $order = $baseEpisode->display_order;
        return $position === 'above' ? $order - 1 : $order + 1;
    }
} 