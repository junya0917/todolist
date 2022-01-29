@extends('layouts.app')

@section('content')

<h1>タスク詳細</h1>
<table class="table">
    <tr>
        <th>登録日</th>
        <td>{{ $todo->registration_date }}</td>
    </tr>
    <tr>
        <th>タイトル</th>
        <td>{!! nl2br(e($todo->title)) !!}</td>
    </tr>
    <tr>
        <th>期限日</th>
        <td>{{ $todo->expiration_date }}</td>
    </tr>
    <tr>
        <th>完了日</th>
        <td>{{ $todo->completion_date }}</td>
    </tr>
    <tr>
        <th>説明</th>
        <td>{!! nl2br(e($todo->description)) !!}</td>
    </tr>
</table>
<a href="{{ route('todos.index') }}" class="btn btn-primary">戻る</a>

@endsection