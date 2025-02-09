<!DOCTYPE html>
<html>

<head>
    <title>Vos identifiants de connexion</title>
</head>

<body>
    <h1>Bienvenue {{ $employee->prenom }} {{ $employee->nom }}</h1>

    <p>Voici vos identifiants de connexion :</p>

    <p><strong>Email :</strong> {{ $employee->email }}</p>
    <p><strong>Mot de passe :</strong> {{ $password }}</p>

    <p>Veuillez vous connecter à l'application en utilisant ces identifiants.</p>

    <p>Cordialement,<br>
        {{ config('app.name') }}</p>
</body>

</html>
