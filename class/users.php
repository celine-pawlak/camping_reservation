<?php

require 'messages.php';

class users
{
    private $id_user;
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    public $register_date;
    public $is_admin;
    public $num_tel;
    public $db;

    public function __construct($host = "localhost", $username = "root", $password = "", $dbname = "camping")
    {
        try {
            $this->db = new PDO('mysql:dbname=' . $dbname . ';host=' . $host . '', $username, $password);
        } catch (PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
        }
    }

    public function connect($email, $password)
    {
        $q = $this->db->prepare("SELECT * FROM utilisateurs WHERE email = '$email'");
        $q->execute();
        $user = $q->fetch(PDO::FETCH_ASSOC);
        if (!empty($user)) {
            if (password_verify($password, $user['password'])) {
                $this->id_user = $user['id_utilisateur'];
                $this->firstname = $user['prenom'];
                $this->lastname = $user['nom'];
                $this->email = $user['email'];
                $this->password = $user['password'];
                $this->register_date = $user['register_date'];
                $this->is_admin = $user['is_admin'];
                $this->num_tel = $user['num_tel'];
                $_SESSION['user'] = [
                    'id_user' =>
                        $this->id_user,
                    'firstname' =>
                        $this->firstname,
                    'lastname' =>
                        $this->lastname,
                    'email' =>
                        $this->email,
                    'password' =>
                        $this->password,
                    'register_date' =>
                        $this->register_date,
                    'is_admin' =>
                        $this->is_admin,
                    'num_tel' =>
                        $this->num_tel
                ];
                return $_SESSION['user'];
            } else {
                $errors[] = "Le mail ou le mot de passe est erroné.";
                $message = new messages($errors);
                echo $message->renderMessage();
            }
        } else {
            $errors[] = "Le mail ou le mot de passe est erroné.";
            $test = new messages($errors);
            echo $test->renderMessage();
        }
    }

