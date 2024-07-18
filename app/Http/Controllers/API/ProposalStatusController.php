<?php

namespace App\Http\Controllers\API;

use App\{Http\Controllers\Controller, Http\Resources\ProposalStatusResource, Models\ProposalStatus};
use Illuminate\{
    Http\Request,
    Support\Carbon
};

class ProposalStatusController extends Controller
{

    public function list(Request $request): ProposalStatusResource
    {
        $search = $request->has('search') ? $request->get('search') : '';

        $list = ProposalStatus::select();

        if (!empty($search)) {
            $list = $list->where('status', '=', $search);
        }
        $list->orderBy('status', 'asc');
        $list = $list->get();

        return new ProposalStatusResource($list);
    }

}
