@extends('layouts.base')

@section('body')
    <body>
        <div class="flex h-screen">
            <div class="m-auto">
                <div class="text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M18.364 5.636a9 9 0 010 12.728m0 0l-2.829-2.829m2.829 2.829L21 21M15.536 8.464a5 5 0 010 7.072m0 0l-2.829-2.829m-4.243 2.829a4.978 4.978 0 01-1.414-2.83m-1.414 5.658a9 9 0 01-2.167-9.238m7.824 2.167a1 1 0 111.414 1.414m-1.414-1.414L3 3m8.293 8.293l1.414 1.414"/>
                    </svg>
                    <h3 class="mt-2 text-xl font-medium text-gray-900">No internet connection</h3>
                    <p class="mt-1 text-gray-500">
                        Please check your network connection and try again.
                    </p>
                </div>
            </div>
        </div>
    </body>
@endsection
