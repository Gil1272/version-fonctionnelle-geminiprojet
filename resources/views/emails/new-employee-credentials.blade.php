<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vos identifiants de connexion</title>
    <style>
        body {
            font-family: 'Segoe UI', Roboto, Arial, sans-serif;
            background-color: #f4f6f9;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 24px;
            color: #2c3e50;
        }

        .content {
            font-size: 16px;
            line-height: 1.6;
        }

        .credentials {
            background-color: #f1f5f9;
            border-left: 4px solid #4f46e5;
            padding: 15px 20px;
            margin: 20px 0;
            border-radius: 6px;
        }

        .credentials p {
            margin: 8px 0;
            font-size: 15px;
        }

        .footer {
            font-size: 14px;
            color: #6c757d;
            text-align: center;
            margin-top: 40px;
            border-top: 1px solid #eaeaea;
            padding-top: 20px;
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <div class="header">
            <h1>Bienvenue {{ $employee->prenom }} {{ $employee->nom }} 👋</h1>
        </div>

        <div class="content">
            <p>Nous sommes ravis de vous accueillir sur la plateforme <strong>{{ config('app.name') }}</strong>.</p>
            <p>Voici vos identifiants de connexion :</p>

            <div class="credentials">
                <p><strong>📧 Email :</strong> {{ $employee->email }}</p>
                <p><strong>🔑 Mot de passe :</strong> {{ $password }}</p>
            </div>

            <p>Vous pouvez désormais vous connecter à l'application en utilisant ces informations.</p>
            <p>Pour des raisons de sécurité, pensez à changer votre mot de passe après la première connexion.</p>
        </div>

        <div class="footer">
            <p>Cordialement,<br>L’équipe {{ config('app.name') }}</p>
        </div>
    </div>
</body>

</html>
