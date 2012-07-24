<div id="fb-root"></div>
<script>
        var FB_APP_ID = "<?php echo $this->config->item('appId'); ?>";
        var FB_SCOPE = "<?php echo $this->config->item('scope'); ?>";
        var FB_REDIRECT_URI = "<?php echo $this->config->item('redirect_uri'); ?>";
        
        window.fbAsyncInit = function() {
                FB.init({
                        appId      : FB_APP_ID, // App ID
                        channelUrl : '//WWW.YOUR_DOMAIN.COM/channel.html', 
                        status     : true, 
                        cookie     : true,
                        xfbml      : true  
                });

                
                FB.getLoginStatus(function(response) {
                        if (response.status === 'connected') {
                             
                                var uid = response.authResponse.userID;
                                var accessToken = response.authResponse.accessToken;
                                
                                
                                
                        } else if (response.status === 'not_authorized') {

                                var oauth_url = 'https://www.facebook.com/dialog/oauth/';
                                oauth_url += '?client_id='+FB_APP_ID;
                                oauth_url += '&redirect_uri=' + encodeURIComponent(FB_REDIRECT_URI);
                                oauth_url += '&scope='+FB_SCOPE;
                                
                                window.top.location = oauth_url;
                                
                                
                        } else {

                               
                                var oauth_url = 'https://www.facebook.com/dialog/oauth/';
                                oauth_url += '?client_id='+FB_APP_ID;
                                oauth_url += '&redirect_uri=' + encodeURIComponent(FB_REDIRECT_URI);
                                oauth_url += '&scope='+FB_SCOPE;
                               
                                window.top.location = oauth_url;
                                
                        }
                });
    
        };

     
        (function(d){
                var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
                if (d.getElementById(id)) {return;}
                js = d.createElement('script'); js.id = id; js.async = true;
                js.src = "//connect.facebook.net/fr_FR/all.js";
                ref.parentNode.insertBefore(js, ref);
        }(document));
</script>


<div class="login-container">
        
        <h1>Login in process</h1>
        
</div>