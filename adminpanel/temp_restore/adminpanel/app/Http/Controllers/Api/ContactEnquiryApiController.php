<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactEnquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactEnquiryApiController extends Controller
{
    /**
     * Store a newly created enquiry in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|max:255',
            'telephone' => 'required|digits:10',
            'message'   => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            $enquiry = ContactEnquiry::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'telephone' => $request->telephone,
                'message'   => $request->message,
                'status'    => 'pending',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Enquiry submitted successfully!',
                'data'    => $enquiry
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit enquiry: ' . $e->getMessage()
            ], 500);
        }
    }
}
