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
use App\Http\Resources\CompanyCollection;
use App\Helpers\Portal\CompanyHelper;

//use App\Models\Shop;

class CompanyController extends Controller
{
    protected $companyHelper;

    public function __construct(CompanyHelper $companyHelper)
    {
        $this->companyHelper = $companyHelper;
    }

    public function show(\Illuminate\Http\Request $request, int $companyId)
    {
        try {
            $filters = $request->query();
            return new CompanyCollection($this->companyHelper->getBuilder([], $companyId));
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function index(\Illuminate\Http\Request $request)
    {
        try {
            $filters = $request->query();
            return new CompanyCollection($this->companyHelper->getBuilder($filters));
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}