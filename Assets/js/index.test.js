/*function keyTest()
{
	var input = document.getElementById("text-to-translate");
	input.addEventListener("keyup", function(event) {
	  if (event.keyCode === 13) {
	    event.preventDefault();
	    document.getElementById("send-text").click();
	  }
	});	
}*/


function test()
{		
	$("#send-text").click(function(e) 
	{		
		e.preventDefault();

		let binText = textToBin($("#text-to-translate").val());

		$("#result").append("<br>" + `
			<div class="result-card w3-black" key="${binText}"> 
				<p class="w3-margin-top"> ${binText} </p> 
				<button class="see-text w3-btn w3-purple w3-margin-top"> Ver contenido de arriba</button>
			<div>
		`);

		saveMessageTest();
	});
}


function saveMessageTest()
{
	$.ajax({
		type : "POST",
		dataType : "JSON",
		cache : false,
		url : "Core/Controller/MessageController.php",
		data : {
			action : "save-msg",
			message : $("#text-to-translate").val()
		},
		success : function (response)
		{
			console.log(0);
		}
	});
}

function seeTextTest()
{	

	$(document).on('click', '.see-text', function() {

		let upperElement = $(this)[0].parentElement;

		//It´ll throw an undefined message because of the space at the beginning
		let binAttr = $(upperElement).attr("key");

		//Delete the first space on the string. 
		let bin = binAttr.substring(1, binAttr.length);

		Swal.fire({
			icon : "info",
			text : binToText(bin)
		});
	});
}


function registerUserTest(action)
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
				Swal.fire({
					icon : "success",
					text : "Usuario creado",
					timer : 1500
				});					
			} 
			else if (response.success == 0)
			{
				Swal.fire({
					icon : "error",
					text : "Usuario ya existente",
					timer : 1500
				});
			}
		}
	});
}


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
			if (response.access)
			{	
				console.log(response.id);
				alert("Todo piola");
			}
		}
	})
}

function loginFormAction()
{
	$("#login-action-btn").click(function() {

		if (options.action == "login")
		{
			userLogin("login");
		}
		else
		{
			registerUserTest("register");
		}

	})
}

function testingFunction()
{
	$("#login-action-btn").click(function() {
		if (isTheSamePassword())
		{
			Swal.fire({
				icon : "success",
				title : "ACCESS GRANTED",
				background : "rgba(75, 0, 130, 0.1)",
				timer : 1500
			});
		}
		else
		{
		}
	})
}



function readyFunction()
{
	test();	
	//keyTest();
	seeTextTest();
	registerUserTest();
	//testingFunction();
	alterButton();
	loginFormAction();
}

$(document).ready(readyFunction);