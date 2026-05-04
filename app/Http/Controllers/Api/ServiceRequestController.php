<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use App\Http\Resources\ServiceRequestResource;
use App\Http\Resources\ServiceRequestDetailResource;

class ServiceRequestController extends Controller
{
    public function getServiceRequest()
    {
        $serviceRequests = ServiceRequest::where('expert_id', auth()->id())
            ->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
            ->with('service', 'user')
            ->get();
        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => $serviceRequests->isEmpty()
                ? 'No service requests found'
                : 'Service requests fetched successfully',
            'data' => ServiceRequestResource::collection($serviceRequests)
        ]);
    }

    public function show($id)
    {
        $request = ServiceRequest::with(['service', 'user'])
            ->find($id);

        if (!$request) {
            return response()->json([
                'code' => 422,
                'status' => false,
                'message' => 'Service request not found',
                'data' => (object)[]
            ]);
        }

        if ( $request->expert_id !== auth()->id()) {
            return response()->json([
                'code' => 422,
                'status' => false,
                'message' => 'Unauthorized access',
                'data' => (object)[]
            ]);
        }

        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => 'Service request details fetched successfully',
            'data' => new ServiceRequestDetailResource($request)
        ]);
    }
}
