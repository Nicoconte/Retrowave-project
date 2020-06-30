//Referencias :

//https://stackoverflow.com/questions/9939760/how-do-i-convert-an-integer-to-binary-in-javascript
//https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/for...in
const user = {
	setName : (name) => {
		localStorage.userName = name;
	},
	getName : () => {
		return localStorage['userName'];
	},
	setNameOnDashboard : () => {
		$("#dashboard-user-name").append(user.getName());
	}
}


const message = {
	normal : (icon, time, title="", text="") => {
		Swal.fire({
			icon : icon,
			title : title,
			text : text,
			timer : time
		});					
	},
	normalAndRedirect : (icon, time, title="", text="", path) => {
		Swal.fire({
			icon : icon,
			title : title,
			text : text,
			timer : time
		}).then(function(){
			window.location.href = path;
		});				
	},
	normalWithThen : (icon, time, title="", text="", anyFunction ) => {
		Swal.fire({
			icon : icon,
			title : title,
			text : text,
			timer : time
		}).then(function(){
			anyFunction;
		});
	}
}


const options = {
	action : "register"
}

const converters = {
	binToDec : (bin) => {
		let raiseTo = bin.length - 1;
		let total = 0;

		for(var i = 0; i < bin.length; i++) total = total + ((Math.pow(2, raiseTo--)) * bin[i]);

		return total;
	},
	decToBin : (dec) => {
		return(dec >>> 0).toString(2);
	},
	textToBin : (text) => {
		let dictionary = getAsciiTable();

		let result = "";

		for(let i = 0; i < text.length; i++)
		{
			if (text[i] in dictionary)
			{
				result += " " + converters.decToBin(dictionary[text[i]]);
			} 
		}

		return result;		
	},
	binToText : (bin) => {
		let dictionary = getAsciiTable();

		let binaries = bin.split(" ");
		let decimals = [];

		let completeWord = "";

		for(let i = 0; i < binaries.length; i++)
		{
			decimals.push( converters.binToDec(binaries[i]) );
		}

		for(let j = 0; j < decimals.length; j++)
		{
			completeWord += (_.invert(dictionary))[decimals[j]];
		}

		return completeWord;		
	},
	translate : (input, option) => {
		switch ($(option).val()) {
			case "bin-to-text":
				$("#c-output").text(converters.binToText($(input).val()));
				break;
			case "text-to-bin":
				$("#c-output").text(converters.textToBin($(input).val()));
				break;
			case "bin-to-dec":
				$("#c-output").text(converters.binToDec($(input).val()));
				break;
			case "dec-to-bin":
				$("#c-output").text(converters.decToBin($(input).val()));
				break;
			default:
				break;
		}
	}

}

//$("#task-form")[0].reset();
function clearFields(){
	document.getElementById("form-to-clear").reset();
}

function changeButtonActionFromLogin()
{
	$("#alter-register-btn").click(function() {
		$(".login-form-btn").removeClass("w3-border w3-border-purple");
		$(".register-form-btn").addClass("w3-border w3-border-purple");

		$("#u-pass-confir").fadeIn("slow", function(){
			$(this).show();
		});

		$("#u-email").fadeIn("slow", function() {
			$(this).show();
		});

		$("#u-name").attr("placeholder", "Nombre de usuario");
		$("#access-action-btn").text("Get started!");

		options.action = "register";

	});

	$("#alter-login-btn").click(function() {
		$(".register-form-btn").removeClass("w3-border w3-border-purple");
		$(".login-form-btn").addClass("w3-border w3-border-purple");

		$("#u-pass-confir").fadeOut("slow" ,function() {
			$(this).hide();
		});
		
		$("#u-email").fadeOut("slow", function(){
			$(this).hide();
		});

		$("#u-name").attr("placeholder", "Coloque su usuario")
		$("#access-action-btn").text("Get in!");

		options.action = "login";

	});
}


function areTheSamePassword()
{
	areTheSame = false;

	let password = $("#u-pass").val();
	let passwordConfir = $("#u-pass-confir").val();

	if(password == passwordConfir)
	{
		areTheSame = true;
	}

	return areTheSame;
}


function userRegister(action)
{
	$.ajax({
		type : "POST",
		dataType : "JSON",
		cache : false,
		url : "Core/Controller/UserController.php",
		data : {
			action : action,
			name : $("#u-name").val(),
			email : $("#u-email").val(),
			pass : $("#u-pass").val()
		}, 

		success : function(response)
		{
			if (response.success == 1)
			{
				message.normal("success", 1500, "Bievenido!", "Usuario creado").then(function(){
					clearFields("#l-login");
				});				
			} 
			else if (response.success == 0)
			{
				message.normal("warning", 1500, "Ops...","El usuario / email ya fue utilizado, intente con otro");
			}
		}
	});	
}

//Trasferencias -> enviar

function userLogin(action)
{
	$.ajax({
		type : "POST",
		dataType : "JSON",
		cache : false,
		url : "Core/Controller/UserController.php",
		data : {
			action : action, 
			name : $("#u-name").val(),
			pass : $("#u-pass").val()			
		},
		success : function(response)
		{	
			user.setName($("#u-name").val());
			
			if (response.access)
			{	
				message.normalAndRedirect("success", 1500, "ACCESS GRANTED","Bienvenido!", "index.php?p=Dashboard");
			}
			else
			{
				message.normal("warning", 1500, "ACCESS DENIED","Revise los datos");
			}
		}
	});	
}

