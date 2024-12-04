<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Articulos
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex gap-x-20">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div
                            class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table
                                class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Código
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Denominacion
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Precio
                                        </th>
                                        <th colspan="3" scope="col"
                                            class="px-6 py-3">
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($articulos as $articulo)
                                        <tr
                                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $articulo->codigo }}
                                            </th>
                                            <td class="px-6 py-4">
                                                <a href="{{ route('articulos.show', $articulo) }}"
                                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                                    {{ $articulo->denominacion }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $articulo->precio }}
                                            </td>
                                            <td class="px-6 py-4 flex items-center gap-2">
                                                <a href="{{ route('articulos.edit', $articulo) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                                    Editar
                                                </a>
                                                <form method="POST" action="{{ route('articulos.destroy', $articulo) }}">
                                                    @method('DELETE')
                                                    @csrf
                                                    <a href="{{ route('articulos.destroy', $articulo) }}"
                                                        class="font-medium text-red-600 dark:text-red-500 hover:underline ms-3"
                                                        onclick="event.preventDefault(); if (confirm('¿Está seguro?')) this.closest('form').submit();">
                                                        Eliminar
                                                    </a>
                                                </form>
                                                <a href="{{ route('carrito.meter', $articulo) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                                    Añadir
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-6 text-center">
                            <a href="{{ route('articulos.create') }}"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                Crear un nuevo articulo
                            </a>
                        </div>

                    </div>
                </div>

                @if (!$carrito->vacio())
                    <aside class="flex flex-col items-center w-1/4">
                        <div class="mx-auto overflow-y-auto py-4 px-3 bg-gray-50 rounded dark:bg-gray-800">
                            <table class="mx-auto text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <th scope="col" class="py-3 px-6">
                                        Denominación
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Cantidad
                                    </th>
                                </thead>
                                <tbody>
                                    @foreach ($carrito->getLineas() as $id => $linea)
                                        @php
                                            $articulo = $linea->getArticulo();
                                            $cantidad = $linea->getCantidad();
                                        @endphp
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <td class="py-4 px-6">
                                                {{ $articulo->denominacion }}
                                            </td>
                                            <td class="py-4 px-6 text-center">
                                                {{ $cantidad }}
                                                <a href="{{ route('carrito.sacar', $articulo) }}" class="inline-flex items-center py-1 px-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                    -
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="flex">
                            <a href="{{ route('carrito.vaciar') }}" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Vaciar carrito</a>
                            <form method="POST" action="{{ route('comprar') }}">
                                @csrf
                                <button type="submit" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-900">Comprar</button>
                            </form>
                        </div>
                    </aside>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>