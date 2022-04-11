@extends('layouts.app')

@section('title', "Novo Comentário Para o Usuário {$user->name}")

@section('content')
<h1 class="text-2xl font-semibold leading-tigh py-2">
    Novo Comentário Para o Usuário {{ $user->name }}
</h1>

@include('includes.validations-form')

<form action="{{ route('comments.store', $user->id) }}" method="post" enctype="multipart/form-data">
      @include('comments.__partials.form')
</form>

@endsection