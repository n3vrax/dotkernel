//javascripts specific to our DotKernel framework

$(document).ready(
		function(){
			
			//redirect to register page is navbar signup button is clicked
			$('#sign-up-navbar-btn').click(
					function(){
						window.location.href = '/user/register';
						return false;
					}
			);
		}
);