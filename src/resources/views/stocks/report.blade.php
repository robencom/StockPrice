@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4">Stock Report</h1>
        <div class="d-flex justify-content-center">
            <table class="table table-bordered w-75">
                <thead class="thead-light">
                <tr>
                    <th scope="col">Symbol</th>
                    <th scope="col">Price</th>
                    <th scope="col">Previous Price</th>
                    <th scope="col">Change</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($stocks as $stock)
                    <tr>
                        <td>{{ $stock['symbol'] }}</td>
                        <td>{{ $stock['price'] }}</td>
                        <td>{{ $stock['previous_price'] }}</td>
                        <td>
                            @if ($stock['percentage_change'] > 0)
                                <span class="text-success">
                                <i class="fas fa-arrow-up"></i> {{ number_format($stock['percentage_change'], 2) }}%
                            </span>
                            @elseif ($stock['percentage_change'] < 0)
                                <span class="text-danger">
                                <i class="fas fa-arrow-down"></i> {{ number_format($stock['percentage_change'], 2) }}%
                            </span>
                            @else
                                <span class="text-secondary">
                                0%
                            </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
