@extends('layouts.layout')
@section('content')
<div class="d-flex align-items-md-center flex-column flex-md-row pt-1 pb-3">
    <div>
        <h4 class="fw-bold mb-3">Dashboard</h4>
        <h6 class="op-7 mb-2">Workflow Dashboard</h6>
    </div>
</div>
<div class="row">
    <div class="col-xl-12 d-flex align-items-stretch">
        <div class="w-100">
            <div class="card bg-header-dashboard">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mt-4 my-lg-4 ps-4">
                                <h4>Hello, {{ timeOfDay() }} {{ Auth::user()->employee->nickname ?? (getFirstName(Auth::user()->name))  }}!</h4>
                                <h6>Check your daily task job</h6>
                            </div>
                        </div>
                        <div class="col-md-4 d-lg-flex align-items-center justify-content-end text-center">
                            <img src="{{ asset('assets/img/working.png') }}" class="w-100" style="max-width:300px">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg d-flex align-items-stretch">
                    <div class="card panel-hover card-stats card-round w-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="d-md-flex justify-content-between align-items-end w-100">
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="col-icon ms-0">
                                        <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                            <i class="fas fa-users"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3 ms-sm-0">
                                        <div class="numbers">
                                            <div class="fw-bold text-secondary"><a href="{{ url('report_breaching?date='.$date) }}">Total Job</a></div>
                                            <h4 class="card-title">0</h4>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ url('report_breaching?date='.$date) }}" class="btn btn-theme float-end">Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg d-flex align-items-stretch">
                    <div class="card panel-hover card-stats card-round w-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="d-md-flex justify-content-between align-items-end w-100">
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="col-icon ms-0">
                                        <div class="icon-big text-center icon-info bubble-shadow-small">
                                            <i class="fas fa-user-check"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3 ms-sm-0">
                                        <div class="numbers">
                                            <div class="fw-bold text-secondary"><a href="{{ url('workflow_task') }}">Total Completed Job</a></div>
                                            <h4 class="card-title">2</h4>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ url('workflow_task') }}" class="btn btn-theme float-end">Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg d-flex align-items-stretch">
                    <div class="card panel-hover card-stats card-round w-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="d-md-flex justify-content-between align-items-end w-100">
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="col-icon ms-0">
                                        <div class="icon-big text-center icon-success bubble-shadow-small">
                                            <i class="fas fa-luggage-cart"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3 ms-sm-0">
                                        <div class="numbers">
                                            <div class="fw-bold text-secondary"><a href="{{ url('workflow_task') }}">Total Uncompleted Job</a></div>
                                            <h4 class="card-title">3</h4>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ url('workflow_task') }}" class="btn btn-theme float-end">Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="col-xl-4 d-flex align-items-stretch">
        <div class="card w-100 d-flex justify-content-center">
            <div class="card-header">
                <div class="card-head-row d-flex justify-content-between">
                    <div class="card-title">
                        Calendar November
                    </div>
                    <div><button class="btn btn-light border me-2"><</button><button class="btn btn-light border">></button></div>
                </div>
            </div>
            <div class="card-body d-flex justify-content-center align-items-center">
                <div class="table-responsive">
                    <table class="table table-calendar">
                        <tr>
                            <th width="14.2%">Su</th>
                            <th width="14.2%">Mo</th>
                            <th width="14.2%">Tu</th>
                            <th width="14.2%">We</th>
                            <th width="14.2%">Th</th>
                            <th width="14.2%">Fr</th>
                            <th width="14.2%">Sa</th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>2</td>
                            <td class="active">
                                <span class="circle position-relative">3</span>
                            </td>
                            <td><span class="position-relative">4</span></td>
                            <td>5</td>
                            <td>6</td>
                            <td>7</td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>9</td>
                            <td>10</td>
                            <td>11</td>
                            <td><span class="circle position-relative">12</span></td>
                            <td>13</td>
                            <td>14</td>
                        </tr>
                        <tr>
                            <td>15</td>
                            <td>16</td>
                            <td>17</td>
                            <td>18</td>
                            <td>19</td>
                            <td>20</td>
                            <td>21</td>
                        </tr>
                        <tr>
                            <td>22</td>
                            <td>23</td>
                            <td>24</td>
                            <td>25</td>
                            <td>26</td>
                            <td>27</td>
                            <td>28</td>
                        </tr>
                        <tr>
                            <td>29</td>
                            <td>30</td>
                            <td>31</td>
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>6</td>
                            <td>7</td>
                            <td>8</td>
                            <td>9</td>
                            <td>10</td>
                            <td>11</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div> --}}
</div>
@endsection