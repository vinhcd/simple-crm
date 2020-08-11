@extends('layouts.credential')

@section('title')
    Neos Corp | Log in
@stop

@section('content')
<div class="login-box">
    <div class="login-logo">
        <span><b>Neos</b> Corporation</span>
    </div>

    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Create a new user</p>

            <form action="{{route('user_create_update')}}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Username">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8"></div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
