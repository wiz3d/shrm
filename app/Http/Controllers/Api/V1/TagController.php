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
use App\Http\Resources\TagCollection;
use App\Helpers\Portal\TagHelper;

//use App\Models\Shop;

class TagController extends Controller
{
    protected $tagHelper;

    public function __construct(TagHelper $tagHelper)
    {
        $this->tagHelper = $tagHelper;
    }

    public function show(\Illuminate\Http\Request $request, int $tagId)
    {
        try {
            $filters = $request->query();
            return new TagCollection($this->tagHelper->getBuilder([], $tagId));
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function index(\Illuminate\Http\Request $request)
    {
        try {
            $filters = $request->query();
            return new TagCollection($this->tagHelper->getBuilder($filters));
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
