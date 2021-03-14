<?php


namespace App\Http\Repositories;


use App\Http\Requests\Internal\Tag\AddTagFromInputRequest;
use App\Models\Tag;
use Illuminate\Support\Collection;

class TagRepository
{
    public function getAll(): Collection
    {
        return Tag::all();
    }

    public function createTagFromInputRequest(AddTagFromInputRequest $request): Tag
    {
        return $this->createTag([
            'name' => $request->input('name')
        ]);
    }

    public function createTag(array $data): Tag
    {
        return Tag::create([
            'name' => $data['name']
        ]);
    }
}
