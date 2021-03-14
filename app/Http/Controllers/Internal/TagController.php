<?php

namespace App\Http\Controllers\Internal;

use App\Http\Resources\TagResource;
use App\Traits\Controller\SendsEmptyResponse;
use App\Http\Controllers\Controller;
use App\Http\Repositories\TagRepository;
use App\Http\Requests\Internal\Tag\AddTagFromInputRequest;
use Illuminate\Http\Request;

class TagController extends Controller
{
    use SendsEmptyResponse;

    private TagRepository $tags;

    public function __construct(TagRepository $tags)
    {
        $this->tags = $tags;
    }

    public function addTagFromInput(AddTagFromInputRequest $request)
    {
        $tag = $this->tags->createTagFromInputRequest($request);
        return response()
            ->json([
                'data' => new TagResource($tag)
            ]);
    }

    public function all(Request $request)
    {
        $tags = $this->tags->getAll();
        return response()->json([
            'data' => TagResource::collection($tags)
        ]);
    }
}
