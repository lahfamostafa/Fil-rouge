

@if(auth()->user()->role == 'manager')

    <form action="/terrains" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow">
        @csrf
        <input type="text" name="name" placeholder="Nom" class="border p-2 w-full mb-2">
        <input type="text" name="location" placeholder="Localisation" class="border p-2 w-full mb-2">
        <input type="number" step="any" name="latitude" placeholder="Latitude" class="border p-2 w-full mb-2">
        <input type="number" step="any" name="longitude" placeholder="Longitude" class="border p-2 w-full mb-2">
        <input type="number" name="price" placeholder="Prix" class="border p-2 w-full mb-2">
        <input type="time" name="opening_time" class="border p-2 w-full mb-2">
        <input type="time" name="closing_time" class="border p-2 w-full mb-2">
        <input type="file" name="image" class="border p-2 w-full mb-2">
        <button class="bg-blue-500 text-white px-4 py-2 rounded">
            Ajouter
        </button>
    </form>

@endif
@extends('layouts.app')