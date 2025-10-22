<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('order', 'asc')->get();
        return view('admin.services.index', compact('services'));
    }

    public function store(Request $request)
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
            $mediaPath = $this->uploadMedia($request->file('media'), 'services');
            
            $service = Service::create([
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                'details' => $request->details,
                'features' => json_encode($request->features),
                'media_path' => $mediaPath,
                'media_type' => strpos($request->file('media')->getMimeType(), 'video') !== false ? 'video' : 'image',
                'is_active' => $request->is_active ?? true,
                'order' => Service::max('order') + 1
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Service created successfully',
                'service' => $service->load('media_url')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create service: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
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

            if ($request->hasFile('media')) {
                if ($service->media_path) {
                    Storage::disk('public')->delete($service->media_path);
                }
                
                $data['media_path'] = $this->uploadMedia($request->file('media'), 'services');
                $data['media_type'] = strpos($request->file('media')->getMimeType(), 'video') !== false ? 'video' : 'image';
            }

            $service->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Service updated successfully',
                'service' => $service->load('media_url')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update service: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $service = Service::findOrFail($id);
            
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

    public function reorder(Request $request)
    {
        $request->validate([
            'services' => 'required|array'
        ]);

        try {
            foreach ($request->services as $index => $serviceId) {
                Service::where('id', $serviceId)->update(['order' => $index + 1]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Services reordered successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to reorder services: ' . $e->getMessage()
            ], 500);
        }
    }

    public function toggleStatus($id)
    {
        try {
            $service = Service::findOrFail($id);
            $service->update(['is_active' => !$service->is_active]);

            return response()->json([
                'success' => true,
                'message' => 'Service status updated successfully',
                'is_active' => $service->is_active
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update service status: ' . $e->getMessage()
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
}