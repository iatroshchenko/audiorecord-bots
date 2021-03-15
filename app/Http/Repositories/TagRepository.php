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

    public function getMultipleByUuid(array $uuids): Collection
    {
        return Tag::whereIn('uuid', $uuids)->get();
    }

    public function getByUuid(string $uuid): ?Tag
    {
        $tag = $this->findByUuid($uuid);
        if (!$tag) throw new \DomainException('Tag not found with uuid: ' . $uuid);
        return $tag;
    }

    public function findByUuid(string $uuid): ?Tag
    {
        $tag = Tag::whereUuid($uuid)->first();
        return $tag;
    }
}
