<?php
    include_once 'header.php';
?>

<main>

    <div class="container">
    
        <h1 style="text-align:center">REĢISTRĀCIJA</h1>

        <form id="register" action="process/registering.php" method="POST">
            
            <div class="form-group">
                <input type="text" class="form-control" name="first" placeholder="Vārds*" required>
            </div>

            <div class="form-group">
                <input type="text" class="form-control" name="last" placeholder="Uzvārds*" required>
            </div>

            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Epasts*" required>
            </div>

            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Lietotājvārds*" required>
            </div>

            <div class="form-group">
                <input type="text" class="form-control" name="phone" placeholder="Telefons*" required>
            </div>

            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Parole*" required>
            </div>

            <div class="form-group">
                <input type="password" class="form-control" name="password-repeat" placeholder="Parole atkārtoti*" required>
            </div>

            <div class="form-group">
                <input type="radio" name="role" value="pasazieris" checked>Pasažieris
                <input type="radio" name="role" value="soferis">Šoferis
            </div>

            <button class="btn btn-primary" type="submit" name="submit">Reģistrēties!</button>
            
        </form>

    </div>

    <div id="success-msg-wrapper" class="success-msg-wrapper">

        <div id="message-txt">Reģistrācija veiksmīga!
        </div>

        <div id="message-footer">
            <button id="message-btn" onclick="messageHide();">Turpināt</button>
        </div>

    </div>

</main>

<?php
	include_once 'footer.php';
?>