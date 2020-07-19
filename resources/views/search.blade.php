<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>{{ env('APP_NAME') }}</title>
</head>
<body>
    <div class="container mt-3">
        <div class="row align-items-center justify-content-center">
            <div class="col align-self-center">
                <div class="card">
                    <div class="card-body">
                        <h1>{{ env('APP_NAME') }}</h1>
                        @if (isset($alert))
                        <div class="alert alert-{{ $alert['type'] }}" role="alert">
                            {{ $alert['message'] }}
                        </div>
                        @endif
                        <form method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group @error('search') text-danger @enderror">
                                <label for="field-search">Search</label>
                                <input type="text" class="form-control" id="field-search" name="search" value="{{ $input['search'] ?? old('search') }}" required>
                                @error('search') <small>{{ $message }}</small> @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <input class="btn btn-secondary" type="reset" value="Reset">
                            <a href="/" class="btn btn-danger" role="button">Cancel</a>
                        </form>
                    </div>
                </div>
                @if (isset($words))
                <div class="row align-items-center justify-content-center mt-3">
                    <div class="col align-self-center">
                        <div class="card">
                            <div class="card-body">
                                <h2>Most used words</h2>
                                <ol>
                                    @foreach ($words as $word => $count)
                                    <li>{{ $word }} ({{ $count }})</li>
                                    @endforeach
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if (isset($results))
                <div class="row align-items-center justify-content-center mt-3">
                    <div class="col align-self-center">
                        <div class="card">
                            <div class="card-body">
                                <h2>Results</h2>
                                <div class="row align-items-center justify-content-center">
                                    @foreach ($results as $item)
                                    <div class="col-md-3 align-self-center mb-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="img-thumbnail">
                                                <h4>{{ $loop->index + 1 }}) {{ Str::limit($item['title'], 20) }} ~{{ $item['minutes'] }}min</h4>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
