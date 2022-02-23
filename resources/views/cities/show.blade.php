@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($city->name) ? $city->name : 'City' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('cities.city.destroy', $city->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('cities.city.index') }}" class="btn btn-primary" title="Show All City">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('cities.city.create') }}" class="btn btn-success" title="Create New City">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('cities.city.edit', $city->id ) }}" class="btn btn-primary" title="Edit City">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete City" onclick="return confirm(&quot;Click Ok to delete City.?&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd>{{ $city->name }}</dd>
            <dt>Country</dt>
            <dd>{{ optional($city->country)->name }}</dd>
            <dt>State</dt>
            <dd>{{ optional($city->state)->name }}</dd>
            <dt>Status</dt>
            <dd>{{ $city->status }}</dd>

        </dl>

    </div>
</div>

@endsection