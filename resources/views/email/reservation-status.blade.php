<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statut de votre réservation</title>
    <style>
        /* Styles de secours pour les clients modernes */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap');
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
            width: 100% !important;
        }

        .external-wrapper {
            background-color: #f8fafc;
            padding: 40px 10px;
        }

        .main-card {
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }

        .btn {
            text-decoration: none;
            border-radius: 10px;
            font-weight: 700;
            display: inline-block;
            padding: 14px 28px;
            transition: all 0.2s;
        }

        /* Responsive */
        @media only screen and (max-width: 600px) {
            .inner-padding { padding: 24px !important; }
            .info-value { font-size: 14px !important; }
        }
    </style>
</head>
<body>

@php
    $config = [
        'confirmed' => [
            'color'       => '#10b981',
            'bg_gradient' => '#10b981',
            'icon'        => 'https://cdn-icons-png.flaticon.com/128/190/190411.png', // Check icon
            'title'       => 'Réservation confirmée !',
            'badge'       => 'Confirmée',
            'msg'         => 'Bonne nouvelle ! Votre terrain est réservé et l\'équipe vous attend.'
        ],
        'updated' => [
            'color'       => '#f59e0b',
            'bg_gradient' => '#f59e0b',
            'icon'        => 'https://cdn-icons-png.flaticon.com/128/1159/1159633.png', // Edit icon
            'title'       => 'Modification effectuée',
            'badge'       => 'Modifiée',
            'msg'         => 'Les détails de votre réservation ont été mis à jour avec succès.'
        ],
        'cancelled' => [
            'color'       => '#ef4444',
            'bg_gradient' => '#ef4444',
            'icon'        => 'https://cdn-icons-png.flaticon.com/128/1828/1828843.png', // X icon
            'title'       => 'Réservation annulée',
            'badge'       => 'Annulée',
            'msg'         => 'Votre réservation a été annulée. On espère vous revoir bientôt !'
        ],
    ];
    $c = $config[$type] ?? $config['confirmed'];
@endphp

<div class="external-wrapper">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; margin: 0 auto;">
        
        <tr>
            <td align="center" style="padding-bottom: 24px;">
                <table border="0" cellpadding="0" cellspacing="0" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 50px; padding: 8px 20px;">
                    <tr>
                        <td style="font-size: 14px; font-weight: 800; color: #0f172a; font-family: sans-serif;">
                            <span style="color: #10b981;">⚽</span> FootReserve
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td>
                <div class="main-card">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: {{ $c['color'] }}; color: #ffffff;">
                        <tr>
                            <td align="center" style="padding: 40px 20px;">
                                <h1 style="margin: 0; font-size: 24px; font-weight: 800; letter-spacing: -0.5px;">{{ $c['title'] }}</h1>
                                <p style="margin: 8px 0 0 0; opacity: 0.9; font-size: 15px;">{{ $c['msg'] }}</p>
                            </td>
                        </tr>
                    </table>

                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding: 32px;">
                        <tr>
                            <td>
                                <p style="margin: 0 0 4px 0; font-size: 16px; color: #0f172a; font-weight: 700;">Bonjour {{ $reservation->user->name }},</p>
                                <p style="margin: 0 0 24px 0; font-size: 14px; color: #64748b; line-height: 1.5;">Voici le récapitulatif de votre séance de football :</p>

                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; border-collapse: separate;">
                                    <tr>
                                        <td style="padding: 16px; border-bottom: 1px solid #e2e8f0;">
                                            <span style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase;">🏟️ Terrain</span><br>
                                            <span style="font-size: 15px; font-weight: 700; color: #0f172a;">{{ $reservation->terrain->name }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 16px; border-bottom: 1px solid #e2e8f0;">
                                            <span style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase;">📅 Date & Heure</span><br>
                                            <span style="font-size: 15px; font-weight: 700; color: #0f172a;">
                                                {{ \Carbon\Carbon::parse($reservation->date)->translatedFormat('l j F Y') }}
                                                <br>
                                                <span style="color: #64748b; font-weight: 500;">{{ substr($reservation->start_time, 11, 5) }} — {{ substr($reservation->end_time, 11, 5) }}</span>
                                            </span>
                                        </td>
                                    </tr>
                                    @if(!empty($reservation->total_price))
                                    <tr>
                                        <td style="padding: 16px;">
                                            <span style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase;">💰 Paiement</span><br>
                                            <span style="font-size: 15px; font-weight: 700; color: #10b981;">{{ $reservation->total_price }} DH</span>
                                        </td>
                                    </tr>
                                    @endif
                                </table>

                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top: 32px;">
                                    <tr>
                                        <td align="center">
                                            <a href="{{ url('/mes-reservations') }}" class="btn" style="background-color: {{ $c['color'] }}; color: #ffffff;">
                                                Gérer ma réservation
                                            </a>
                                        </td>
                                    </tr>
                                </table>

                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>

        <tr>
            <td align="center" style="padding-top: 24px;">
                <p style="margin: 0; font-size: 12px; color: #94a3b8; line-height: 1.5;">
                    Vous recevez cet e-mail car vous avez utilisé <strong>FootReserve</strong>.<br>
                    © {{ date('Y') }} FootReserve. Tous droits réservés.
                </p>
            </td>
        </tr>
    </table>
</div>

</body>
</html>