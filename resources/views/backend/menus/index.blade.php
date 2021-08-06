@extends('backend.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="float-left">
                <strong> Contents </strong>
            </div>

            <div class="btn-group btn-group-sm float-right">
                @include('backend.menus.includes.header-buttons')
            </div>
        </div>
        <div class="card-body">
            <div class="row mt-4">
                <div class="col">
                    @if ($menus == [])
                        <div class="well text-center">No records</div>
                    @else
                        @include('backend.menus.index-table')
                    @endif
                </div>
            </div> <!-- .box -->

        </div>
    </div>
@endsection
@section('jquery-datatable')
    @include('backend.menus.includes.datatable')
@endsection