function getChatRooms()
{	

	let template = "";
	let chatCount = 0;
	let showOnPage = "";

	$.ajax({
		type : "POST",
		dataType : "JSON",
		cache : false,
		url : "Core/Controller/ChatController.php",
		data : {
			action : "see-chat-rooms" 
		},
		success : function(response)
		{	

			console.log(response);

			//${data.u_name} | ${data.name} | ${data.date} => <button class='eliminar'> Eliminar </button>
			response.forEach(
				data => {
				template += 
				`
				<div class="chat-container w3-green w3-margin-top" c-id=${data.chat_id}>
					<div class="chat-container-head">
						${data.u_name} | ${data.name}
					</div>
					<div class="chat-container-body">

					</div>
				</div>
				`;

				chatCount++;

			});

			showOnPage = (chatCount == 0) ? "<h1> No hay nada para ver </h1>" : template;

			$(".see-chat-modal-result").html(showOnPage);
		}
	});	
}


function deleteChat()
{
	$(document).on("click", ".eliminar", function() {
		
		let elementoPadre = $(this)[0].parentElement;	
		let chatId = $(elementoPadre).attr("c-id");

		$.ajax({
			type : "POST",
			dataType : "JSON",
			cache : false,
			url : "Core/Controller/ChatController.php",
			data : {
				action : "delete-chat-room",
				id : chatId 
			},
			success : function (response)
			{
				if(response.deleted)
				{
					message.normalWithThen("success", 1500, "Sala eliminada", ":)", clearFields());
				}
			}
		})
	})
}

function areInputsEmpty(inputs)
{		

	let areEmpty = false;

	inputs.forEach(input => {

		let inputLegth = $(input).val().length;

		if (inputLegth <= 0)
		{
			$(input).addClass("empty-input-warning");
			areEmpty = true;
		}
		else
		{
			$(input).removeClass("empty-input-warning");
		}

	});

	return areEmpty;
}


function accessFormAction()
{
	$("#access-action-btn").click(function(e) {
	
		e.preventDefault();

		switch(options.action)
		{
			case "login":
				
				if(areInputsEmpty(["#u-name", "#u-pass"]))
				{
					return;
				}
				else
				{
					userLogin("login");
				}
			
				break;
			
			case "register":
				
				if(areInputsEmpty(["#u-name", "#u-email", "#u-pass", "#u-pass-confir"]))
				{
					return;
				}
				else if(areTheSamePassword())
				{
					userRegister("register");
				}
				else 
				{
					message.normal("warning", 1500, "Las contraseñas no coinciden");
				}

				break;

			default:
				break;
		}
	})
}


function userLogout()
{
	$("#logout-btn").click(function() {
		$.ajax({
			type : "POST",
			dataType : "JSON",
			cache : false,
			url : "Core/Controller/UserController.php",
			data : {
				action : "logout", 		
			},
			success : function(response)
			{
				if(response.logout)
				{	
					localStorage.clear();
					message.normalAndRedirect("success",1500, "Cerrando sesion", "adios", "index.php?p=Login");

				}
			}	
		})		
	})	
}


function createChatRoom()
{
	$("#create-chat-btn").click(function(e) {

		e.preventDefault();

		$.ajax({
			type : "POST",
			dataType : "JSON",
			cache : false,
			url : "Core/Controller/ChatController.php",
			data : {
				action : "create-chat",
				name : $("#c-name").val(),
				pass : $("#c-pass").val()
			},
			success : function(response)
			{
				if(response.created)
				{
					message.normalWithThen("success", 1500, "Chat creado", ("Guarda esta contraseña y compartila con tus amigos => " + response.password), clearFields());
				}
			}
		})
	})
}


//Try to change the name later
function verifyActiveAccount()
{

	$.ajax({
		type : "POST",
		dataType : "JSON",
		url : "Core/Controller/UserController.php",
		data : {
			action : "active-user"
		},
			success : function(response)
		{
			if (response.active == false)
			{
				window.location.href = "index.php?p=Login";
			}
			/*else
			{	
				//If user log, we could see the chat room
				getChatRooms();
			}*/
		}
	});
}

function doTranslate(){
	$("#converter-translate-btn").click(function() {
		converters.translate("#c-input","#converter-option");
	})
}

function showCreateChatModal()
{	
	$("#show-create-modal").click(function() {
		$("#create-chat-modal").css("display","inline-block");
	});
}

function closeCreateModal()
{
	$("#close-create-modal").click(function() {
		$("#create-chat-modal").fadeOut("fast");
	})
}

function showSeeChatModal()
{
	$("#see-chat").click(function() {
		$("#see-chat-modal").css("display","inline-block");
		setTimeout(() => {
			getChatRooms();
		}, 1000);
	});
}


function closeSeeModal()
{
	$("#close-see-modal").click(function() {
		$("#see-chat-modal").fadeOut("fast");
	})
}

function showConverterModal()
{	
	$("#see-converter").click(function() {
		$("#converter-modal").css("display","inline-block");
	});
}

function closeConverterModal()
{
	$("#close-converter-modal").click(function() {
		$("#converter-modal").fadeOut("fast");
	})
}

function readyFunctions()
{	
	//Modals
	closeCreateModal();
	showCreateChatModal();
	showSeeChatModal();
	closeSeeModal();
	showConverterModal()
	closeConverterModal()
	
	//Login form
	changeButtonActionFromLogin();
	accessFormAction();
	userLogout();

	//Chat 
	createChatRoom();
	deleteChat();

	//Converter
	doTranslate();

}

$(document).ready(readyFunctions);

