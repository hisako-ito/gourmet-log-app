@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-none border-b-2 border-gray-400 focus:border-blue-500 focus:outline-none bg-transparent w-full']) !!}>