@extends('layouts.app')

@section('content')

<h1>ToDoList</h1>
<a href="{{route('todos.create')}}" class="btn btn-dark mb-sm-1">新規追加</a>
<form class="form-inline">
    <input method="GET" action="{{ route('todos.index') }}" class="form-control mr-sm-1" name="search" type="search" placeholder="タイトル・内容" aria-label="Search">
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">検索する</button>
</form>

<table class="table">
    <tr>
        <th>登録日</th>
        <th>タイトル</th>
        <th>説明</th>
        <th>期限日</th>
        <th>完了日</th>
        <th>詳細</th>
    </tr>
    @foreach ($todos as $todo)
    <tr class="
    @if (!is_null($todo->completion_date))
    text-success
    @elseif ($todo->expiration_date < date('Y-m-d'))
    text-danger
    @endif
    ">
        <td>{{ $todo->registration_date }}</td>
        <td>{!! nl2br(e($todo->title)) !!}</td>
        <td>{!! nl2br(e($todo->description)) !!}</td>
        <td>{{ $todo->expiration_date }}</td>
        <td>{{ $todo->completion_date }}</td>
        <td>
            <form action="{{ route('todos.destroy', $todo) }}" method="post" class="form-inline">
                @method('DELETE')
                @csrf
                <a href="{{ route('todos.show', $todo) }}" class="btn btn-primary">詳細</a>
                <a href="{{ route('todos.edit', $todo) }}" class="btn btn-warning">修正</a>
                <button type="submit" class="btn btn-danger" onclick="return confirm('本当に削除していいですか？');">削除</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

    {{ $todos->links() }}
    {{ $todos->count() * $todos->currentPage() -8 }} - {{ $todos->count() * $todos->currentPage() }} / {{ $todos->total() }}

@endsection