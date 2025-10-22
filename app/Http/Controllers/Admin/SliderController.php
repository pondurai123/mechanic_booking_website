<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('order', 'asc')->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'media' => 'required|file|mimes:jpg,jpeg,png,gif,webp,mp4,webm,ogg|max:10240',
            'is_active' => 'boolean'
        ]);

        try {
            $mediaPath = $this->uploadMedia($request->file('media'), 'sliders');
            
            $slider = Slider::create([
                'title' => $request->title,
                'description' => $request->description,
                'media_path' => $mediaPath,
                'media_type' => strpos($request->file('media')->getMimeType(), 'video') !== false ? 'video' : 'image',
                'is_active' => $request->is_active ?? true,
                'order' => Slider::max('order') + 1
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Slider created successfully',
                'slider' => $slider->load('media_url')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create slider: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,mp4,webm,ogg|max:10240',
            'is_active' => 'boolean'
        ]);

        try {
            $slider = Slider::findOrFail($id);
            
            $data = [
                'title' => $request->title,
                'description' => $request->description,
                'is_active' => $request->is_active ?? $slider->is_active
            ];

            if ($request->hasFile('media')) {
                if ($slider->media_path) {
                    Storage::disk('public')->delete($slider->media_path);
                }
                
                $data['media_path'] = $this->uploadMedia($request->file('media'), 'sliders');
                $data['media_type'] = strpos($request->file('media')->getMimeType(), 'video') !== false ? 'video' : 'image';
            }

            $slider->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Slider updated successfully',
                'slider' => $slider->load('media_url')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update slider: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $slider = Slider::findOrFail($id);
            
            if ($slider->media_path) {
                Storage::disk('public')->delete($slider->media_path);
            }
            
            $slider->delete();

            return response()->json([
                'success' => true,
                'message' => 'Slider deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete slider: ' . $e->getMessage()
            ], 500);
        }
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'sliders' => 'required|array'
        ]);

        try {
            foreach ($request->sliders as $index => $sliderId) {
                Slider::where('id', $sliderId)->update(['order' => $index + 1]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Sliders reordered successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to reorder sliders: ' . $e->getMessage()
            ], 500);
        }
    }

    public function toggleStatus($id)
    {
        try {
            $slider = Slider::findOrFail($id);
            $slider->update(['is_active' => !$slider->is_active]);

            return response()->json([
                'success' => true,
                'message' => 'Slider status updated successfully',
                'is_active' => $slider->is_active
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update slider status: ' . $e->getMessage()
            ], 500);
        }
    }

    private function uploadMedia($file, $folder)
    {
        $extension = $file->getClientOriginalExtension();
        $fileName = Str::random(40) . '.' . $extension;
        $filePath = $file->storeAs($folder, $fileName, 'public');
        
        return $filePath;
    }

    public function uploadMediaEndpoint(Request $request)
    {
        $request->validate([
            'media' => 'required|file|mimes:jpg,jpeg,png,gif,webp,mp4,webm,ogg|max:10240'
        ]);

        try {
            $path = $this->uploadMedia($request->file('media'), 'sliders');
            
            return response()->json([
                'success' => true,
                'path' => $path,
                'url' => Storage::disk('public')->url($path),
                'type' => strpos($request->file('media')->getMimeType(), 'video') !== false ? 'video' : 'image'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }
}