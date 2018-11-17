<?php
    include_once 'header.php';
?>

<main>

    <div class="form-container">

        <form id="register" action="process/registration.php" method="POST">
            
            <h1 style="text-align:center">REĢISTRĀCIJA</h1>

            <fieldset>
                <input type="text" name="first" placeholder="Vārds*" required>
            </fieldset>

            <fieldset>
                <input type="text" name="last" placeholder="Uzvārds*" required>
            </fieldset>

            <fieldset>
                <input type="email" name="email" placeholder="Epasts*" required>
            </fieldset>

            <fieldset>
                <input type="text" name="username" placeholder="Lietotājvārds*" required>
            </fieldset>

            <fieldset>
                <input type="text" name="phone" placeholder="Telefons*" required>
            </fieldset>

            <fieldset>
                <input type="password" name="password" placeholder="Parole*" required>
            </fieldset>

            <fieldset>
                <input type="password" name="password-repeat" placeholder="Parole atkārtoti*" required>
            </fieldset>

            <fieldset>
                <input type="radio" name="role" value="pasazieris" checked>Pasažieris
                <input type="radio" name="role" value="soferis">Šoferis
            </fieldset>
            
            <fieldset>
                <button type="submit" name="submit">Sign up</button>
            </fieldset>
            
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