@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Importador de Excel</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                            {{session()->forget('status')}}
                        @else
                        @if($errors->any())
                            <div class="alert alert-danger" role="alert">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{route('import')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">
                                            <Archivo></Archivo>
                                        </label>
                                        <input type="file" accept=".xlsx" name="file" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Processar</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
