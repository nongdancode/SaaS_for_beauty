<?php

namespace App\Http\Controllers;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;



use Tymon\JWTAuth\JWTAuth;
use App\Task;
use App\user;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $user;

    /**
     * TaskController constructor.
     */
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function index()
    {
        $tasks = $this->user->tasks()->get(['title', 'description'])->toArray();

        return $tasks;
    }
}
