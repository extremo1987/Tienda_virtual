<?php 

	class LoginModel extends Mysql
	{
		private $intIdUsuario;
		private $strUsuario;
		private $strPassword;
		private $strToken;

		public function __construct()
		{
			parent::__construct();
		}	

		public function loginUser(string $usuario, string $password)
		{
			$this->strUsuario = $usuario;
			$this->strPassword = $password;
			// La contraseña se verifica en PHP (password_verify), nunca dentro del SQL
			$sql = "SELECT idpersona,status,password FROM persona WHERE
					email_user = ? and
					status != 0 ";
			$request = $this->select($sql, [$this->strUsuario]);
			if (empty($request)) { return $request; }
			$hash = $request['password'];
			$ok = false;
			if (preg_match('/^[a-f0-9]{64}$/i', $hash)) {
				// Formato antiguo (SHA-256 sin sal): se acepta una vez y se migra a bcrypt
				$ok = hash_equals($hash, hash('sha256', $this->strPassword));
				if ($ok) {
					$this->update("UPDATE persona SET password = ? WHERE idpersona = ?", [password_hash($this->strPassword, PASSWORD_DEFAULT), $request['idpersona']]);
				}
			} else {
				$ok = password_verify($this->strPassword, $hash);
				if ($ok && password_needs_rehash($hash, PASSWORD_DEFAULT)) {
					$this->update("UPDATE persona SET password = ? WHERE idpersona = ?", [password_hash($this->strPassword, PASSWORD_DEFAULT), $request['idpersona']]);
				}
			}
			if (!$ok) { return []; }
			unset($request['password']);
			return $request;
		}

		public function sessionLogin(int $iduser){
			$this->intIdUsuario = $iduser;
			//BUSCAR ROLE 
			$sql = "SELECT p.idpersona,
							p.identificacion,
							p.nombres,
							p.apellidos,
							p.telefono,
							p.email_user,
							p.nit,
							p.nombrefiscal,
							p.direccionfiscal,
							r.idrol,r.nombrerol,
							p.status 
					FROM persona p
					INNER JOIN rol r
					ON p.rolid = r.idrol
					WHERE p.idpersona = ?";
			$request = $this->select($sql, [$this->intIdUsuario]);
			$_SESSION['userData'] = $request;
			return $request;
		}

		public function getUserEmail(string $strEmail){
			$this->strUsuario = $strEmail;
			$sql = "SELECT idpersona,nombres,apellidos,status FROM persona WHERE 
					email_user = ? and
					status = 1 ";
			$request = $this->select($sql, [$this->strUsuario]);
			return $request;
		}

		public function setTokenUser(int $idpersona, string $token){
			$this->intIdUsuario = $idpersona;
			$this->strToken = $token;
			$sql = "UPDATE persona SET token = ? WHERE idpersona = ? ";
			$arrData = array($this->strToken, $this->intIdUsuario);
			$request = $this->update($sql,$arrData);
			return $request;
		}

		public function getUsuario(string $email, string $token){
			$this->strUsuario = $email;
			$this->strToken = $token;
			$sql = "SELECT idpersona FROM persona WHERE 
					email_user = ? and
					token = ? and
					status = 1 ";
			$request = $this->select($sql, [$this->strUsuario, $this->strToken]);
			return $request;
		}

		public function insertPassword(int $idPersona, string $password){
			$this->intIdUsuario = $idPersona;
			$this->strPassword = $password;
			$sql = "UPDATE persona SET password = ?, token = ? WHERE idpersona = ? ";
			$arrData = array($this->strPassword,"", $this->intIdUsuario);
			$request = $this->update($sql,$arrData);
			return $request;
		}
	}
 ?>