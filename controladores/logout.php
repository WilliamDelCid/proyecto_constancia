<?php 

	class logout extends controladores{
		public function __construct()
		{
			parent::__construct();
			session_start();
			$eliminar_sesion = $this->modelo->eliminar("sesiones", 'token', token_sesion());
			session_unset();
			session_destroy();
			header('location: '.url_base().'/login');
		}

	}
 ?>