@extends('layout.template')

@section('content')
    <div class="content-wrapper">
        <h2 class="mb-4">Mes Tâches par Projet</h2>

        @if ($tasksGroupedByProjet->isEmpty())
            <div class="text-center mb-5">
                <img src="{{ asset('assets/images/no-task.png') }}" alt="Aucune tâche" style="max-width: 300px;">
                <h4 class="mt-4 text-muted">Aucune tâche assignée</h4>
                <p class="text-secondary">Vous n'avez actuellement aucune tâche à faire. Contactez votre superviseur pour en
                    avoir
                </p>
            </div>
        @else
            @foreach ($tasksGroupedByProjet as $projetId => $tasks)
                <div class="mb-5">
                    <h3 class="text-primary">{{ $tasks->first()->projet->nom ?? 'Projet inconnu' }}</h3>

                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Description</th>
                                <th>Date Début</th>
                                <th>Date Fin</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                                <tr @if ($task->status === 'completed') class="table-success" @endif>
                                    <td>{{ $task->title }}</td>
                                    <td>{{ $task->description }}</td>
                                    <td>{{ \Carbon\Carbon::parse($task->start_date)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($task->end_date)->format('d/m/Y') }}</td>
                                    <td>
                                        @if ($task->status === 'completed')
                                            <span class="badge bg-success">Terminée</span>
                                        @elseif ($task->status === 'in_progress')
                                            <span class="badge bg-warning text-dark">En cours</span>
                                        @else
                                            <span class="badge bg-secondary">En attente</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($task->status !== 'completed')
                                            <form action="{{ route('taches.update', $task->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-success"
                                                    title="Marquer comme terminée">
                                                    <i class="mdi mdi-check"></i> Terminer
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-sm btn-secondary" disabled title="Déjà terminée">
                                                <i class="mdi mdi-check-circle-outline"></i> Terminé
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            @endforeach
        @endif
    </div>

@endsection
