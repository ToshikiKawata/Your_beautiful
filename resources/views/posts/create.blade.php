@extends('layouts.main')
@section('title', '新規登録')
@section('content')
    @include('patial.flash')
    @include('patial.errors')
    <div class="col-8 col-offset-2 mx-auto">
        <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
            <div class="card mb-3">
                @csrf
                <div class="row m-3">
                    <div class="mb-3">
                        <label for="file" class="form-label">画像ファイルを選択してください</label>
                        <input type="file" name="file[]" id="file" class="form-control" multiple="multiple">
                    </div>
                    <div class="mb-3">
                        <label for="caption" class="form-label">イメージの説明を入力してください</label>
                        <input type="text" name="caption" id="caption" class="form-control">
                    </div>
                    <div>
                        <label for="info" class="form-label">イメージの説明を入力してください</label>
                        <textarea name="info" id="info" rows="5" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    投稿
                </button>
        </form>
    </div>
@endsection
