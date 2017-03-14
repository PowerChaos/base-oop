$('document').ready(function(){ 
     /* validation */  
	 $("#login-form").validate({
		rules:   
		{   
			password: 
			{   
				required: true,   
			},
			username: 
			{
				required: true,
				number: false,
			 },
		},
		messages:
		{
			password:{
				required: "Wachtwoord AUB"
                },
			username:{
				required: "Geef Gebruiker op AUB"
						 },
		},
		submitHandler: submitForm
	});
			/* validation */
			/* login submit */    
			function submitForm()
			{
				var data = $("#login-form").serialize();
				$.ajax({
					type : 'POST',
					url  : '../ajax/login.php',
					data : data,
					beforeSend: function()
					{
						$("#error").fadeOut();
						$("#btn-login").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; Wachten op Antwoord ...');
					},
					success :  function(data)
					{ 
						if(data == 1){
							$("#btn-login").html('<img src="../ajax/btn-ajax-loader.gif" /> &nbsp; Loggin in ...');
							setTimeout(' window.location.href = "../home"; ',1500);
						}
						else if(data == 0){
							$("#login-form").html('<center>Geen Toegang<br><img src="../ajax/na.png" /><br>Contacteer een Verandwoordelijke</center><script>$(document).ready(function(){setTimeout(function() {location.reload();}, 3500);});</script>');
						}
						else{
							$("#error").fadeIn(1500, function(){
								$("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+data+' !</div>');
								$("#btn-login").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Probeer opnieuw');
							});
							}
					}   
				});
			return false;  
			}   
			/* login submit */
});