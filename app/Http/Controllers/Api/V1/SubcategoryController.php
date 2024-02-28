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
use App\Http\Resources\SubcategoryCollection;
use App\Helpers\Portal\SubcategoryHelper;

//use App\Models\Shop;

class SubcategoryController extends Controller
{
    protected $subcategoryHelper;

    public function __construct(SubcategoryHelper $subcategoryHelper)
    {
        $this->subcategoryHelper = $subcategoryHelper;
    }

    public function show(\Illuminate\Http\Request $request, int $subcategoryId)
    {
        try {
            $filters = $request->query();

            $cacheKey = 'subcategories.show:' . $subcategoryId;
            return Cache::remember($cacheKey, 60*60, function () use ($subcategoryId) {
                return new SubcategoryCollection($this->subcategoryHelper->getBuilder([], $subcategoryId));
            });
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function index(\Illuminate\Http\Request $request)
    {
        try {
            $filters = $request->query();
            $cacheKey = 'subcategories.index.' . md5(serialize($request->query()));
            return Cache::remember($cacheKey, 60*60, function () use ($filters) {
                return new SubcategoryCollection($this->subcategoryHelper->getBuilder($filters));
            });
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
