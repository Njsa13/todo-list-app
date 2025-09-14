<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Task;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Yajra\Datatables\Facades\Datatables;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'title' => 'required|min:3'
            ]);

            Task::create([
                'title' => $request->title
            ]);

            return response()->json([
                'message' => 'Task successfully created'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTasks()
    {
        try {
            $task = Task::select(['id', 'created_at', 'title', 'is_done']);
            return Datatables::of($task)->make(true);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'title' => 'required|min:3'
            ]);

            if (empty($id))
                return response()->json([
                    'error' => 'Id required'
                ], 400);

            $task = Task::findOrFail($id);
            $task->title = $request->title;
            $task->save();

            return response()->json([
                'message' => 'Task successfully updated'
            ], 200);
        } catch (Exception $e) {
            if ($e instanceof ModelNotFoundException)
                return response()->json([
                    'error' => 'Task not found'
                ], 404);

            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus($id)
    {
        try {
            if (empty($id))
                return response()->json([
                    'error' => 'id required'
                ], 400);

            $task = Task::findOrFail($id);
            $task->is_done = !$task->is_done;
            $task->save();

            return response()->json([
                'message' => 'Task status successfully changed'
            ], 200);
        } catch (Exception $e) {
            if ($e instanceof ModelNotFoundException)
                return response()->json([
                    'error' => 'Task not found'
                ], 404);

            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            if (empty($id))
                return response()->json([
                    'error' => 'Id required'
                ], 400);
            Task::findOrFail($id)->delete();

            return response()->json([
                'message' => 'Task successfully deleted'
            ], 200);
        } catch (Exception $e) {
            if ($e instanceof ModelNotFoundException)
                return response()->json([
                    'error' => 'Task not found'
                ], 404);

            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