    public function register($firstname, $lastname, $email, $password, $password_check, $num_tel)
    {
        //firstname
        $firstname_required = preg_match("/^(?=.*[A-Za-z]$)[A-Za-z][A-Za-z\-]{2,19}$/", $firstname);
        if (!$firstname_required) {
            $errors[] = "Le prénom doit :<br>- Comporter entre 3 et 19 caractères.<br>- Commencer et finir par une lettre.<br>- Ne contenir aucun caractère spécial (excepté -).";
        }
        //lastname
        $lastname_required = preg_match("/^(?=.*[A-Za-z]$)([A-Za-z]{2,25}[\s]?[A-Za-z]{2,25})$/", $lastname);
        if (!$lastname_required) {
            $errors[] = "Le nom doit:<br>- Comporter entre 3 et 50 caractètres.<br>- Commencer et finir par une lettre.<br>- Ne contenir aucun caractère spécial (excepté un espace).";
        }
        //email
        $email_required = preg_match("/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/", $email);
        if (!$email_required) {
            $errors[] = "L'email n'est pas conforme.";
        }
        $q = $this->db->prepare("SELECT email FROM utilisateurs WHERE email = :email");
        $q->bindParam(':email', $email, PDO::PARAM_STR);
        $q->execute();
        $email_check = $q->fetch();
        if (!empty($email_check)) {
            $errors[] = "Cette adresse mail est déjà utilisée.";
        }
        //password
        $password_required = preg_match(
            "/^(?=.*?[A-Z]{1,})(?=.*?[a-z]{1,})(?=.*?[0-9]{1,})(?=.*?[\W]{1,}).{8,20}$/",
            $password
        );
        if (!$password_required) {
            $errors[] = "Le mot de passe doit contenir:<br>- Entre 8 et 20 caractères<br>- Au moins 1 caractère spécial<br>- Au moins 1 majuscule et 1 minuscule<br>- Au moins un chiffre.";
        }
        if ($password != $password_check) {
            $errors[] = "Les mots de passe ne correspondent pas.";
        } else {
            $password_modified = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));
        }
        //date
        date_default_timezone_set("Europe/Paris");
        //Phone number
        $num_tel_required = preg_match("/^[0-9]{10}$/", $num_tel);
        if (!$num_tel_required) {
            $errors[] = "Le numéro de téléphone doit contenir exactement 10 chiffres.";
        }
        if (empty($firstname) or empty($lastname) or empty($email) or empty($password) or empty($password_check) or empty($num_tel)) {
            $errors[] = "Tous les champs doivent être remplis.";
        }

        if (empty($errors)) {
            $q2 = $this->db->prepare(
                "INSERT INTO utilisateurs (nom, prenom, email, password, register_date, is_admin, num_tel) VALUES (:nom,:prenom,:email,:password,:register_date,:is_admin,:num_tel)"
            );
            $q2->bindParam(':nom', $lastname, PDO::PARAM_STR);
            $q2->bindParam(':prenom', $firstname, PDO::PARAM_STR);
            $q2->bindParam(':email', $email, PDO::PARAM_STR);
            $q2->bindParam(':password', $password_modified, PDO::PARAM_STR);
            $q2->bindValue(':register_date', date("Y-m-d H:i:s"), PDO::PARAM_STR);
            $q2->bindValue(':is_admin', 0, PDO::PARAM_INT);
            $q2->bindParam(':num_tel', $num_tel, PDO::PARAM_STR);
            $q2->execute();
            header('connexion.php');
        } else {
            $message = new messages($errors);
            echo $message->renderMessage();
        }
    }

    public
    function disconnect()
    {
        $this->id_user = "";
        $this->firstname = "";
        $this->lastname = "";
        $this->email = "";
        $this->password = "";
        $this->register_date = "";
        $this->is_admin = "";
        $this->num_tel = "";
        session_unset();
        session_destroy();
        header('Location:index.php');
    }

    public
    function isConnected()
    {
        if (empty($_SESSION['user'])) {
            return false;
        } else {
            return true;
        }
    }

    public
    function delete(
        $password
    ) {
        if (password_verify($password, $this->password)) {
            $q = $this->db->prepare("DELETE FROM utilisateurs WHERE id_utilisateur = :id");
            $q->bindParam(':id', $this->id_user, PDO::PARAM_STR);
            $q->execute();
            $this->disconnect();
        } else {
            $errors[] = "Le mot de passe est erroné.";
            $message = new messages($errors);
            echo $message->renderMessage();
        }
    }

    public function modifyPassword($old_password, $new_password, $confirm_password)
    {
        if (password_verify($old_password, $this->password)) {
            if ($old_password == $new_password) {
                $errors[] = "Vous devez entrer un nouveau mot de passe.";
            }
            if ($new_password != $confirm_password) {
                $errors[] = "Les mots de passe ne correspondent pas.";
            } elseif (empty($errors) and $new_password == $confirm_password) {
                $password_modified = password_hash($new_password, PASSWORD_BCRYPT, array('cost' => 10));
                $q = $this->db->prepare("UPDATE utilisateurs SET password = :password WHERE id_utilisateur = :id");
                $q->bindParam(':password', $password_modified, PDO::PARAM_STR);
                $q->bindParam(':id', $this->id_user, PDO::PARAM_INT);
                $q->execute();
                $this->password = $password_modified;
                return [$this->password];
            }
            $message = new messages($errors);
            echo $message->renderMessage();
        } else {
            $errors[] = "L'ancien mot de passe est erroné.";
            $message = new messages($errors);
            echo $message->renderMessage();
        }
    }
    /*    public function modifyLogin{

        }*/

//GETTERS
    /**
     * @return mixed
     */
    public
    function getIdUser()
    {
        return $this->id_user;
    }

    /**
     * @return mixed
     */
    public
    function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @return mixed
     */
    public
    function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @return mixed
     */
    public
    function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public
    function getRegisterDate()
    {
        return $this->register_date;
    }

    /**
     * @return mixed
     */
    public
    function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public
    function getIsAdmin()
    {
        return $this->is_admin;
    }

    /**
     * @return mixed
     */
    public function getNumTel()
    {
        return $this->num_tel;
    }
}
