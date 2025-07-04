<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Réinitialisation du mot de passe</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Roboto, sans-serif;
            background-color: #f4f6f9;
            color: #333;
        }

        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px 20px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #eaeaea;
        }

        .logo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #2c3e50;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .company-name {
            font-size: 20px;
            font-weight: 600;
            color: #2c3e50;
            margin: 0;
        }

        .subtitle {
            color: #6c757d;
            font-size: 14px;
            margin-top: 4px;
        }

        .title {
            text-align: center;
            font-size: 26px;
            margin: 40px 0 20px;
            color: #1a1a1a;
        }

        .content {
            font-size: 16px;
            line-height: 1.6;
            padding: 0 10px;
        }

        .button-container {
            text-align: center;
            margin: 30px 0;
        }

        .button {
            display: inline-block;
            background-color: #4f46e5;
            color: white;
            padding: 14px 30px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 6px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #3730a3;
        }

        .alternative-link {
            font-size: 14px;
            background-color: #f1f5f9;
            border-left: 4px solid #4f46e5;
            padding: 12px;
            margin-top: 20px;
            word-break: break-all;
            color: #333;
        }

        .warning {
            background-color: #fff8e1;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 30px 0;
            font-size: 14px;
            color: #856404;
        }

        .footer {
            text-align: center;
            font-size: 13px;
            color: #6c757d;
            border-top: 1px solid #eaeaea;
            padding-top: 20px;
        }

        a {
            color: #4f46e5;
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <div class="header">
            <!-- Par ceci (avec une image locale ou un lien absolu) -->
            <div class="logo">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo Gemini & Co"
                    style="width:60px; height:60px; border-radius:50%;">
            </div>
            <h1 class="company-name">GEMINI & CO</h1>
            <p class="subtitle">Gestion simplifiée des employés et projets digitaux</p>
        </div>

        <h2 class="title">Réinitialisation de votre mot de passe</h2>

        <div class="content">
            <p>Bonjour,</p>
            <p>Vous avez demandé à réinitialiser le mot de passe de votre compte <strong>{{ $email }}</strong>
                sur Gemini Management System.</p>
            <p>Veuillez cliquer sur le bouton ci-dessous pour continuer :</p>
        </div>

        <div class="button-container">
            <a href="{{ $resetUrl }}" class="button">Réinitialiser mon mot de passe</a>
        </div>

        <div class="content">
            <p>Si le bouton ne fonctionne pas, copiez et collez le lien suivant dans votre navigateur :</p>
            <div class="alternative-link">
                {{ $resetUrl }}
            </div>
        </div>

        <div class="warning">
            ⚠️ <strong>Important :</strong>
            <ul>
                <li>Ce lien expirera dans 24 heures.</li>
                <li>Si vous n’avez pas fait cette demande, ignorez simplement cet e-mail.</li>
                <li>Ne partagez jamais ce lien avec qui que ce soit.</li>
            </ul>
        </div>

        <div class="footer">
            <p>Cordialement,<br>L’équipe Gemini & Co</p>
            <p>Besoin d’aide ? Contactez-nous à <a href="mailto:support@gemini.com">support@gemini.com</a></p>
        </div>
    </div>
</body>

</html>
