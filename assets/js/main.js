// jQuery codes
$(document).ready(function(){
	// validate jwt to verify access
	
		var jwt = getCookie('jwt');
	//setCookie("jwt", "", 1);
	//console.log(jwt);
		if(jwt!=''){
			
			$.post("api/validate_token.php", JSON.stringify({ jwt:jwt })).done(function(result) {
					load(1)
			}).fail(function(result){// show login page on error
				showLoginPage();
				$("#logout").hide();
				//$('#response').html("<div class='alert alert-danger'>Please login to access the home page.</div>");
			});
		}else{

			showLoginPage();
			$("#logout").hide();
		}
		
    $(document).on('click', '#load', function(){
		$("#response").html("");
		var page = $(this).attr("page");
		load(page);
	})
	

   	// trigger when login form is submitted
	$(document).on('submit', '#login_form', function(){

		// get form data
		var login_form=$(this);
		var form_data=JSON.stringify(login_form.serializeObject());
		if( $('#remember').prop('checked') ) {
			var remember=1;
		}else{
			var remember=0;
		}
		// submit form data to api
		$.ajax({
			url: "api/login.php",
			type : "POST",
			contentType : 'application/json',
			data : form_data,
			success : function(result){
				//console.log("entro sesion")
				// store jwt to cookie
				setCookie("jwt", result.jwt, remember);

				// show home page & tell the user it was a successful login
				load(1);
				$('#response').html("<div class='alert alert-success'>Successful login.</div>");
				$("#logout").show();
			},
			error: function(xhr, resp, text){
				// on error, tell the user login has failed & empty the input boxes
				$('#response').html("<div class='alert alert-danger'>Login failed. Username or password is incorrect.</div>");
				login_form.find('input').val('');
			}
		});

		return false;
	});
	

	// logout the user
	$(document).on('click', '#logout', function(){
		showLoginPage();
		$('#response').html("<div class='alert alert-info'>You are logged out.</div>");
		$("#logout").hide();
	});
	
 
	// get or read cookie
	function getCookie(cname){
		var name = cname + "=";
		var decodedCookie = decodeURIComponent(document.cookie);
		var ca = decodedCookie.split(';');
		for(var i = 0; i <ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == ' '){
				c = c.substring(1);
			}

			if (c.indexOf(name) == 0) {
				return c.substring(name.length, c.length);
			}
		}
		return "";
	}
 
	// if the user is logged in
	/*function showLoggedInMenu(){
		// hide login and sign up from navbar & show logout button
		$("#login, #sign_up").hide();
		$("#logout").show();
	}*/

    // remove any prompt messages
	function clearResponse(){
		$('#response').html('');
	}

	// show login page
	function showLoginPage(){
		
		// remove jwt
		setCookie("jwt", "", 1);

		// login page html
		var html = `
			<form class="form-signin" id='login_form'>
				<img class="mb-4" src="assets/img/Logo.svg" alt="">
				<h3 class="txt-titulo"><strong>Welcome to the Learning Management System</strong></h3>
				<h2 class="txt-subtitulo">Please log in to continue</h2>
				<label for="username" class="sr-only">Username</label>
				<input type="text" id="username" name="username" class="form-control mb-3" placeholder="Username" required autofocus>
				<label for="password" class="sr-only">Password</label>
				<input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
				<div class="checkbox mb-3">
					<label>
						<input type="checkbox" value="1" id="remember"> Remember me
					</label>
				</div>


				<button class="btn btn-lg btn-primary btn-block login" type="submit" >Log in</button>
				<p class="mt-5 mb-3 text-muted">&copy;KnowledgeCity 2020</p>
			</form>
			`;

		$('#content').html(html);
		clearResponse();
		//showLoggedOutMenu();
	}

	// function to set cookie
	function setCookie(cname, cvalue, exdays) {
		var d = new Date();
		d.setTime(d.getTime() + (exdays*24*60*60*1000));
		var expires = "expires="+ d.toUTCString();
		document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
	}

	// if the user is logged out
/*	function showLoggedOutMenu(){
		// show login and sign up from navbar & hide logout button
		$("#login, #sign_up").show();
		$("#logout").hide();
	}
*/
	// showHomePage() function will be here

	// function to make form values to json format
	$.fn.serializeObject = function(){

		var o = {};
		var a = this.serializeArray();
		$.each(a, function() {
			if (o[this.name] !== undefined) {
				if (!o[this.name].push) {
					o[this.name] = [o[this.name]];
				}
				o[this.name].push(this.value || '');
			} else {
				o[this.name] = this.value || '';
			}
		});
		return o;
	};
	function load(page){
		
		var parametros = {"action":"ajax","page":page};
		$("#content").fadeIn('slow');
		
		$.ajax({
			url:'api/userlist.php',
			data: parametros,
			 beforeSend: function(objeto){
				$("#content").html("<img src='assets/img/loader.gif'>");
			},
			success:function(data){
		
				$("#content").html(data).fadeIn('slow');
				
			}
		})
		
	}	
});