@extends('layouts.app')

@section('content')
    <div class="container">
        @include('cabinet._nav')

        <p><a href="{{ route('cabinet.tickets.create') }}" class="btn btn-success">Создать тикет</a></p>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>Идентификатор</th>
                <th>Создано</th>
                <th>Дата обновления</th>
                <th>Тема</th>
                <th>Статус</th>
            </tr>
            </thead>
            <tbody>

            @foreach ($tickets as $ticket)
                <tr>
                    <td>{{ $ticket->id }}</td>
                    <td>{{ $ticket->created_at }}</td>
                    <td>{{ $ticket->updated_at }}</td>
                    <td><a href="{{ route('cabinet.tickets.show', $ticket) }}"
                           target="_blank">{{ $ticket->subject }}</a></td>
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
            @endforeach

            </tbody>
        </table>

        {{ $tickets->links() }}
    </div>
@endsection
