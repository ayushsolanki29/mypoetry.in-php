<div class="socials-row">
    <a href="<?= $gclient->createAuthUrl() ?>" title="Use Google">
        <img src="source/login/google.png" alt="Google">
        Login with Google
    </a>
 
    
    <a href="<?php echo $helper->getLoginUrl('login.php?login=1', $permissions); ?>">
    <img src="source/login/facebook.png" alt="Facebook">
    Login with Facebook
</a>

</div>