<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContentManagementController extends Controller
{
    public function index()
    {
        return view('admin.content-management');
    }

    // Slider Methods
    public function getSliders()
    {
        $sliders = Slider::orderBy('order', 'asc')->get();
        return response()->json($sliders);
    }

    public function storeSlider(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'media' => 'required|file|mimes:jpg,jpeg,png,gif,webp,mp4,webm,ogg|max:10240', // 10MB
            'is_active' => 'boolean'
        ]);

        try {
            // Handle file upload
            $mediaPath = $this->uploadMedia($request->file('media'), 'sliders');
            
            $slider = Slider::create([
                'title' => $request->title,
                'description' => $request->description,
                'media_path' => $mediaPath,
                'media_type' => $request->file('media')->getMimeType(),
                'is_active' => $request->is_active ?? true,
                'order' => Slider::max('order') + 1
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Slider created successfully',
                'slider' => $slider
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create slider: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateSlider(Request $request, $id)
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

            // Update media if new file is provided
            if ($request->hasFile('media')) {
                // Delete old media
                if ($slider->media_path) {
                    Storage::disk('public')->delete($slider->media_path);
                }
                
                $data['media_path'] = $this->uploadMedia($request->file('media'), 'sliders');
                $data['media_type'] = $request->file('media')->getMimeType();
            }

            $slider->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Slider updated successfully',
                'slider' => $slider
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update slider: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteSlider($id)
    {
        try {
            $slider = Slider::findOrFail($id);
            
            // Delete media file
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

    // Service Methods
    public function getServices()
    {
        $services = Service::orderBy('order', 'asc')->get();
        return response()->json($services);
    }

    public function storeService(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|string|max:100',
            'details' => 'required|string',
            'features' => 'required|array',
            'media' => 'required|file|mimes:jpg,jpeg,png,gif,webp,mp4,webm,ogg|max:10240',
            'is_active' => 'boolean'
        ]);

        try {
            // Handle file upload
            $mediaPath = $this->uploadMedia($request->file('media'), 'services');
            
            $service = Service::create([
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                'details' => $request->details,
                'features' => json_encode($request->features),
                'media_path' => $mediaPath,
                'media_type' => $request->file('media')->getMimeType(),
                'is_active' => $request->is_active ?? true,
                'order' => Service::max('order') + 1
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Service created successfully',
                'service' => $service
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create service: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateService(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|string|max:100',
            'details' => 'required|string',
            'features' => 'required|array',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,mp4,webm,ogg|max:10240',
            'is_active' => 'boolean'
        ]);

        try {
            $service = Service::findOrFail($id);
            
            $data = [
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                'details' => $request->details,
                'features' => json_encode($request->features),
                'is_active' => $request->is_active ?? $service->is_active
            ];

            // Update media if new file is provided
            if ($request->hasFile('media')) {
                // Delete old media
                if ($service->media_path) {
                    Storage::disk('public')->delete($service->media_path);
                }
                
                $data['media_path'] = $this->uploadMedia($request->file('media'), 'services');
                $data['media_type'] = $request->file('media')->getMimeType();
            }

            $service->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Service updated successfully',
                'service' => $service
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update service: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteService($id)
    {
        try {
            $service = Service::findOrFail($id);
            
            // Delete media file
            if ($service->media_path) {
                Storage::disk('public')->delete($service->media_path);
            }
            
            $service->delete();

            return response()->json([
                'success' => true,
                'message' => 'Service deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete service: ' . $e->getMessage()
            ], 500);
        }
    }

    // Media Upload Helper
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
            'media' => 'required|file|mimes:jpg,jpeg,png,gif,webp,mp4,webm,ogg|max:10240',
            'type' => 'required|in:slider,service'
        ]);

        try {
            $folder = $request->type === 'slider' ? 'sliders' : 'services';
            $path = $this->uploadMedia($request->file('media'), $folder);
            
            return response()->json([
                'success' => true,
                'path' => $path,
                'url' => Storage::disk('public')->url($path),
                'type' => $request->file('media')->getMimeType()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }
}