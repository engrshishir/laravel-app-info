<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Info</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <!-- App Info Section -->
            <div class="col-12 mb-4">
                <h3>App Information</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Version</th>
                            <th>Environment</th>
                            <th>Local</th>
                            <th>Debug</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $envs['APP_NAME'] ?? '' }}</td>
                            <td>{{ $envs['APP_VERSION'] ?? '' }}</td>
                            <td>{{ $envs['APP_ENV'] ?? '' }}</td>
                            <td>{{ $envs['APP_LOCALE'] ?? '' }}</td>
                            <td>{{ $envs['APP_DEBUG'] ?? '' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Routes Section -->
            <div class="col-12 mb-4">
                <h3>Route Information</h3>
                <div class="row">
                    @foreach (['get', 'post', 'put', 'delete'] as $method)
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>{{ strtoupper($method) }} Routes</h4>
                                </div>
                                <div class="card-body">
                                    <ol>
                                        @forelse ($routes[$method] as $route)
                                            <li>
                                                <p>{{ $route['uri'] }} <span
                                                        class="badge badge-info">({{ $route['name'] }})</span> </p>
                                            </li>
                                        @empty
                                            <li>No {{ strtoupper($method) }} routes available.</li>
                                        @endforelse
                                    </ol>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Package Information Section -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Installed Packages</h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap">
                            @foreach ($packages as $package)
                                <p class="badge mr-2" style="background-color: {{ '#' . substr(md5(rand()), 0, 6) }};">
                                    {{ $package['name'] }}
                                    <strong>({{ $package['version'] }})</strong>
                                </p>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
