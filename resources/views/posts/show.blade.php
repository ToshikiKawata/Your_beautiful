@extends('layouts.main')
@section('title', '詳細画面')
@section('content')
    @include('patial.flash')
    @include('patial.errors')
    <section>
        <article class="card shadow position-relative">
            <figure class="m-3">
                <div class="row">
                    <div class="col-6">
                        <img src="{{ $post->image_url }}" width="100%">
                    </div>
                    <div class="col-6">
                        <figcaption>
                            <h1>
                                {{ $post->caption }}
                            </h1>
                            <h3>
                                {{ $post->info }}
                            </h3>
                        </figcaption>
                    </div>
                </div>
            </figure>
            @can('update', $post)
                <a href="{{ route('posts.edit', $post) }}">
                    <i class="fas fa-edit position-absolute top-0 end-0 fs-1"></i>
                </a>
            @endcan
        </article>
        <div class="d-grid gap-3 col-6 mx-auto">
            @can('delete', $post)
                <form action="{{ route('posts.destroy', $post) }}" method="post" id="form">
                    @csrf
                    @method('DELETE')
                </form>
                <input form="form" type="submit" value="削除" onclick="if(!confirm('削除していいですか')){return false}"
                    class="btn btn-danger btn-lg">
            @endcan
            <a href="{{ route('posts.index') }}" class="btn btn-secondary btn-lg">戻る</a>
        </div>
    </section>
@endsection
