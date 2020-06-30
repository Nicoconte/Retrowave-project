<!-- 
<div class="dashboard-container">
	<div class="dashboard-test">
		<button id="logout-btn" class="w3-btn w3-red">Cerrar sesion</button>
		<blockquote>
			<input type="text" id="c-name" class="w3-input" placeholder="Nombre de la sala">
			<input type="text" id="c-pass" class="w3-input" placeholder="Contraseña de la sala">
		</blockquote>
		<button class="w3-btn w3-green" id="create-chat-btn">Crear sala</button>
	</div>
	
	<div class="dashboard-result"></div>

</div>
 -->

 <div class="dashboard-container w3-black"> 
	
	<div class="dashboard-border-shadow">
	
		<div class="dashboard-side-bar">

			<div class="dashboard-side-bar-options">
				<button class='w3-btn'><i class='fa fa-pencil'></i></button>
			</div>

			<div class="dashboard-side-bar-actions">
				<blockquote>
					<button class="w3-btn" id="show-create-modal"><i class="fa fa-gamepad"></i> Crear sala</button>
					<button class="w3-btn" id="see-chat"><i class="fa fa-search"></i> Ver salas</button>
					<button class="w3-btn" id="see-converter"><i class="fa fa-calculator"></i> Conversores</button>
					<button class="w3-btn"><i class="fa fa-cogs"></i> Configuraciones</button>
					<button class="w3-btn" id="logout-btn"><i class="fa fa-sign-out"></i> Cerrar sesion</button>
				</blockquote>
			</div>
			
			<div class="dashboard-side-bar-help">
				<button class="w3-btn"><i class="fa fa-question-circle"></i> Ayuda</button>
			</div>

		</div>

		<div class="dashboard-main-content">
			
			<div class="dashboard-head">
				
				<div class="dashboard-head-user">
					<h6 id="dashboard-user-name"></h6>
				</div>
				
				<div class="dashboard-head-1P-text">
					<h1>1 Player</h1>
				</div>

			</div>

			<div class="dashboard-content">
				
				<div class="dashboard-content-1P">
					<div class="content-test">
						
					</div>
				</div>			

			</div>
			
			<div class="dashboard-credits">
				<div class="dashboard-credits-social">
					<i class="fa fa-github"></i>
					<i class="fa fa-linkedin"></i>
					<i class="fa fa-instagram"></i>
				</div>
				<div class="dashboard-credits-brand">
					<h6>Nicolas Conte <i class="fa fa-copyright"></i></h6>
				</div>
			</div>	

		</div>
		
	</div>
 
 </div>


<!-- Modals -->

<!-- The Modal -->
<div id="create-chat-modal" class="w3-modal" style="display:none;">
  <div class="w3-modal-content w3-animate-top">
    <span id="close-create-modal" class="w3-btn w3-display-topright">&times;</span>
     <div class="create-chat-modal-form">
      	<blockquote>
      		<form id="form-to-clear">
      			<input type="text" class="w3-input" placeholder="Nombre de la sala" id="c-name">
      			<input type="text" class="w3-input w3-margin-top" placeholder="Contraseña" id="c-pass">
      			<button class="w3-btn w3-margin-top" id="create-chat-btn">Crear sala</button>
      		</form>
      	</blockquote>
     </div>
  </div>
</div>

<div id="see-chat-modal" class="w3-modal" style="display:none;">
	<div class="w3-modal-content w3-animate-top">
		<div class="see-chat-modal-content">
		 	<span id="close-see-modal" class="w3-btn w3-display-topright">&times;</span>
		 	<div class="see-chat-modal-head">
		 		<div class="see-chat-filter">
		 			<i class="fa fa-search"></i>
		 			<input type="text" class="w3-input" placeholder="Buscar sala">
		 		</div>
		 	</div>
		 	<div class="see-chat-modal-result w3-red">
		 		
		 	</div>			
		</div>
	</div>
</div>

<div id="converter-modal" class="w3-modal" style="display: none;">
	<div class="w3-modal-content w3-animate-top">
		<div class="converter-modal-container">
			<span id="close-converter-modal" class="w3-btn w3-display-topright">&times;</span>
			<div class="converter-options">
				<select id="converter-option" class='w3-select'> 
					<option value="">Seleccione un conversor</option>
					<option value="bin-to-text">Binario a texto</option>
					<option value="text-to-bin">Texto a binario</option>
					<option value="bin-to-dec">Binario a decimal</option>
					<option value="dec-to-bin">Decimal a binario</option>
				</select>
			</div>
			<div class="converter-modal-content">
				<div class="converter-input">
					<textarea class="w3-textarea" id="c-input" cols="30" rows="10"></textarea>
					<button class="w3-btn w3-green w3-margin-top" id="converter-translate-btn">Traducir</button>
				</div>
				<div class="converter-output">
					<p id="c-output"></p>
				</div>				
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {

	user.setNameOnDashboard();
	verifyActiveAccount();

});

</script> 