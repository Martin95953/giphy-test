<?php

namespace App\Http\Controllers\api;

use App\ExternalServices\GiphyExternalService;
use App\Http\Controllers\Controller;
use App\Http\Requests\GifRequests\SaveGifToFavoritesRequest;
use App\Http\Requests\GifRequests\SearchGifRequest;
use App\Models\Gif;
use Illuminate\Http\JsonResponse;

class GifController extends Controller
{
    public function search(SearchGifRequest $request): JsonResponse
    {
        $query = $request->input('query');
        $limit = $request->limit;
        $offset = $request->offset;

        $giphy = new GiphyExternalService();
        $response = $giphy->search($query, $limit, $offset);
        return response()->json($response);
    }

    public function show($gif_id): \Illuminate\Http\JsonResponse
    {
        $giphy = new GiphyExternalService();
        $response = $giphy->getById($gif_id);

        return response()->json($response);
    }

    public function saveGifToFavorites(SaveGifToFavoritesRequest $request): JsonResponse
    {
        $gif = new Gif();
        $gif->gif_id = $request->gif_id;
        $gif->alias = $request->alias;
        $gif->user_id = $request->user_id;
        $gif->save();

        return response()->json(['message' => 'Gif saved to favorites']);
    }
}
