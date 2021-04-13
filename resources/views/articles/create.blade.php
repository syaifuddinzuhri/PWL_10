@extends('layouts.app')

@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col">
                    <form>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter title">
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea class="form-control" id="content" name="content" rows="3"
                                placeholder="Enter content"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="custom-file-label" for="image">Feature Image</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image">
                                <label class="custom-file-label" for="image">Choose file</label>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit"></button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
