<?php

namespace App\Repositories;

use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class VideoRepository
{

    protected $model;

    public function __construct(Video $model)
    {
        $this->model = $model;
    }

    public function getVideos(): JsonResponse
    {
        $data =  $this->model->orderBy('category_id', "ASC")->simplePaginate(5);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    #TODO: create a trait to deal and separate the validations
    public function createVideo(array $data): JsonResponse
    {

        $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

        if (array_key_exists('category_id', $data)) {
            $validated = Validator::make($data, [
                'title' => 'required|min:3',
                'description' => 'required|min:3',
                'url' => 'required|regex:' . $regex,
                'category_id' => 'required|exists:categories,id'
            ]);
        } else {
            $validated = Validator::make($data, [
                'title' => 'required|min:3',
                'description' => 'required|min:3',
                'url' => 'required|regex:' . $regex,
            ]);
            $data = [
                'title' => $data['title'],
                'description' => $data['description'],
                'url' => $data['url'],
                'category_id' => 1
            ];
        }

        if ($validated->fails()) {
            return response()->json([
                'status' => 'fail',
                'errors' => $validated->errors()->messages()
            ], 422);
        }
        $video = $this->model->create($data);

        return response()->json([
            'status' => 'success',
            'data' => $video
        ]);
    }

    public function getVideo(int $id): JsonResponse
    {
        $video = $this->findById($id);

        if ($video != null) {
            return response()->json([
                'status' => 'success',
                'data' => $video
            ], 200);
        }

        return response()->json([
            'status' => 'fail',
            'message' => 'Video not found'
        ], 404);
    }

    public function updateVideo(array $data, int $id): JsonResponse
    {
        $video = $this->findById($id);

        $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

        $validated = Validator::make($data, [
            'title' => 'required|min:3',
            'description' => 'required|min:3',
            'url' => 'required|regex:' . $regex,
            'category_id' => 'required|exists:categories,id'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => 'fail',
                'errors' => $validated->errors()->messages()
            ], 422);
        }


        if ($video != null) {
            $video = $video->update($data);
            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
        }

        return response()->json([
            'status' => 'fail',
            'message' => 'Video not found'
        ], 404);
    }

    public function destroyVideo(int $id): JsonResponse
    {
        $video = $this->findById($id);

        if ($video != null) {
            $video->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Video deleted successfully'
            ]);
        }

        return response()->json([
            'status' => 'fail',
            'message' => 'Video not found'
        ], 404);
    }

    public function getVideosByCategory(int $id): JsonResponse
    {
        $data = $this->model->videosByCategory($id);

        if (!empty($data)) {
            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
        }

        return response()->json([
            'status' => 'fail',
            'message' => 'Videos not found'
        ], 404);
    }

    public function searchVideos(string $query): JsonResponse
    {
        $data = $this->model->where('title', 'like', "%{$query}%")->get()->toArray();

        if (!empty($data)) {
            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
        }

        return response()->json([
            'status' => 'fail',
            'message' => 'Videos not found'
        ], 404);
    }

    public function getFreeVideos(): JsonResponse
    {
        $data = $this->model->freeVideos();

        if (!empty($data)) {
            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
        }

        return response()->json([
            'status' => 'fail',
            'message' => 'Videos not found'
        ], 404);
    }

    private function findById(int $id): ?Video
    {
        return $this->model->find($id);
    }
}
