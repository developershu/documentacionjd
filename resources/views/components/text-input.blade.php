@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 

'border-fondo 
 dark:border-fondo
 dark:bg-gray-900 
 dark:text-gray-300 
 focus:border-white 
 dark:focus:border-white 
 focus:ring-fondo
 dark:focus:ring-fondo
 rounded-md shadow-sm'
 
 ]) !!}>
