@extends('layout')

@section('main')


<form action="{{ route('brand.save') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="image">

    <input type="text" name="name" placeholder="nombre">

    <input type="text" name="industry" placeholder="categoría">

    <input type="checkbox" name="status" value="1">
    
    <button type="submit">Guardar</button>
</form>

@endsection