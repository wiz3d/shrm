<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Portal\TagHelper;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Request as PostRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller;
use App\Http\Resources\TargetMarketCollection;
use App\Helpers\Portal\TargetMarketHelper;

//use App\Models\Shop;

class TargetMarketController extends Controller
{
    protected $targetMarketHelper;

    public function __construct(TargetMarketHelper $targetMarketHelper)
    {
        $this->targetMarketHelper = $targetMarketHelper;
    }

    public function show(\Illuminate\Http\Request $request, int $tagId)
    {
        try {
            $filters = $request->query();
            return new TargetMarketCollection($this->targetMarketHelper->getBuilder([], $tagId));
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function index(\Illuminate\Http\Request $request)
    {
        try {
            $filters = $request->query();
            $cacheKey = 'target-markets.index.' . md5(serialize($request->query()));
            return Cache::remember($cacheKey, 60*60, function () use ($filters) {
                return new TargetMarketCollection($this->targetMarketHelper->getBuilder($filters));
            });
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
