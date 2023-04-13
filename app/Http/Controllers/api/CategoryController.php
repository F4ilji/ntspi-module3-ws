<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'string|required|max:255',
        ]);
        $category = Category::create($data);
        return response(['category' => new CategoryResource($category), 'message' => 'success'], 201);
    }

    /**
     * Display the specified resource.
     */

}
