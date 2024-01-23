<?php

namespace controllers;

use utils\Template;
use utils\EmailUtils;
use utils\SessionHelpers;
use models\EmprunterModel;
use models\EmprunteurModel;
use controllers\base\WebController;
use models\ExemplaireModel;
use models\RessourceModel;
use models\AdministrateurModel;

use function PHPSTORM_META\type;

class UserController extends WebController
{
    // On déclare les modèles utilisés par le contrôleur.
    private EmprunteurModel $emprunteur; // Modèle permettant d'interagir avec la table emprunteur
    private EmprunterModel $emprunter; // Modèle permettant l'emprunt
    private AdministrateurModel $admin; // Modèle permettant l'administration

    function __construct()
    {
        $this->emprunteur = new EmprunteurModel();
        $this->emprunter = new EmprunterModel();
        $this->admin = new AdministrateurModel();
    }

    /**
     * Déconnecte l'utilisateur.
     * @return string
     */
    function logout(): string
    {
        SessionHelpers::logout();
        return $this->redirect("/");
    }

    /**
     * Affiche la page de connexion.
     * Si l'utilisateur est déjà connecté, il est redirigé vers sa page de profil.
     * Si la connexion échoue, un message d'erreur est affiché.
     * @return string
     */
    function login(): string
    {
        $data = array();

        // Si l'utilisateur est déjà connecté, on le redirige vers sa page de profil
        if (SessionHelpers::isConnected()) {
            return $this->redirect("/me");
        }


        // Gestion de la connexion
        if (isset($_POST["email"]) && isset($_POST["password"])) {
            $result = $this->emprunteur->connexion($_POST["email"], $_POST["password"]);

            // Si la connexion est réussie, on redirige l'utilisateur vers sa page de profil
            if (gettype($result) == "boolean" && $result == true) {
                $this->redirect("/me");
            } else {
                // Sinon, on affiche un message d'erreur
                $_SESSION["error"] = $result;
            }
            $this->redirect("/login");
        }

        // Affichage de la page de connexion
        return Template::render("views/user/login.php");
    }

    /**
     * Affiche la page d'inscription.
     * Si l'utilisateur est déjà connecté, il est redirigé vers sa page de profil.
     * Si l'inscription échoue, un message d'erreur est affiché.
     * @return string
     */
    function signup(): string
    {
        $data = array();

        // Si l'utilisateur est déjà connecté, on le redirige vers sa page de profil
        if (SessionHelpers::isConnected()) {
            return $this->redirect("/me");
        }

        if (isset($_POST['etatTel'])) {
            $etatTel = htmlspecialchars($_POST['etatTel']);
            if ($etatTel == "oui") {
                $etatTel = 1;
            } else {
                $etatTel = 0;
            }
        }


        // Gestion de l'inscription
        if (isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confPassword"]) && isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["tel"]) && isset($etatTel)) {
            $pass = htmlspecialchars($_POST["password"]);
            $passConf = htmlspecialchars($_POST["confPassword"]);
            // Vérification de la validité des données
            if ($pass != $passConf) {
                $data["error"] = "Les mots de passe ne correspondent pas";
                return Template::render("views/user/signup.php", $data);
            }
            $password_regex = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";
            if (preg_match($password_regex, $pass) == 0) {
                $data["error"] = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial";
                return Template::render("views/user/signup.php", $data);
            }

            $result = $this->emprunteur->creerEmprenteur($_POST["email"], $_POST["password"], $_POST["nom"], $_POST["prenom"], $_POST["tel"], $etatTel);

            // Si l'inscription est réussie, on affiche un message de succès
            if ($result) {
                return Template::render("views/user/signup-success.php");
            } else {
                // Sinon, on affiche un message d'erreur
                $data["error"] = "La création du compte a échoué";
            }
        } else {
            // Affichage de la page d'inscription
            return Template::render("views/user/signup.php", $data);
        }

        // Affichage de la page d'inscription
        return Template::render("views/user/signup.php", $data);
    }

