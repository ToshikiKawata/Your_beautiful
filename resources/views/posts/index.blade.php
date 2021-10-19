@extends('layouts.main')

@section('title', '一覧画面')

@section('content')
@include('patial.flash')
    @include('patial.errors')
    <section class="row" data-masonry='{ "percentPosition": true }'>
        @foreach ($posts as $post)
            <div class="col-6 col-md-4 col-lg-3 col-sl-2 mb-4">
                <article class="card position-relative">
                    <img src="{{ $post->image_url }}" class="card-img-top">
                    <div class="card-title mx-3">
                        <a href="{{ route('posts.show', $post) }}" class="text-decoration-none stretched-link">
                            {{ $post->caption }}
                        </a>
                    </div>
                </article>
            </div>
        @endforeach
    </section>
    <a href="{{ route('posts.create') }}" class="position-fixed fs-1 bottom-0 end-0">
        <i class="fas fa-plus-circle"></i>
    </a>
@endsection
