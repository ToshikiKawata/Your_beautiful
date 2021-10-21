<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PostRequest;


class postController extends Controller
{
    public function __construct()
    {
        // アクションに合わせたpolicyのメソッドで認可されていないユーザーはエラーを投げる
        $this->authorizeResource(Post::class, 'post');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request, Post $post)
    {
        // postのデータを用意
        $post = new post();
        $post->fill($request->all());
        // ユーザーIDを追加
        $post->user_id = $request->user()->id;
        // ファイルの用意
        $files = $request->file;

        // トランザクション開始
        DB::beginTransaction();
        try {
            // post保存
            $post->save();

            foreach ($files as $file) {
                // 画像ファイル保存
                $path = Storage::putFile('posts', $file);
                // imageモデルの情報を用意
                $image = new Image([
                    'post_id' => $post->id,
                    'org_name' => $file->getClientOriginalName(),
                    'name' => basename($path)
                ]);
                // image保存
                $image->save();
            }
            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            foreach ($files as $file) {
                if (!empty($path)) {
                    Storage::delete($path);
                }
            }
            // トランザクション終了(失敗)
            DB::rollback();
            back()->withErrors(['error' => '保存に失敗しました']);
        }
        return redirect(route('posts.index'))->with(['flash_message' => '登録が完了しました']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        // postのデータを更新
        $post->fill($request->all());
        // トランザクション開始
        DB::beginTransaction();
        try {
            // post保存
            $post->save();
            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
            DB::rollback();
            back()->withErrors(['error' => '保存に失敗しました']);
        }
        return redirect(route('posts.index'))->with(['flash_message' => '更新が完了しました']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $images = $post->images;
        $post->delete();

        foreach ($images as $image) {
            Storage::delete('posts/' . $image->name);
        }
        return redirect()
            ->route('posts.index')
            ->with(['flash_message' => '削除しました']);
    }
}
