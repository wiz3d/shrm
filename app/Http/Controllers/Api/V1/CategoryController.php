<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Request as PostRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller;
use App\Http\Resources\CategoryCollection;
use App\Helpers\Portal\CategoryHelper;

//use App\Models\Shop;

class CategoryController extends Controller
{
    protected $categoryHelper;

    public function __construct(CategoryHelper $categoryHelper)
    {
        $this->categoryHelper = $categoryHelper;
    }

    public function show(\Illuminate\Http\Request $request, int $categoryId)
    {
        try {
            $filters = $request->query();
            return new CategoryCollection($this->categoryHelper->getBuilder([], $categoryId));
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function index(\Illuminate\Http\Request $request)
    {
        try {
            $filters = $request->query();
            return new CategoryCollection($this->categoryHelper->getBuilder($filters));
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
