<?php


namespace App\Http\Controllers;


use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CompaniesController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'companies' => Company::byUser()->get(),
        ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
           'title' => 'required|string',
           'phone' => 'required',
           'description' => 'required'
        ]);

        Auth::user()->companies()->create(
            $request->only('title', 'description', 'phone')
        );

        return response()->json([
            'message' => 'New company has been created'
        ], Response::HTTP_CREATED);
    }
}
