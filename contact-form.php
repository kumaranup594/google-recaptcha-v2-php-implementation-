<!-- for google recaptcha v2 -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<!-- end for google recaptcha v2 -->
<form action="server-side.php" method="post" id="contact-form">
    <table width="100%" border="0" cellpadding="2" cellspacing="0" class="table">
        <tr>
            <td class="subnav">Name</td>
        </tr>
        <tr>
            <td><input name="name" value="<?php echo @$_GET['name'] ?>" type="text" id="name" size="40" /></td>
        </tr>
        <tr>
            <td class="subnav">E-Mail</td>
        </tr>
        <tr>
            <td><input name="email" value="<?php echo @$_GET['email'] ?>" type="text" id="email" size="40" /></td>
        </tr>
        <tr>
            <td class="subnav">Phone</td>
        </tr>
        <tr>
            <td><input name="phone" value="<?php echo @$_GET['phone'] ?>"  type="text" id="phone" size="40" /></td>
        </tr>
        <tr>
            <td class="subnav">Message</td>
        </tr>
        <tr>
            <td><textarea name="message" cols="40" rows="8" id="message"><?php echo @$_GET['message'] ?></textarea></td>
        </tr>
        <tr>
            <td><div class="g-recaptcha" data-sitekey="6LffIicbAA------lhnjFq"></div></td>
        </tr>
        <?php
        if(isset($_REQUEST['err_msg'])){
            echo '<tr><td style="background:red;color:white;padding:5px 10px;">'.$_REQUEST['err_msg'].'</td></tr>';
        }
        ?>
        <tr>
            <td><input type="image" class="extra1" src="images/submit.jpg"  border="0" alt="Submit Form" /></td>
        </tr>
    </table></form>