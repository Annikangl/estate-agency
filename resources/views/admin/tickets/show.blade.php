@extends('layouts.app')

@section('content')
    <div class="container">
        @include('admin._nav')


        <div class="d-flex flex-row mb-3">

            <a href="{{ route('admin.tickets.edit', $ticket) }}" class="btn btn-primary mr-1">Изменить</a>

            @if ($ticket->isOpen())
                <form method="POST" action="{{ route('admin.tickets.approve', $ticket) }}" class="mr-1">
                    @csrf
                    <button class="btn btn-success">Принят</button>
                </form>
            @endif

            @if (!$ticket->isClosed())
                <form method="POST" action="{{ route('admin.tickets.close', $ticket) }}" class="mr-1">
                    @csrf
                    <button class="btn btn-success">Закрыть</button>
                </form>
            @endif

            @if ($ticket->isClosed())
                <form method="POST" action="{{ route('admin.tickets.reopen', $ticket) }}" class="mr-1">
                    @csrf
                    <button class="btn btn-success">Открыть заново</button>
                </form>
            @endif

            <form method="POST" action="{{ route('admin.tickets.destroy', $ticket) }}" class="mr-1">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">Удалить</button>
            </form>
        </div>

        <div class="row">
            <div class="col-md-7">
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>ID</th>
                        <td>{{ $ticket->id }}</td>
                    </tr>
                    <tr>
                        <th>Создан</th>
                        <td>{{ $ticket->created_at }}</td>
                    </tr>
                    <tr>
                        <th>Дата обновления</th>
                        <td>{{ $ticket->updated_at }}</td>
                    </tr>
                    <tr>
                        <th>Пользователь</th>
                        <td><a href="{{ route('admin.users.show', $ticket->user) }}"
                               target="_blank">{{ $ticket->user->name }}</a></td>
                    </tr>
                    <tr>
                        <th>Статус</th>
                        <td>
                            @if ($ticket->isOpen())
                                <span class="badge bg-danger">Открыт</span>
                            @elseif ($ticket->isApproved())
                                <span class="badge bg-primary">Принят</span>
                            @elseif ($ticket->isClosed())
                                <span class="badge bg-secondary">Закрыт</span>
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-5">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Дата</th>
                        <th>Пользователь</th>
                        <th>Статус</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($ticket->statuses()->orderBy('id')->with('user')->get() as $status)
                        <tr>
                            <td>{{ $status->created_at }}</td>
                            <td>{{ $status->user->name }}</td>
                            <td>
                                @if ($status->isOpen())
                                    <span class="badge badge-danger">Открыт</span>
                                @elseif ($status->isApproved())
                                    <span class="badge badge-primary">Принят</span>
                                @elseif ($status->isClosed())
                                    <span class="badge badge-secondary">Закрыт</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                {{ $ticket->subject }}
            </div>
            <div class="card-body">
                {!! nl2br(e($ticket->content)) !!}
            </div>
        </div>

        @foreach ($ticket->messages()->orderBy('id')->with('user')->get() as $message)
            <div class="card mb-3">
                <div class="card-header">
                    {{ $message->created_at }} от пользователя <b>{{ $message->user->name }}</b>
                </div>
                <div class="card-body">
                    {!! nl2br(e($message->message)) !!}
                </div>
            </div>
        @endforeach

        @if ($ticket->allowsMessages())
            <form method="POST" action="{{ route('admin.tickets.message', $ticket) }}">
                @csrf

                <div class="form-group">
                    <textarea class="form-control{{ $errors->has('message') ? ' is-invalid' : '' }}" name="message"
                              rows="3" required>{{ old('message') }}</textarea>
                    @if ($errors->has('message'))
                        <span class="invalid-feedback"><strong>{{ $errors->first('message') }}</strong></span>
                    @endif
                </div>

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary">Отправить сообщение</button>
                </div>
            </form>
        @endif
    </div>
@endsection
