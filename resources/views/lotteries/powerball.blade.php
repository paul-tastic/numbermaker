@extends('layouts.app')

@section('content')
<style>
    .min-height{
        min-height: 200px;
    }
    .results-div {
        max-height: 500px;
        overflow-y: auto;
    }
    .section-div {
        border: 1px solid gray;
        border-radius: 2%;
        margin: 8px;
        padding: 3px;
    }
</style>
<div class="container">
    <div class="row">

        <p>There have been {{ $stats['numberOfDrawings'] }} drawings, and only {{ $stats['numberOfZonePatterns'] }} patterns.</p>
    </div>
    <div class="row">
        <div class="col-md-5 min-height section-div" id="top-numbers">top numbers</div>
        <div class="col-md-5 min-height section-div" id="top-stats">top stats</div>
    </div>
    <div class="row">
        <div class="col-md-7 results-div section-div" id="results-div">
            <table class="table table-sm" id="powerball-results-table">
                <thead>
                  <tr>
                    <th scope="col">Draw Date</th>
                    <th scope="col">B1</th>
                    <th scope="col">B2</th>
                    <th scope="col">B3</th>
                    <th scope="col">B4</th>
                    <th scope="col">B5</th>
                    <th scope="col">PB</th>
                    <th scope="col">Zone</th>
                  </tr>
                </thead>
                <tbody>
                    @forelse($results as $result)
                    
                    <tr>
                        <th scope="row">{{ $result->draw_date }}</th>
                        <td>{{ $result->b1 }}</td>
                        <td>{{ $result->b2 }}</td>
                        <td>{{ $result->b3 }}</td>
                        <td>{{ $result->b4 }}</td>
                        <td>{{ $result->b5 }}</td>
                        <td>{{ $result->powerball }}</td>
                        <td>{{ $result->zoned }}</td>
                    </tr>
                    @empty 
                        <tr>
                            <td colspan="7">No results found</td>
                        </tr>
                    @endforelse
                </tbody>
              </table>
        </div>
        <div class="col-md-2 results-div section-div">
            <table class="table table-sm" id="powerball-ranking-table">
                <thead>
                  <tr>
                    <th scope="col">Ball Number</th>
                    <th scope="col">Times Drawn</th>
                  </tr>
                </thead>
                <tbody>
                    @forelse($ranked['numbers'] as $key => $value)
                    <tr>
                        <th scope="row">{{ $key }}</th>
                        <td>{{ $value }}</td>
                    </tr>
                    @empty 
                        <tr>
                            <td colspan="7">No results found</td>
                        </tr>
                    @endforelse
                </tbody>
              </table>
        </div>
        <div class="col-md-2 results-div section-div">
              <table class="table table-sm" id="powerball-zone-ranking-table">
                <thead>
                  <tr>
                    <th scope="col">Zone</th>
                    <th scope="col">Times Drawn</th>
                  </tr>
                </thead>
                <tbody>
                    @forelse($ranked['zones'] as $key => $value)
                    <tr>
                        <th scope="row">{{ $key }}</th>
                        <td>{{ $value }}</td>
                    </tr>
                    @empty 
                        <tr>
                            <td colspan="7">No results found</td>
                        </tr>
                    @endforelse
                </tbody>
              </table>

        </div>
    </div>

</div>

@endsection