<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getCategories()
    {
        return $this->repository->getCategories();
    }

    public function getCategory($id)
    {
        return $this->repository->getCategoryById($id);
    }

    public function createCategory(Request $request)
    {
        return $this->repository->createCategory($request->all());
    }

    public function updateCategory(Request $request, int $id)
    {
        return $this->repository->updateCategory($request->all(), $id);
    }

    public function destroyCategory(int $id)
    {
        return $this->repository->destroyCategory($id);
    }
}
