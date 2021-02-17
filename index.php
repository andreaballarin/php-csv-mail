<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hello Bulma!</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <script src="https://unpkg.com/ionicons@5.2.3/dist/ionicons.js"></script>
</head>

<body>
    <nav class="navbar is-primary" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a class="navbar-item">

                <ion-icon name="mail-outline"></ion-icon>

            </a>
            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="navbarBasicExample" class="navbar-menu">
            <div class="navbar-start">
                <a class="navbar-item">
                    Dashboard
                </a>

                <a class="navbar-item">
                    Setup server email
                </a>

                <a class="navbar-item">
                    Seleziona CSV
                </a>

            </div>

        </div>
    </nav>
    <section class="section">
        <div class="container">
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title">
                        Component
                    </p>
                    <a href="#" class="card-header-icon" aria-label="more options">
                        <span class="icon">
                            <i class="fas fa-angle-down" aria-hidden="true"></i>
                        </span>
                    </a>
                </header>
                <div class="card-content">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Mail
                                </th>
                                <th>Password
                                </th>
                                <th>Stato
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            use src\Exception;
                            use src\PHPMailer;
                            use src\SMTP;

                            iconv_set_encoding("internal_encoding", "UTF-8");
                            $fileHandle = fopen("example.csv", "r"); //input correct csv file name
                            while (($row = fgetcsv($fileHandle, 0, ";")) !== false) {
                                echo '<tr>';
                                echo '<td>' . $row[0] . '</td>';
                                echo '<td>' . $row[2] . '</td>';
                                require_once 'src/Exception.php';
                                require_once 'src/PHPMailer.php';
                                require_once 'src/SMTP.php';
                                require_once 'src/OAuth.php';
                                $to = $row[0];
                                $subject = "Password Google Workspace";

                                $message = '<h1>Ti diamo il benvenuto nel tuo nuovo Account Google per <Nome organizzazione></h1>
                                        <p class="mb-2">Gentile</p>
                                        <p class="mb-2">Hai un nuovo Account Google con l' . "'" . 'organizzazione <Nome organizzazione></p>
                                        <p class="mb-2">Accedi per usufruire dei servizi Google messi a disposizione dalla tua organizzazione. La tua organizzazione comprende versioni di livello aziendale di Google Drive, Gmail e altri servizi Google che puoi utilizzare per
                                        collaborare.</p><br>
                                        <h3 class="mb-2">Nome utente: ' . $row[1] . '</h3>
                                        <h3 class="mb-2">Password: ' . $row[2] . '</h3><br>
                                        <a href="https://accounts.google.com/signin/v2/identifier?service=accountsettings&continue=https%3A%2F%2Fmyaccount.google.com%2F%3Fnlr%3D1&ec=GAlAwAE&flowName=GlifWebSignIn&flowEntry=AddSession" title="Login"><h3>Accedi da qui</h3></a>
                                        ';


                                $mail = new PHPMailer(true);
                                try {
                                    //Server settings
                                    $mail->SMTPDebug = 3; // Enable verbose debug output
                                    $mail->isSMTP(); // Set mailer to use SMTP
                                    $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
                                    $mail->SMTPAuth = true; // Enable SMTP authentication
                                    $mail->Username = ''; // SMTP username
                                    $mail->Password = ''; // SMTP password
                                    $mail->SMTPSecure = 'ssl'; // Enable TLS encryption, `ssl` also accepted
                                    $mail->Port = 465; // TCP port to connect to
                                    $mail->setFrom('admin@mydomain.com', 'Admin | <Nome organzzazione>');
                                    $mail->addAddress($row[0], $row[0]); // Add a recipient
                                    $mail->isHTML(true); // Set email format to HTML
                                    $mail->Subject = $subject;
                                    $mail->Body = $message;
                                    $mail->send();
                                    echo '<td><span class="badge badge-primary">Messaggio inviato con successo a "' . $to . '</span></td>';
                                } catch (Exception $e) {
                                    echo "<td>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</td>";
                                }
                                echo '<tr>';
                            };
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
    </section>
</body>

</html>