    function signupValidate($uuid)
    {
        $result = $this->emprunteur->validateAccount($uuid);

        if ($result) {
            // Affichage de la page de finalisation de l'inscription
            return Template::render("views/user/signup-validate-success.php");
        } else {
            $_SESSION['ErreurCompte'] = "Une erreur s'est produite lors de la validation de votre compte, veuillez réessayer. Si le problème persiste, veuillez contacter l'administrateur du site.";
            return parent::redirect("/");
        }
    }

    /**
     * Affiche la page de profil de l'utilisateur connecté.
     * Si l'utilisateur n'est pas connecté, il est redirigé vers la page de connexion.
     * @return string
     */
    function me(): string
    {
        // Récupération de l'utilisateur connecté en SESSION.
        // La variable contient les informations de l'utilisateur présent en base de données.
        $user = SessionHelpers::getConnected();

        // Récupération des emprunts de l'utilisateur
        $emprunts = $this->emprunter->getEmprunts($user->idemprunteur);

        return Template::render("views/user/me.php", array("user" => $user, "emprunts" => $emprunts));
    }


    function updateUser()
    {
        $user = SessionHelpers::getConnected();
        if (isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["email"]) && isset($_POST["telephone"]) && isset($_POST["etatTel"])) {
            $nom = htmlspecialchars($_POST["nom"]);
            $prenom = htmlspecialchars($_POST["prenom"]);
            $email = htmlspecialchars($_POST["email"]);
            $telephone = htmlspecialchars($_POST["telephone"]);
            $etatTel = htmlspecialchars($_POST["etatTel"]);
            $id = $user->idemprunteur;

            if (isset($_POST["old_password"]) && isset($_POST["new_password"]) && isset($_POST["confirm_password"])) {
                if ($_POST["old_password"] == "" && $_POST["new_password"] == "" && $_POST["confirm_password"] == "") {
                    $old_password = $user->motpasseemprunteur;
                    $new_password = $user->motpasseemprunteur;
                    $confirm_password = $user->motpasseemprunteur;
                } else {
                    if (empty($_POST["old_password"]) || empty($_POST["new_password"]) || empty($_POST["confirm_password"])) {
                        $_SESSION["erreur"] = "Veuillez remplir tous les champs mot de passe";
                        $this->redirect("/me");
                    } else {
                        $old_password = htmlspecialchars($_POST["old_password"]);
                        $new_password = htmlspecialchars($_POST["new_password"]);
                        $confirm_password = htmlspecialchars($_POST["confirm_password"]);


                        // vérification ancien mot de passe
                        if (password_verify($old_password, $user->motpasseemprunteur)) {
                            // vérification nouveau mot de passe
                            if ($new_password == $confirm_password) {
                                $new_password = password_hash($new_password, PASSWORD_BCRYPT);
                            } else {
                                $_SESSION["erreur"] = "Les nouveaux mots de passe ne correspondent pas";
                                $this->redirect("/me");
                            }
                        } else {
                            $_SESSION["erreur"] = "L'ancien mot de passe est incorrect";
                            $this->redirect("/me");
                        }
                    }
                }
            }
            $update = $this->emprunteur->updateUser($user, $nom, $prenom, $email, $telephone, $etatTel, $new_password);
            if ($update == true) {
                $_SESSION["validation"] = "Vos informations ont bien été modifiées";
            } else {
                $_SESSION["erreur"] = "Une erreur est survenue lors de la modification de vos informations";
            }
            $this->redirect("/me");
        } else {
            return Template::render("views/user/updateUser.php", array('user' => $user));
        }
    }



    /**
     * Affiche la page de profil d'un utilisateur.
     * Si l'utilisateur n'est pas connecté, il est redirigé vers la page de connexion.
     * Pour accéder à la page il faut également l'id de la ressource et l'id de l'exemplaire.
     * @return string
     */
    function emprunter()
    {

        // Id à emprunter
        $idRessource = htmlspecialchars($_POST["idRessource"]);
        $idExemplaire = htmlspecialchars($_POST["idExemplaire"]);

        // Récupération de l'utilisateur connecté en SESSION.
        $user = SessionHelpers::getConnected();

        if ($user == null | $idRessource == null | $idExemplaire == null) {
            // Gestion d'erreur à améliorer
            $_SESSION["Erreur"] = "Une erreur interne s'est produite, veuillez nous excuser pour la gêne occasionnée";
            $this->redirect("/me");
        }


        // Vérifie si l'utilisateur possède déjà 3 emprunts en cours
        $nbEmpruntEnCours = $this->emprunter->getNbEmpruntEnCours($user->idemprunteur);

        if ($nbEmpruntEnCours->nbEmprunt >= 3) {

            // Gestion d'erreur à améliorer
            $_SESSION["Erreur"] = "Vous avez déjà dépassé le quota d'emprunt en cours, vous ne pouvez pas emprunter de ressource supplémentaire pour le moment";
            $this->redirect("/me");
        } else {

            // On déclare l'emprunt, et on redirige l'utilisateur vers sa page de profil
            $result = $this->emprunter->declarerEmprunt($idRessource, $idExemplaire, $user->idemprunteur);

            if ($result) {
                $user = SessionHelpers::getConnected();
                $ressourceM = new RessourceModel();
                $laRessource = $ressourceM->getOne($idRessource);
                EmailUtils::sendEmail(
                    $user->emailemprunteur,
                    "Emprunt de $laRessource->titre",
                    "confirmEmprunt",
                    array(
                        //"url" => $config["URL_VALIDATION"] . $UUID,
                        "user" => $user->prenomemprunteur . " " . $user->nomemprunteur,
                        "ressource" => $laRessource->titre,
                        "email" => $user->emailemprunteur,
                        "dateEmprunt" => date("d/m/Y"),
                        "dateRetour" => date("d/m/Y", strtotime("+1 month"))

                    )
                );
                $_SESSION["validation"] = "Votre emprunt à été pris en compte, un email de confirmation à été envoyé à votre adresse mail";
                $this->redirect("/me");
            } else {
                // Gestion d'erreur à améliorer
                $_SESSION["Erreur"] = "Erreur lors de l'emprunt";
                $this->redirect("/me");
            }
        }
    }

    function etatTel()
    {
        $user = SessionHelpers::getConnected();
    }

    function dlDataUser()
    {
        $user = SessionHelpers::getConnected();
        $id = $user->idemprunteur;

        $dataUser = $this->emprunteur->getDataUser($id);

        // on modifie la valeur d'etatTel pour qu'elle soit plus lisible
        $dataUser['user']->etatTel = ($dataUser['user']->etatTel == 1) ? "Affiche" : "Masque";

        $formattedData = [];
        foreach ($dataUser as $key => $value) {
            $formattedData[$key] = $value;
        }

        $jsonData = json_encode($formattedData, JSON_PRETTY_PRINT);

        $file = fopen("dataUser.json", "w");
        fwrite($file, $jsonData);
        fclose($file);

        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="dataUser.json"');
        header('Content-Length: ' . filesize("dataUser.json"));
        readfile("dataUser.json");
        unlink("dataUser.json");
    }

    function commenter()
    {
        $user = SessionHelpers::getConnected()->idemprunteur;
        $idRessource = htmlspecialchars($_POST["idRessource"]);
        $commentaire = htmlspecialchars($_POST["commentaire"]);
        $rating = htmlspecialchars($_POST["rating"]);
        $date = date("Y-m-d");

        $result = $this->emprunteur->commenter($idRessource, $user, $commentaire, $rating);
        if ($result) {
            $_SESSION["validation"] = "Votre commentaire à été pris en compte, il sera visible après validation par un administrateur";
            $this->redirect("/catalogue/detail/$idRessource");
        } else {
            $_SESSION["Erreur"] = "Une erreur est survenue lors de l'ajout de votre commentaire, veuillez réessayer. Si le problème persiste, veuillez contacter l'administrateur du site.";
            $this->redirect("/catalogue/detail/$idRessource");
        }
    }

    function administration()
    {
        $user = SessionHelpers::getConnected();
        $data = $this->admin->getData();
        return Template::render("views/user/administration.php", array('user' => $user, 'data' => $data));
    }

    function forgot()
    {
        return Template::render("views/user/forgot.php");
    }

    function reinitMdp()
    {

        $email = strip_tags($_POST["email"]);

        $result = $this->emprunteur->reinitialisationMdp($email);

        if (isset($_SESSION['Erreur'])) {
            return parent::redirect("/");
        } else {

            // Affichage de la page de finalisation de la réinitialisation du mot de passe
            $_SESSION["success"] = "Si l'adresse mail est valide, un mail de réinitialisation de mot de passe vous a été envoyé.";
            return parent::redirect("/forgot");
        }
    }

    function reinitMdpValidate($uuid)
    {
        // récupération de l'expiration du token
        $expirationToken = $this->emprunteur->getExpirationToken($uuid);

        if ($expirationToken == false) {
            $_SESSION["error"] = "Le lien de réinitialisation de mot de passe a expiré, veuillez réessayer.";
            return parent::redirect("/forgot");
        }



        if (!isset($_POST["password"]) && !isset($_POST["confPassword"])) {
            return Template::render("views/user/reinitialisation.php", array('uuid' => $uuid));
        }
        /* var_dump($uuid, $_POST); die(); */
        $pass = htmlspecialchars($_POST["password"]);
        $confPass = htmlspecialchars($_POST["confPassword"]);

        // Vérification de la validité des données
        if ($pass != $confPass) {
            $_SESSION["error"] = "Les mots de passe ne correspondent pas";
            return Template::render("views/user/reinitialisation.php", array('uuid' => $uuid));
        }
        $password_regex = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";
        if (preg_match($password_regex, $pass) == 0) {
            $_SESSION["data"] = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial";
            unset($_POST["password"]);
            unset($_POST["confPassword"]);
            return parent::redirect("/reinitMdp/$uuid");
        } else {
            $pass = password_hash($pass, PASSWORD_BCRYPT);
            $update = $this->emprunteur->updateMdp($uuid, $pass);
            if ($update) {
                $_SESSION["success"] = "Votre mot de passe a bien été modifié, vous pouvez vous connecter avec votre nouveau mot de passe.";
                // Affichage de la page de finalisation de l'inscription
                return parent::redirect("/login");
            } else {
                $_SESSION['ErreurCompte'] = "Une erreur s'est produite lors de la validation de votre compte, veuillez réessayer. Si le problème persiste, veuillez contacter l'administrateur du site.";
                return parent::redirect("/");
            }
        }
    }

    function deleteUser()
    {
        $user = SessionHelpers::getConnected();
        $id = $user->idemprunteur;
        $email = $user->emailemprunteur;
        $password = $user->motpasseemprunteur;
        if (isset($_POST["delete_email"]) && isset($_POST["delete_password"]) && isset($_POST["check"])) {


            $formEmail = htmlspecialchars($_POST["delete_email"]);
            $fromPassword = htmlspecialchars($_POST["delete_password"]);

            if ($formEmail != $email || !password_verify($fromPassword, $password)) {
                $_SESSION["Erreur"] = "L'adresse mail ou le mot de passe est incorrect";
                return parent::redirect("/me");
            } else {
                unset($_SESSION['LOGIN']);
                $result = $this->emprunteur->deleteUser($id, $email);


                if ($result) {
                    SessionHelpers::logout();
                    $_SESSION["Success"] = "Votre compte a bien été supprimé";
                    return parent::redirect("/");
                } else {
                    $_SESSION["Erreur"] = "Une erreur est survenue lors de la suppression de votre compte, veuillez réessayer. Si le problème persiste, veuillez contacter l'administrateur du site.";
                    return parent::redirect("/me");
                }
            }
        } else {
            $_SESSION["Erreur"] = "Veuillez remplir tous les champs";
            return parent::redirect("/me");
        }
    }
}
