<?php 
require_once('define.php');
require_once('instagram.php');
require_once('feedback.php');

$insta = new Instagram($client_id, $secret,$token );
$res = $insta->inspectToken($fbToken);
//print_r($res['data']['is_valid']); exit;
// if(!@$res['data']['is_valid'])
// {
// }
?>

<!DOCTYPE HTML>
<!--
	Phantom by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
	<title>Instagram Web App</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bulma/bulma.css">
		<style>
              .swal2-popup {
				width:800px !important;
				height:auto+10% !important;			
            }

			.flex-container {
   				 display: flex;
			}

			.flex-child {
				flex: 1;
				border: none;
				padding: 6px 10px;
			}  

			.flex-child:first-child {
				margin-right: 2px;
			} 

			textarea::-webkit-input-placeholder {
				color: white !important;
			}

			textarea:-moz-placeholder { /* Firefox 18- */
				color:white !important;  
			}

			textarea::-moz-placeholder {  /* Firefox 19+ */
				color: white !important;  
			}

			textarea:-ms-input-placeholder {
				color:white !important;
			}

			textarea::placeholder {
				color: white !important;
			}
		</style>		
	</head>
	<body class="is-preload">
		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
					<header id="header">
						<div class="inner">

							<!-- Logo -->
								<a href="index.php" class="logo">
									<span class="symbol"><img src="images/logo.svg" alt="" /></span><span class="title">Instagram Web App</span>
								</a>

							<!-- Nav -->
								<nav>
									<ul>
										<li><a href="#menu">Menu</a></li>
									</ul>
								</nav>

						</div>
					</header>

				<!-- Menu -->
					<nav id="menu">
						<h2>Menu</h2>
						<ul>
							<li><a href="index.php">Home</a></li>						
						</ul>
					</nav>

				<!-- Main -->
					<div id="main">
						<div class="inner">
							<header>
								<h1>Instagram Web App.</h1>
								<h2>Meus Posts</h2>
								<p>by @Youqkonw & @Banana Fish</p>
							</header>
							<section class="tiles">
									<?php  
											$posts = $insta->getMyPosts();
											//var_dump($posts); exit;
											foreach($posts["data"] as $p)
											{
												$caption = @$p["caption"];
												$permalink = $p["permalink"];
												$media_type = $p["media_type"];
												$media_url = $p["media_url"];
												if($media_type==='VIDEO')
												{
													echo '	<article class="style">
																<span class="image">
																<video controls style="height:400px;width:480px;">
																	<source src="'.$media_url.'mp4'.' type="video/mp4"">
																	</video>
																</span>
																<a ref="'.$media_url.'" target="_blank">
																	<div class="content">
																	<p>'.$caption.'</p>
																	</div>
																</a>
															</article>';
												}
												if($media_type==='IMAGE')
												{
													echo '<article class="style">
															<span class="image">
																<img src="'.$media_url.'" alt="" />
															</span>
															<a href="'.$media_url.'" target="_blank">
																<div class="content">
																	<p>'.$caption.'</p>
																</div>
															</a>
														</article>';
												}												
											
											}
									?>				
							</section>
							<section class="tiles">
								<h2>Terminal</h2>
								<textarea style="background-color:black;color:white;border-radius:5px; resize: none; 
								height:300px;overflow-y: scroll;font-size:16px;"autocomplete="off" placeholder="me@instagram:$" id='terminal'>me@instagram:$
								</textarea>
							</section>				
						</div>
					</div>
							<!-- Footer -->
						<div id="footer" >
						<div class="inner" >
							<section >
								<h2>Follow/Followers</h2>
								<form id='followers' action='#' mothod='POST' autocomplete="off" >
									<div class="fields">
										<div class="field half">
										<input type="text" id='userIn' maxlenght=20 style="color:black!important;" placeholder="Usuario Instagram">
										</div>
									</div>
									<ul class="actions">
										<li><input type='submit' onclick='conectar("<?php echo $fbToken?>");'  style="background-color:#4CAF50"  value='Conectar' id='btnC'>&nbsp;<input type='reset' value='Cancelar' style="background-color:#D0455D"></li>
									</ul>
								</form>
							</section>
							<section style="margin-left:-150px;">
								<div style="width:35vw">
									<h2>Result:</h2>
									<p  id='resultFolows'></p>	
								</div>
							</section>
							<!-- <section>
								<h2>Follow me</h2>
								<ul class="icons">
									<li><a href="https://www.facebook.com/Banana-Fish-108826245171687" class="icon brands style2 fa-facebook-f" target="_blank"><span class="label">Facebook</span></a></li>
									<li><a href="https://www.instagram.com/youqknow/" class="icon brands style2 fa-instagram" target="_blank"><span class="label">Instagram</span></a></li>									
								</ul>
							</section> -->
							<!-- <ul class="copyright" style="color:darkgray">
								<li>&copy; Tech21</li><li><a  onclick="show()"><h2>Politica de Privacidade</h2></a></li>
							</ul> -->
						</div>
					</div>
					<div id="footer" >
						<div class="inner" >
							<section>
							<h2>Comentarios do App</h2>
								<form id='feed'   action='#' mothod='POST' autocomplete="off" onsubmit="enviar()">	
									<div class="flex-container">
										<div class="flex-child field half">
											<input type="text" id='nome'style="color:black!important;" placeholder='Nome'><br/>
											<input type='email' id='email'  placeholder='Email'/><br/>
										</div>
										<div class="flex-child" style="padding-left:50px;">
											<input type="text" id="w3review"  class='w3review'  placeholder='Escreva seu comentario' style="color:black!important;" style="word-break: break-word !important;"><br/>
											<ul class="actions">
											<li><input type='button' onclick='enviar();'  value='Enviar' style="margin: 3px 0;background-color:#4CAF50">&nbsp;<input type='reset' value='Cancelar' style="background-color:#D0455D"></li>
											</ul>
										</div>											
									</div>		
								</form>				
							</section>
							<section>
								<h2>Comentarios:</h2>
								<div >
									<?php 
											$feed = new FeedBack();
											$data= $feed->getAllFedd();//	print_r($data); exit;	
											//print_r(gettype($data[0]['name']));print_r(count($data));
											for($x=0;$x<count($data);$x++)
											{
												//print($data[$x]['name']);
												echo '<div class="flex-child" style="padding:10px;margin:10px,10px;width:422px;">  
													 <li>nome:&nbsp;'.$data[$x]['name'].'</li>
													 <li>email:&nbsp;'.$data[$x]['email'].'</li>
													 <li>feedback:&nbsp;'.$data[$x]['text'].'</li>
													 </div>';
											}
										?>
								</div>
							</section>
							<section>
								<h2>Follow me</h2>
								<ul class="icons">
									<li><a href="https://www.facebook.com/Banana-Fish-108826245171687" class="icon brands style2 fa-facebook-f" target="_blank"><span class="label">Facebook</span></a></li>
									<li><a href="https://www.instagram.com/youqknow/" class="icon brands style2 fa-instagram" target="_blank"><span class="label">Instagram</span></a></li>									
								</ul>
							</section> 
							 <ul class="copyright" style="color:darkgray">
								<li>&copy; Tech21</li><li><a  onclick="show()"><h2>Politica de Privacidade</h2></a></li>
							</ul>				
						</div>					
					</div>		
											
			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>
			<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
			<script
			  src="https://code.jquery.com/jquery-2.2.4.min.js"
			  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
			  crossorigin="anonymous"></script>
			<script>
				
				let fbTokne= "<?php echo $fbToken?>";

				function show() {
					window.open('politica_privacidade.php', '_blank');
				}

				function start() 
				{
					let item = sessionStorage.getItem('agree');
					if(item!=='agree')
					{
						Swal.fire({
						title: 'Termos de uso',
						html: '<p>Esta pol??tica de Termos de Uso ?? v??lida a partir de Jun 2022. TERMOS DE USO ??? Tech21 Tech21</p>, pessoa jur??dica de direito privado descreve, atrav??s deste documento, as regras de uso do site condor2708.startdedicated.com/ e qualquer outro site, loja ou aplicativo operado pelo propriet??rio. Ao navegar neste website, consideramos que voc?? est?? de acordo com os Termos de Uso abaixo. Caso voc?? n??o esteja de acordo com as condi????es deste contrato, pedimos que n??o fa??a mais uso deste website, muito menos cadastre-se ou envie os seus dados pessoais. Se modificarmos nossos Termos de Uso, publicaremos o novo texto neste website, com a data de revis??o atualizada. Podemos alterar este documento a qualquer momento. Caso haja altera????o significativa nos termos deste contrato, podemos inform??-lo por meio das informa????es de contato que tivermos em nosso banco de dados ou por meio de notifica????es. A utiliza????o deste website ap??s as altera????es significa que voc?? aceitou os Termos de Uso revisados. Caso, ap??s a leitura da vers??o revisada, voc?? n??o esteja de acordo com seus termos, favor encerrar o seu acesso. Se????o 1 - Usu??rio A utiliza????o deste website atribui de forma autom??tica a condi????o de Usu??rio e implica a plena aceita????o de todas as diretrizes e condi????es inclu??das nestes Termos. Se????o 2 - Ades??o em conjunto com a Pol??tica de Privacidade A utiliza????o deste website acarreta a ades??o aos presentes Termos de Uso e a vers??o mais atualizada da Pol??tica de Privacidade de Tech21. Se????o 3 - Condi????es de acesso Em geral, o acesso ao website da Tech21 possui car??ter gratuito e n??o exige pr??via inscri????o ou registro. Contudo, para usufruir de algumas funcionalidades, o usu??rio poder?? precisar efetuar um cadastro, criando uma conta de usu??rio com login e senha pr??prios para acesso. ?? de total responsabilidade do usu??rio fornecer apenas informa????es corretas, aut??nticas, v??lidas, completas e atualizadas, bem como n??o divulgar o seu login e senha para terceiros. Partes deste website oferecem ao usu??rio a op????o de publicar coment??rios em determinadas ??reas. Tech21 n??o consente com a publica????o de conte??dos que tenham natureza discriminat??ria, ofensiva ou il??cita, ou ainda infrinjam direitos de autor ou quaisquer outros direitos de terceiros. A publica????o de quaisquer conte??dos pelo usu??rio deste website, incluindo mensagens e coment??rios, implica em licen??a n??o-exclusiva, irrevog??vel e irretrat??vel, para sua utiliza????o, reprodu????o e publica????o pela Tech21 no seu website, plataformas e aplica????es de internet, ou ainda em outras plataformas, sem qualquer restri????o ou limita????o. Se????o 4 - Cookies Informa????es sobre o seu uso neste website podem ser coletadas a partir de cookies. Cookies s??o informa????es armazenadas diretamente no computador que voc?? est?? utilizando. Os cookies permitem a coleta de informa????es tais como o tipo de navegador, o tempo despendido no website, as p??ginas visitadas, as prefer??ncias de idioma, e outros dados de tr??fego an??nimos. N??s e nossos prestadores de servi??os utilizamos informa????es para prote????o de seguran??a, para facilitar a navega????o, exibir informa????es de modo mais eficiente, e personalizar sua experi??ncia ao utilizar este website, assim como para rastreamento online. Tamb??m coletamos informa????es estat??sticas sobre o uso do website para aprimoramento cont??nuo do nosso design e funcionalidade, para entender como o website ?? utilizado e para auxili??-lo a solucionar quest??es relevantes. Caso n??o deseje que suas informa????es sejam coletadas por meio de cookies, h?? um procedimento simples na maior parte dos navegadores que permite que os cookies sejam automaticamente rejeitados, ou oferece a op????o de aceitar ou rejeitar a transfer??ncia de um cookie (ou cookies) espec??fico(s) de um site determinado para o seu computador. Entretanto, isso pode gerar inconvenientes no uso do website. As defini????es que escolher podem afetar a sua experi??ncia de navega????o e o funcionamento que exige a utiliza????o de cookies. Neste sentido, rejeitamos qualquer responsabilidade pelas consequ??ncias resultantes do funcionamento limitado deste website provocado pela desativa????o de cookies no seu dispositivo (incapacidade de definir ou ler um cookie). Se????o 5 - Propriedade Intelectual Todos os elementos de Tech21 s??o de propriedade intelectual da mesma ou de seus licenciados. Estes Termos ou a utiliza????o do website n??o concede a voc?? qualquer licen??a ou direito de uso dos direitos de propriedade intelectual da Tech21 ou de terceiros. Se????o 6 - Links para sites de terceiros Este website poder??, de tempos a tempos, conter links de hipertexto que redirecionar?? voc?? para sites das redes dos nossos parceiros, anunciantes, fornecedores etc. Se voc?? clicar em um desses links para qualquer um desses sites, lembre-se que cada site possui as suas pr??prias pr??ticas de privacidade e que n??o somos respons??veis por essas pol??ticas. Consulte as referidas pol??ticas antes de enviar quaisquer Dados Pessoais para esses sites. N??o nos responsabilizamos pelas pol??ticas e pr??ticas de coleta, uso e divulga????o (incluindo pr??ticas de prote????o de dados) de outras organiza????es, tais como Facebook, Apple, Google, Microsoft, ou de qualquer outro desenvolvedor de software ou provedor de aplicativo, loja de m??dia social, sistema operacional, prestador de servi??os de internet sem fio ou fabricante de dispositivos, incluindo todos os Dados Pessoais que divulgar para outras organiza????es por meio dos aplicativos, relacionadas a tais aplicativos, ou publicadas em nossas p??ginas em m??dias sociais. N??s recomendamos que voc?? se informe sobre a pol??tica de privacidade e termos de uso de cada site visitado ou de cada prestador de servi??o utilizado. Se????o 7 - Prazos e altera????es O funcionamento deste website se d?? por prazo indeterminado. O website no todo ou em cada uma das suas se????es, pode ser encerrado, suspenso ou interrompido unilateralmente por Tech21, a qualquer momento e sem necessidade de pr??vio aviso. Se????o 8 - Dados pessoais Durante a utiliza????o deste website, certos dados pessoais ser??o coletados e tratados por Tech21 e/ou pelos Parceiros. As regras relacionadas ao tratamento de dados pessoais de Tech21 est??o estipuladas na Pol??tica de Privacidade. Se????o 9 - Contato Caso voc?? tenha qualquer d??vida sobre os Termos de Uso, por favor, entre em contato pelo e-mail pedro.hsdeus@hotmail.com.',
						heightAuto: false,
						widthAuto: false,
						showDenyButton: true,
						confirmButtonText: 'Aceito',
						denyButtonText: `N??o Aceito`,
						confirmButtonColor: '#4CAF50',
						cancelButtonColor: '#D0455D',
						}).then((result) => {
							/* Read more about isConfirmed, isDenied below */
							if (result.isConfirmed) {
								sessionStorage.setItem('agree', 'agree');

							} else if (result.isDenied) {
								window.location.href = 'https://google.com'
							}
						});
					}					
				}

				function conectar(fbTokne)
				{
					event.preventDefault();
					if($('#userIn').val()=='')
					{
						Swal.fire({
							title:'',
							html:'<h3>Por favor preencha seu nome!</h3>',
							icon:'info'
							});
							return;
					}
					else
					{
						Swal.fire({
						html: 'Ao conectar a sua conta Instagram/Facebook, voc?? concorda em permitir acesso a metadados, posts/feeds.'+ 
						'De acordo com a politica de privacidade <a href="politica_privacidade.php" style="color:blue;" target="_blank">Politica de Privacidade</a>',
						showDenyButton: false,
						showCancelButton: true,
						confirmButtonText: 'Sim',
						cancelButtonText: `N??o`,
						confirmButtonColor: '#4CAF50',
						cancelButtonColor: '#D0455D',
						customClass: 'swal-wide',
						}).then((result) => {
						/* Read more about isConfirmed, isDenied below */
						if (result.isConfirmed) {
							formData= new FormData()
							formData.append('userIn',$('#userIn').val());
							Swal.fire('Token Facebook',fbTokne,'info');
							con(formData);

						} else {
							document.getElementById("btnC").disabled = false; 
							return false;
						}
						});					
					}
				}	
				
				async function con(formData)
				{
					const response = await fetch('getAccount.php',{
					method: 'POST',
					body: formData});
					var data = await response.text();
					if (data) {
						let obj = jQuery.parseJSON(data)
						if(obj.Status==200)
						{
							//document.getElementById("form").reset(); 
							let item = obj.msg;
							document.getElementById('resultFolows').innerHTML= item[1];
						}
						else
						{
							Swal.fire(
							obj.msg,
							'',
							'error'
							);
						}
					} 
				}

				function enviar()
				{
					event.preventDefault();
					if($('#nome').val()=='')
					{
						Swal.fire({
							title:'',
							html:'<h3>Por favor preencha seu nome!</h3>',
							icon:'info'
							});
							return;
					}
					if($('#email').val()=='')
					{
						Swal.fire({
							title:'',
							html:'<h3>Por favor preencha seu email!</h3>',
							icon:'info'
							});
							return;
					}
					if($("#w3review").val() == '')
					{
						Swal.fire({
							title:'',
							html:'<h3>Por favor preencha seu comentario!</h3>',
							icon:'info'
							});
							return;
					}
					else if($('#name').val()!='' & $('#email').val()!='' & $("#w3review").val()!='')
					{
						formData= new FormData()
						formData.append('email',$('#email').val());
						formData.append('nome',$('#nome').val());
						formData.append('w3review',document.getElementById('w3review').value);
						save(formData);
					}
				}


				async function save(formatedData)
				{
					const response = await fetch('setFeedback.php',{
						method: 'POST',
						body: formatedData});
					var data = await response.text();
					if (data) {
						let obj = jQuery.parseJSON(data)
						if(obj.Status==200)
						{
							Swal.fire(							
							'',
							obj.msg,
							'success'
							);
							document.getElementById("feed").reset(); 
						}
						else
						{
							Swal.fire(
							'',
							obj.msg,
							'error'
							);
						}
					}    
				}

				async function handleForm() {
					let userInput = '';
					//console.log('Before getting the user input: ', userInput);
					userInput = await getUserInput();
					//console.log('After getting user input: ', userInput);
					};

					function getUserInput() {
					return new Promise((resolve, reject) => {
						$('#terminal').keydown(function(e) {
							//alert(e.keyCode);
						if (e.keyCode == 13) 
						{
							const inputVal = $(this).val();
							//alert(inputVal); 
							if(inputVal.includes('me@instagram:$'))
							{
								let pattern ='me@instagram:$'.length;
								let result = inputVal.substring(pattern);
								//alert(inputVal); return;
								//alert(result); 
								handle(result);
								setTimeout(function x(){
									$('#terminal').val('');
								},5000); 
							}
							else
							{
								handle(inputVal);  
							}
							
						}
						});
					});
				};

				handleForm();

				function handle(input)
				{
					switch(input.trim())
					{
						case 'help': 
						case 'ajuda': 
						case 'h':
						case 'H':
							$('#terminal').val('');
							const help ='Ajuda  digite'+'\r\n'+
							' 1 ou M para MyPosts'+'\r\n'+
							' 2 ou F feed()*'+'\r\n'+
							' 3 ou GF getFollowersCount()'+'\r\n'+
							' 4 ou E para explorer($account_name)'+'\r\n'+
							' 5 ou T para topSearch($account_name)*'+'\r\n'+
							' 10 ou R para renovar token facebook'+'\r\n'+
							' As func??es com * somente funcionam no browser'+'\r\n';
							$('#terminal').val(help);
						break;
						case 1:
						case '1':
						case 'M':
						case 'm':
							$('#terminal').val('');
							formData = new FormData();
							formData.append('function','1');
							getTerminal(formData,input.trim());
						break;
						case 2:
						case '2':
						case 'F':
						case 'f':
							$('#terminal').val('');
							formData = new FormData();
							formData.append('function','2');
							getTerminal(formData,input.trim());
						break;
						case 3: 
						case '3': 
						case 'GF':
						case 'gf':
							$('#terminal').val('');
							formData = new FormData();
							formData.append('function','3');
							getTerminal(formData,input.trim());
						break;
						case 4:
						case '4':
						case 'E':
						case 'e':
							$('#terminal').val('');
							formData = new FormData();
							formData.append('function','4');
							let unamea = prompt('Nome da conta Instagram');
							if(unamea.trim()!='')
							{
								formData.append('username',unamea);
								getTerminal(formData,input.trim());
							}
							
						break;
						case 5:
						case '5':
						case 'T':
						case 't':
							$('#terminal').val('');
							formData = new FormData();
							formData.append('function','5');
							let uname = prompt('Nome da conta Instagram');
							if(uname.trim()!='')
							{
								formData.append('username',uname);
								getTerminal(formData,input.trim());
							}
						break;
						case 10:
						case '10':
						case 'r':
						case 'R':
							$('#terminal').val('');
							formData = new FormData();
							formData.append('function','10');
							getTerminal(formData,input.trim());
						break;
					}
				}

				async function getTerminal(formatedData,type)
				{
					const response = await fetch('terminal.php',{
					method: 'POST',
					body: formatedData});
					const data = await response.text();
					if(data)
					{
						let obj = jQuery.parseJSON(data);
						if(obj.Status==200)
						{
							switch(type)
							{
								case 1:
								case '1':
								case 'M': 
								case 'm':
									$('#terminal').val('Meus posts, v??deos: '+obj.videos+' e imagens: '+obj.imagem);									
								break;
								case 2:
								case '2':
								case 'F':
								case 'f': 
									$('#terminal').val(obj.msg+'\r\n'+'Copiado para o clipboard');	
									navigator.clipboard.writeText(obj.clip);								
								break;
								case 3: 
								case '3': 
								case 'GF':
								case 'gf':
									$('#terminal').val('Eu sigo: '+obj.follow);		
								break;
								case 4:
								case '4':
								case 'E':
								case 'e':	
									$('#terminal').val(obj.msg);	
								break;
								case 5:
								case '5':
								case 'T':
								case 't':
									$('#terminal').val(obj.msg+'\r\n'+'Copiado para o clipboard');	
									navigator.clipboard.writeText(obj.clip);				
								break;
								case 10:
								case '10':
								case 'r':
								case 'R':
									$('#terminal').val(obj.msg);	

								break;
								//  navigator.clipboard.writeText(text);

							}
							setTimeout(function x(){
									$('#terminal').val('');
							},12000);
						}
					}
				}
				window.onload = start();	

			</script>								
	</body>
</html>