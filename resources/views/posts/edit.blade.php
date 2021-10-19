@extends('layouts.main')
@section('title', '新規登録')
@section('content')
    @include('patial.flash')
    @include('patial.errors')
    <section>
        <article class="card shadow">
            <figure class="m-3">
                <div class="row">
                    <div class="col-6">
                        <img src="{{ $post->image_url }}" width="100%">
                    </div>
                    <div class="col-6">
                        <figcaption>
                            <form action="{{ route('posts.update', $post) }}" method="post" id="form">
                                @csrf
                                @method('patch')
                                <div class="mb-3">
                                    <label for="caption" class="form-label">イメージの説明を入力してください</label>
                                    <input type="text" name="caption" id="caption" class="form-control"
                                        value="{{ old('caption', $post->caption) }}">
                                </div>
                                <div>
                                    <label for="info" class="form-label">その他情報を入力してください</label>
                                    <textarea name="info" id="info" rows="5"
                                        class="form-control">{{ old('info', $post->info) }}</textarea>
                                </div>
                            </form>
                        </figcaption>
                    </div>
                </div>
            </figure>
        </article>
        <div class="d-grid gap-3 col-6 mx-auto">
            <input type="submit" value="更新" form="form" class="btn btn-success btn-lg">
            <a href="{{ route('posts.index') }}" class="btn btn-secondary btn-lg">戻る</a>
        </div>
    </section>
@endsection
