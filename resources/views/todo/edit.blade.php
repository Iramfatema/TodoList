@extends('Layouts.app')

@section('content')
<div class="container my-4">
            <div class="panel panel-default">
                <div class="panel-heading" style="font-size:25px">Edit Note</div>
                <br>
                <div class="panel-body">
                    <form method="post" enctype="multipart/form-data" action="{{route('todo.update',[$todoArr->id])}}">
                    @csrf
                        <div class="col-lg-3 col-md-12 col-sm-12">
                        <label for="desc" class="form-label"> Note Description:</label><br>
                        <input type="text" class="form-control" id="desc" name="desc" value="{{$todoArr->description}}">
                        </div>
                        <br>
                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit" id="create" name="create" data-inline="true">Update</button> 
                        <a href="/home"><button class="btn btn-primary" type="button" id="back" name="back" data-inline="true">Back</button></a> 
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection