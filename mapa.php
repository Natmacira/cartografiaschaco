<?php

require_once 'functions.php';

if ( ! chaco_check_user_cookie() ) {
	if ( $_SERVER['HTTP_REFERER'] ) {
		$referer = parse_url( $_SERVER['HTTP_REFERER'] );
		$referer_path = $referer['path'];
		$referer_path = explode( '/', $referer_path );
		$referer_path = end( $referer_path );

		if ( $referer_path === 'home-Qom.php' ) {
			header( 'Location: form-Qom.php' );
		} elseif ( $referer_path === 'home-Wichi.php' ) {
			header( 'Location: form-Wichi.php' );
		} elseif ( $referer_path === 'home-Moqoit.php' ) {
			header( 'Location: form-Moqoit.php' );
		} else {
			header( 'Location: form.php' );
		}
	} else {
		header( 'Location: form.php' );
	}

	exit();
}

?>
<!DOCTYPE HTML>
<html>

<head>
	<meta name="robots" content="noindex,nofollow">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<link rel="stylesheet" href="<?php echo APP_HOME_URL; ?>lib/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo APP_HOME_URL; ?>lib/tether/tether.min.css">
	<link rel="stylesheet" href="<?php echo APP_HOME_URL; ?>lib/leaflet/leaflet.css">
	<link rel="stylesheet" href="<?php echo APP_HOME_URL; ?>lib/leaflet/leaflet.contextmenu.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="style.min.css?v=1">
	<title>Cartografías Abiertas</title>
	<script src='<?php echo APP_HOME_URL; ?>lib/jquery/jquery.min.js'></script>
	<script src='<?php echo APP_HOME_URL; ?>lib/tether/tether.min.js'></script>
	<script src='<?php echo APP_HOME_URL; ?>lib/bootstrap/bootstrap.min.js'></script>
	<script src='<?php echo APP_HOME_URL; ?>lib/leaflet/leaflet.js'></script>
	<script src="<?php echo APP_HOME_URL; ?>lib/leaflet/leaflet.contextmenu.min.js"></script>
	<script src="<?php echo APP_HOME_URL; ?>lib/magnustools/common.js"></script>
	<script src="<?php echo APP_HOME_URL; ?>lib/magnustools/md5.js"></script>
	<script src="<?php echo APP_HOME_URL; ?>lib/magnustools/wikidata.js"></script>
	<script src="<?php echo APP_HOME_URL; ?>lib/tooltranslate/tt.js"></script>
	<script>
		var cartografiasTranslations = <?php echo file_get_contents( 'lib/tooltranslate/data/languages-custom.json'); ?>;
		var homeUrl = '<?php echo APP_HOME_URL; ?>';
	</script>
	<script src="js/main-legacy.js"></script>
	<script src="js/main.js"></script>
	<script src="js/burger-menu.js"></script>

	<script src="js/sm_comm.js"></script>

	<style>

	</style>

</head>

<body class="page-mapa">
	<header>
		<img src="img/mobile/Banner_of_the_Qulla_Suyu.png" alt="">
		<p class="header-text"><a href="index.php"> Cartografías abiertas
				Qom, Wichi y Moqoit</a></p>
		<div id="container" class="open clss">
			<span class="cls"></span>
			<span>
				<ul class="sub-menu">
					<li><a href="home-Qom.php">Qom</a></li>
					<li><a href="home-Wichi.php">Wichí</a></li>
					<li><a href="home-Moqoit.php">Moqoit</a></li>
					<li><a href="home.php">Español</a></li>
					<li><a href="javascript:history.back()" class="go-back-link">
							< Volver</a>
					</li>
				</ul>
			</span>
			<span class="cls"></span>
		</div>
		<section>
			<ul class="desktop-menu">
				<li><a href="home-Qom.php">Qom</a></li>
				<li><a href="home-Wichi.php">Wichí</a></li>
				<li><a href="home-Moqoit.php">Moqoit</a></li>
				<li><a href="home.php">Español</a></li>
			</ul>
		</section>
	</header>
	<div id='top'>
		<nav class="navbar navbar-light bg-faded">
			<ul class="nav navbar-nav">
				<li class="nav-item"><button id='center_on_me' class='btn btn-secondary' tt_title='go_to_my_position'><i class="fa fa-compass" style='font-size:24pt' aria-hidden="true"></i></button></li>
				<!-- <li class="nav-item"><button id='search' class='btn btn-secondary' tt_title='search'>&#128269;</button></li> -->
				<li class='nav-item' style='display:none' id='li_authorize'>
					<a class='btn btn-outline-primary' href='api.php?action=authorize' tt='authorize_upload'></a>
				</li>
				<li class="nav-item" id='dropdownUploadsLi'>
					<div class="dropdown" style='display:inline'>
						<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownUploads" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
						<div class="dropdown-menu dropdown-menu-left" id='upload_list' style='margin-top:1em'></div>
					</div>
				</li>
				<li class="nav-item" id="geo_error" style='font-size:7pt'></li>
				<li class="nav-item"><button id='update' class='btn btn-info' tt='update'></button></li>
				<li class="nav-item">
					<div id='busy' tt_title='updating'><i class="fa fa-spinner" style='font-size:24pt' aria-hidden="true"></i></div>
				</li>
			</ul>

			<ul class="language-ul">
				<li><input type="radio" class="language-switch" name="language-switch" value="qom" id="qom-input" <?php if ( chaco_get_language_cookie() === 'qo' ) { echo 'checked'; }; ?>>
				<label for="qom-input">Qom</label></li>
				<li><input type="radio" class="language-switch" name="language-switch" value="wichi" id="wichi-input" <?php if ( chaco_get_language_cookie() === 'wi' ) { echo 'checked'; }; ?>>
				<label for="wichi-input">Wichí</label></li>
				<li><input type="radio" class="language-switch" name="language-switch" value="moqoit" id="moqoit-input" <?php if ( chaco_get_language_cookie() === 'mo' ) { echo 'checked'; }; ?>>
				<label for="moqoit-input">Moqoit</label></li>
				<li><input type="radio" class="language-switch" name="language-switch" value="es" id="es-input" <?php if ( chaco_get_language_cookie() === 'es' ) { echo 'checked'; }; ?>>
				<label for="es-input">Español</label></li>
			</ul>

			<article class="sign-in-map">
				<p class="mobile-version"><span data-translation-id="instructivo-movil">Mantené presionada la pantalla del <br> mapa para agregar contenido</span>
					<button onclick="$(this).parent().hide()" style="position: absolute; top: 0; right: 0; border: 0; background: transparent;">X</button>
				</p>
			</article>
			<article class="sign-in-map">
				<p class="desktop-version"><span data-translation-id="instructivo-computadora">Hacé click derecho en el mapa para <br> agregar contenido</span>
					<button onclick="$(this).parent().hide()" style="position: absolute; top: 0; right: 0; border: 0; background: transparent;">X</button>
				</p>
			</article>
		</nav>
	</div>
	<div id='map'></div>

	<div id='sparql_filter_dialog' class="modal fade">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" tt='sparql_filter_dialog'></h4>
				</div>
				<div class="modal-body">

					<div style='margin-top:10px;margin-bottom:10px' tt='sparql_filter_desc'></div>

					<div>
						<form id='sparql_simple_form' class='form form-inline'>
							<div class="row">
								<div class="col-lg-12">
									<div class="input-group">
										<input type='text' id='sparql_filter_p31' class='form-control' tt_placeholder='ph_p31' />
										<span class="input-group-btn"><input type='submit' class='btn btn-secondary' tt_value='use_p31' /></span>
									</div>
								</div>
							</div>
						</form>
					</div>

					<div class="card" style='margin-top:10px'>
						<pre>SELECT ?q { /*...*/</pre>
						<textarea id='sparql_filter_query' style='width:100%' rows=5 tt_placeholder='sparql_filter_query_hint'></textarea>
						<pre>}</pre>
					</div>

					<div>
						<label><input type='checkbox' id='worldwide' value='1' /> <span tt='worldwide'></span></label>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" tt='close'></button>
					<button type="button" id='sparql_filter_clear' class="btn btn-danger" tt='clear_filter'></button>
					<button type="button" id='sparql_filter_use' class="btn btn-primary" tt='use_filter'></button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->


	<div id='search_dialog' class="modal fade">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" tt='search_title'></h4>
				</div>
				<div class="modal-body">

					<div>
						<form id='search_form' class='form form-inline'>
							<div class="row">
								<div class="col-lg-12">
									<div class="input-group">
										<input type='text' id='search_query' class='form-control' />
										<span class="input-group-btn"><input type='submit' class='btn btn-primary' tt_value='search' /></span>
									</div>
								</div>
							</div>
						</form>
					</div>

					<div class="card" id='search_results' style='display:none'>
						<ul class="list-group list-group-flush" id='search_results_list'></ul>
					</div>

				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->


	<div class="modal fade hide" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" tt="performing_action"></h4>
				</div>
				<div class="modal-body">
					<progress class="progress progress-striped progress-animated" value="100" max="100"></progress>
				</div>
			</div>
		</div>
	</div>

	<div id="search-filter-container">
		<button id="search-filter-toggler"><img src="lib/leaflet/images/layers-2x.png" alt="Mostrar/ocultar filtros de búsqueda"></button>
		<label>
			<input class="search-filter" type="checkbox" name="search-filter[]" value="moqoit" checked>Moqoit
		</label>
		<label>
			<input class="search-filter" type="checkbox" name="search-filter[]" value="qom" checked>Qom
		</label>
		<label>
			<input class="search-filter" type="checkbox" name="search-filter[]" value="wichi" checked>Wichí
		</label>
	</div>

	<div id="add-item-form-container" style="display: none;">
		<form id="add-item" action="add-item.php" method="post" enctype="multipart/form-data">
			<button class="close-form" type="button" onclick="$(this).parent().parent().hide()">X</button>
			<input type="hidden" name="lat" id="new-item-lat">
			<input type="hidden" name="long" id="new-item-lng">
			<input type="hidden" name="lang" id="new-item-lang" value="es">
			<label>
				<span data-translation-id="contenido">¿De qué trata el contenido? *</span>
				<select name="item-content-type" id="item-content-type" required>
					<option value="Q5" data-translation-id="contenido-persona">Persona</option>
					<option value="Q877729" data-translation-id="contenido-artesania">Artesanía</option>
					<option value="Q11639" data-translation-id="contenido-danza">Danza</option>
					<option value="Q82821" data-translation-id="contenido-tradicion">Tradición</option>
					<option value="Q132241" data-translation-id="contenido-festival">Festival</option>
					<option value="Q3305213" data-translation-id="contenido-pintura">Pintura</option>
					<option value="Q219423" data-translation-id="contenido-mural">Mural</option>
					<option value="Q93184" data-translation-id="contenido-dibujo">Dibujo</option>
					<option value="Q756" data-translation-id="contenido-planta">Planta/s</option>
					<option value="Q178706" data-translation-id="contenido-institucion">Institución</option>
					<option value="Q43229" data-translation-id="contenido-organizacion">Organización</option>
					<option value="Q16334295" data-translation-id="contenido-personas">Grupo de personas</option>
					<option value="Q11755880" data-translation-id="contenido-vivienda">Vivienda</option>
					<option value="Q860861" data-translation-id="contenido-escultura">Escultura</option>
					<option value="Q22075301" data-translation-id="contenido-tejido">Tejido</option>
					<option value="Q11410" data-translation-id="contenido-juegos">Juegos</option>
					<option value="Q756820" data-translation-id="contenido-culto">Culto</option>
					<option value="Q638" data-translation-id="contenido-musica">Música</option>
					<option value="Q2221906" data-translation-id="contenido-lugar">Sitio o lugar</option>
					<option value="Q1286517" data-translation-id="contenido-espacio">Espacio natural</option>
					<option value="Q42240" data-translation-id="contenido-investigacion">Investigación científica</option>
					<option value="Q9030487" data-translation-id="contenido-material-didactico">Material didáctico</option>
					<option value="Q729" data-translation-id="contenido-animal">Animal/es</option>
				</select>
			</label>

			<label>
				<span data-translation-id="titulo">Título</span> *
				<input type="text" name="title" id="new-item-titulo" placeholder="Título" required>
			</label>

			<label>
				<span data-translation-id="descripcion">Descripción</span> *
				<input type="text" name="description" id="new-item-description" placeholder="Descripción" required>
			</label>

			<p>
				<span data-translation-id="nation">Pueblo Nación</span> *
				<label>
					<input type="checkbox" name="nation[]" class="new-item-nation" value="qo"> Qom
				</label>
				<label>
					<input type="checkbox" name="nation[]" class="new-item-nation" value="wi"> Wichí
				</label>
				<label>
					<input type="checkbox" name="nation[]" class="new-item-nation" value="mo"> Moqoit
				</label>
			</p>

			<label>
				<span data-translation-id="archivo">Carga la imagen / Documentación (opcional)</span>
				<input type="file" name="image" id="new-item-image" accept=".jpg, .jpeg, .png, .gif, .svg, .webp, .tiff, .tif, .pdf, .oga, .ogg, .mp3, .wav, .ogv, .webm, .mpg, .mpeg, .avi" placeholder="Archivo">
			</label>

			<button class="submit-form" data-translation-id="enviar">Enviar</button>
		</form>
	</div>


	<div id="edit-item-form-container" style="display: none;">
		<form id="edit-item" action="edit-item.php" method="post" enctype="multipart/form-data">
			<button class="close-form" type="button" onclick="$(this).parent().parent().hide()">X</button>
			<input type="hidden" name="wikidata_item_id" id="wikidata_item_id">

			<label>
				<span data-translation-id="archivo">Carga la imagen / Documentación (opcional)</span>
				<input type="file" name="image" id="new-edit-item-image" accept=".jpg, .jpeg, .png, .gif, .svg, .webp, .tiff, .tif, .pdf, .oga, .ogg, .mp3, .wav, .ogv, .webm, .mpg, .mpeg, .avi" placeholder="Archivo">
			</label>

			<button class="submit-form" data-translation-id="enviar">Enviar</button>
		</form>
	</div>

	</main>
<footer>
    <a href="javascript:history.back()" class="go-back-link" data-translation-id="volver">< Volver</a>
    <p class="footer-text">Powered by <br>
        <a href="http://altcooperativa.com/" target="_blank">ALT - 2023</a></p>
</footer>

</body>

</html>
