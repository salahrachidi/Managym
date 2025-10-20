<!DOCTYPE html>
<html>

<head>
    <style>
        /* @media print { */
        body {
            margin: 0;
            padding: 0;
        }

        .center {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 40vh;
            text-align: center;
            /* page-break-after: always; */
        }

        table {
            margin: 0 auto;
            page-break-inside: auto;
        }

        th,
        td {
            padding: 15px;
        }

        table,
        th,
        td {
            border: solid 1px black;
        }

        .onawn {
            display: flex;
            justify-content: center;
        }

        #ladrisa {
            display: grid;
            place-items: center;
            height: 10vh;
            /* Adjust this if needed */
        }

        /* } */
    </style>
</head>

<body style="font-family:Arial, Helvetica, sans-serif;">
    <div class="onawn">
        <h1>subscription receipt for: <span
                style="color:rgb(223, 169, 122);">{{ $user->per_nom . ' ' . $user->per_prenom }}</span></h1>
    </div>
    <div class="onawn">
        <p><b>Please go to the nearest Managym Gym to complete your subscription &lt;3 </b></p>
    </div>
    <div id="ladrisa">
        <p style="width:50%;">
        <address>Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci, dignissimos. Illo atque voluptatem,
            quo rerum nulla saepe, sapiente quas ea necessitatibus quis aliquam eligendi iure asperiores alias dicta
            laudantium doloribus?</address>
        </p>
    </div>
    <div class="center">

        <table style="width: 100%;">
            <thead>
                <tr>
                    <th style="color:rgb(223, 169, 122);">Full name</th>
                    <th style="color:rgb(223, 169, 122);">Phone number</th>
                    <th style="color:rgb(223, 169, 122);">Email</th>
                    <th style="color:rgb(223, 169, 122);">Chosen package</th>
                    <th style="color:rgb(223, 169, 122);">Chosen coach</th>
                    <th style="color:rgb(223, 169, 122);">Total price</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $user->per_nom . ' ' . $user->per_prenom }}</td>
                    <td>{{ $user->per_tel }}</td>
                    <td>{{ $user->per_email }}</td>
                    <td>{{ $user->package->pac_title }}</td>
                    <td>
                        @if ($user->coach_id == null)
                            <p style="color:rgb(223, 169, 122);"> Auto-coaching</p>
                        @else
                            {{ $user->coach->coa_nom . ' ' . $user->coach->coa_prenom }}
                        @endif
                    </td>
                    <td>{{ intval($user->package->pac_prix) }} <b>dh</b></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6">
                        {{ $qr }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="onawn">
        Made with love from <b> &nbsp; <span style="color:rgb(223, 169, 122);">Managym</span> &nbsp; </b> Community !
    </div>
    <div class="onawn" style="margin-top:7px">
        <b>Email</b>&nbsp;: Managym.gmail.com
    </div>

</body>

</html>
