@extends('layouts.app')

@section('content')
    <div class="container-fluid overflow-auto">
        @if (session('delete'))
            <div class="alert alert-danger d-block">
                {{ session('delete') }}
            </div>
        @endif
        <table class="table ">

            <thead>
                <tr>
                    <th scope="col"><a
                            href="{{ Route('admin.work.index', ['ordinatore' => 'id', 'verso' => $verso]) }}">#id</a>
                    </th>
                    <th scope="col"><a
                            href="{{ Route('admin.work.index', ['ordinatore' => 'title', 'verso' => $verso]) }}">Titolo</a>
                    </th>
                    <th scope="col"><a
                            href="{{ Route('admin.work.index', ['ordinatore' => 'subject', 'verso' => $verso]) }}">Argomento</a>
                    </th>
                    <th scope="col"><a
                            href="{{ Route('admin.work.index', ['ordinatore' => 'star_date', 'verso' => $verso]) }}">Data di
                            inizio</a></th>
                    <th scope="col"><a
                            href="{{ Route('admin.work.index', ['ordinatore' => 'end_date', 'verso' => $verso]) }}">Data
                            fine</a>
                    </th>
                    <th scope="col"><a
                            href="{{ Route('admin.work.index', ['ordinatore' => 'type_id', 'verso' => $verso]) }}">Linguaggio</a>
                    </th>
                    <th scope="col"><a
                            href="{{ Route('admin.work.index', ['ordinatore' => 'post', 'verso' => $verso]) }}">N_post</a>
                    </th>
                    <th scope="col"><a
                            href="{{ Route('admin.work.index', ['ordinatore' => 'collaborators', 'verso' => $verso]) }}">N_collaboratori</a>
                    </th>
                    <th scope="col">Tecnologie</th>
                    <th scope="col">Azione</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($works as $work)
                    <tr>

                        <td>{{ $work['id'] }}</td>
                        <td>{{ $work['title'] }}</td>
                        <td>{{ $work['subject'] }}</td>
                        <td>{{ \Carbon\Carbon::parse($work['start_date'])->format('d/m/Y') }}</td>
                        <td>{{ $work['end_date'] ? \Carbon\Carbon::parse($work['end_date'])->format('d/m/Y') : '' }}</td>
                        <td><span class="badge bg-success text-dark">{{ $work->type?->name }}</span></td>
                        <td>{{ $work['post'] }}</td>
                        <td>{{ $work['collaborators'] }}</td>
                        <td>
                            @forelse ($work->technologies as $tec)
                                <span class="badge bg-primary text-dark">{{ $tec->name }}</span>
                            @empty
                                <i class="fa-solid fa-xmark"></i>
                            @endforelse
                        </td>



                        <td>
                            <a href="{{ route('admin.work.show', $work) }}" class="btn btn-success" title="Dettaglio"><i
                                    class="fa-solid fa-eye"></i></a>
                            <a href="{{ route('admin.work.edit', $work) }}" class="btn btn-warning"title="Modifica"><i
                                    class="fa-solid fa-pen-to-square"></i></a>

                            <form class="d-inline" action="{{ route('admin.work.destroy', $work) }}" method="post"
                                onsubmit="return confirm('sei sicuro di voler cancellare {{ $work['title'] }}')">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger" type="submit"title='Cancella'><i
                                        class="fa-solid fa-trash"></i>
                                </button>
                            </form>

                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
