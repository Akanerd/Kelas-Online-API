<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function getall()
    {
        return CategoryResource::collection(Category::all());
    }
}
