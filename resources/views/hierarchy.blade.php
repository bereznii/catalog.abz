@extends('layouts.app')

@section('content')
<div class="container col-md-12">
    <ul class="list-group list-group-flush">
        <li class="list-group-item" id="{{$president->id}}" opened="no"><i class="fas fa-plus"></i>{{$president->position}} | {{$president->name}}
        </li>
    </ul>
</div>
<script src='/js/hierarchy.js'></script>
@endsection