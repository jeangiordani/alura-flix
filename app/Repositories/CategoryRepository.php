<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class CategoryRepository
{
    protected $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function getCategories(): JsonResponse
    {
        $data = $this->model->all();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    public function getCategoryById(int $id): JsonResponse
    {
        $data = $this->findById($id);

        if ($data != null) {
            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
        }

        return response()->json([
            'status' => 'success',
            'data' => 'No categories found'
        ], 200);
    }

    public function createCategory(array $data): JsonResponse
    {
        $validated = Validator::make($data, [
            'title' => 'required|string',
            'color' => 'required'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => 'fail',
                'errors' => $validated->errors()->messages()
            ], 422);
        }
        $data['title'] = strtoupper($data['title']);
        $category = $this->model->create($data);

        return response()->json([
            'status' => 'success',
            'data' => $category
        ], 201);
    }

    public function updateCategory(array $data, int $id)
    {
        $category = $this->findById($id);

        $validated = Validator::make($data, [
            'title' => 'required|string',
            'color' => 'required'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => 'fail',
                'errors' => $validated->errors()->messages()
            ], 422);
        }

        if ($category != null) {
            $data['title'] = strtoupper($data['title']);
            $category = $category->update($data);
            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => 'fail',
                'data' => 'Category not found'
            ], 404);
        }
    }

    public function destroyCategory(int $id): JsonResponse
    {
        $category = $this->findById($id);

        if ($category != null) {
            $category->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'The category was deleted successfully'
            ], 204);
        }

        return response()->json([
            'status' => 'fail',
            'data' => 'Category not found'
        ], 404);
    }


    private function findById($id)
    {
        return $this->model->find($id);
    }
}
