<a href="login">return</a>



<form class="signup" action="/" method="POST">

    <h2 class="signup__header">Sign Up</h2>

    <hr class="signup__line">

    <div class="signup__container">
        <div class="signup__unit">
            <input id="signup__username"
                   class="signup__input"
                   type="text" name="username"
                   placeholder="username *" required>
            <p class="signup__validation">

            </p>
        </div>

        <div class="signup__unit">
            <input id="signup__first-name"
                   class="signup__input"
                   type="text" name="first-name"
                   placeholder="First Name">
            <p class="signup__validation invalid">

            </p>
        </div>

        <div class="signup__unit">
            <input id="signup__last-name"
                   class="signup__input"
                   type="text" name="last-name"
                   placeholder="Last Name">
            <p class="signup__validation valid">

            </p>
        </div>

        <div class="signup__unit">
            <input id="signup__email"
                   class="signup__input"
                   type="email" name="email"
                   placeholder="Email *" required>
            <p class="signup__validation valid">

            </p>
        </div>

        <div class="signup__unit">
            <input id="signup__password"
                   class="signup__input"
                   type="password" name="password"
                   placeholder="Password *" required>
            <p class="signup__validation valid">

            </p>
        </div>


        <div class="signup__unit">
            <input id="signup__repeat-password"
                   class="signup__input"
                   type="password" name="repeat-passwordd"
                   placeholder="Repeat Password *" required>
            <p class="signup__validation valid">

            </p>
        </div>

        <input  id="signup__submit"
                class="signup__submit"
                type="submit" value="Submit">
    </div>



</form>
