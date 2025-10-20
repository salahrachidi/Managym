<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Account Activation Page</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    
</head>
<body>
    <div class="container" >
        <div class="row " >
            <div class="col-8 mx-auto" >
                <div class="text-center" style="margin-top:20px;margin-bottom:10px; ">
                    <h1>Your subscription informations :</h1>
                </div>
                <table class="table" style="margin-top:150px;">
                    <thead class="table-dark "  >
                        <tr>
                            <th>Full name</th>
                            <th>Phone number</th>
                            <th>Email</th>
                            <th>Chosen package</th>
                            <th>Chosen coach</th>
                            <th>Total price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $user->per_nom .' '.$user->per_prenom }}</td>
                            <td>{{ $user->per_tel }}</td>
                            <td>{{ $user->per_email }}</td>
                            <td>{{ $user->package->pac_title }}</td>
                            <td>
                                @if ($user->coach_id == null)
                                    <p class="text-primary" > Auto-coaching</p>
                                @else
                                    {{ $user->coach->coa_nom.' '.$user->coach->coa_prenom }}
                                @endif
                            </td>
                            <td>{{ intval($user->package->pac_prix)  }} <b>dh</b></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-center" colspan="2"><a href="/logout" class="btn btn-outline-secondary" >logout</a></td>
                            <td colspan="5" class="text-center"><button class="btn btn-outline-primary" onclick="printCustomPage('/pdf/{{ $user->id }}')">Print receipt</button></td>
                            <a href="/pdf/1">kda</a>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
            function printCustomPage(url) {
                var printWindow = window.open(url);
                printWindow.onload = function() {
                    printWindow.print();
                };
            }
    </script>
</body>
</html>