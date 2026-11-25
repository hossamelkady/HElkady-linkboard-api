<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Link;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Link::query()->latest()->paginate(15));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'slug' => 'required|string|alpha_dash|max:80|unique:links,slug',
            'label' => 'required|string|max:160',
            'target_url' => 'required|url:http,https|max:2048',
            'clicks' => 'sometimes|integer|min:0',
            'is_active' => 'sometimes|boolean'
        ]);

        $record = Link::create($data);
        return response()->json(['data' => $record], 201);
    }

    public function show(Link $link): JsonResponse
    {
        return response()->json(['data' => $link]);
    }

    public function update(Request $request, Link $link): JsonResponse
    {
        $data = $request->validate(['slug' => ['sometimes', 'string', 'alpha_dash', 'max:80', \Illuminate\Validation\Rule::unique('links', 'slug')->ignore($link->id)], 'label' => 'sometimes|string|max:160', 'target_url' => 'sometimes|url:http,https|max:2048', 'clicks' => 'sometimes|integer|min:0', 'is_active' => 'sometimes|boolean']);
        $link->update($data);
        return response()->json(['data' => $link->refresh()]);
    }

    public function destroy(Link $link): JsonResponse
    {
        $link->delete();
        return response()->json([], 204);
    }
}
