<?php

namespace App\Http\Controllers;

use App\Repositories\VideoRepository;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    protected $repository;

    public function __construct(VideoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getVideos()
    {
        return $this->repository->getVideos();
    }

    public function createVideo(Request $request)
    {
        return $this->repository->createVideo($request->all());
    }

    public function getVideo(int $id)
    {
        return $this->repository->getVideo($id);
    }

    public function updateVideo(Request $request, int $id)
    {
        return $this->repository->updateVideo($request->all(), $id);
    }

    public function destroyVideo(int $id)
    {
        return $this->repository->destroyVideo($id);
    }

    public function getVideosByCategory(int $id)
    {
        return $this->repository->getVideosByCategory($id);
    }

    public function searchVideos(string $search = '')
    {
        return $this->repository->searchVideos($search);
    }

    public function getFreeVideos()
    {
        return $this->repository->getFreeVideos();
    }
}
