@extends("layouts.app")

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Find Nearest Location List</h2>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <form class="align-items-center row" action="{{route('get_nearest_location')}}">
                                @csrf
                                <div class="col-auto">
                                    <label>Location List *(Upload valid JSON-encoded file)</label>
                                    <input type="file" name="location-list" class="form-control">
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary find-btn">Submit</button>
                                </div>
                            </form>
                        </div>
                        <div class="mb-4" id="location-table">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="{{asset('assets/js/custom.js')}}" crossorigin="anonymous"></script>
@endsection