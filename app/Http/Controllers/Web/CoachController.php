<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Coach;

class CoachController extends Controller
{
    public function index()
    {
        return view('coaches.index', [
            'coaches' => Coach::all(),
        ]);
    }
    public function get_data_table()
    {
        return datatables()->eloquent(Coach::query())->toJson();
    }
    public function show(Coach $coach)
    {
        return view('coaches.show', [
            'coach' =>$coach,
        ]);
    }

    public function edit(Coach $coach)
    {
        return view('posts.edit', $coach);
    }

    public function update(Post $post, EditPostRequest $request)
    {
        Post::find($post['id'])->update(['title' => $request->all()['title'],
            'description' => $request->all()['description'],
            'user_id' => $request->all()['user_id'], ]);
        return redirect()->route('posts.index');
    }

    public function destroy(Coach $coach)
    {
        $coach->delete();
        return redirect()->route('coaches.index');
    }

    public function create()
    {
        return view('coaches.create');
    }
}
