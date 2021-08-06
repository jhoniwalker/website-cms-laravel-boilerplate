@extends('backend.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="float-left">
                <strong> Posts </strong>
            </div>

            <div class="btn-group btn-group-sm float-right">
                @include('backend.posts.includes.header-buttons')
            </div>
        </div>
        <div class="card-body">
            <div class="row mt-4">
                <div class="col">
                    @include('backend.posts.includes.modal-filter')
                </div>
            </div>
            <div class="row mt-4">
                <div class="col">
                    @if ($posts->isEmpty())
                        <div class="well text-center">No records</div>
                    @else
                        @include('backend.posts.index-table')
                        {{ $posts->links('backend.includes.pagination') }}
                    @endif
                </div>
            </div> <!-- .box -->

        </div>
    </div>
@endsection
