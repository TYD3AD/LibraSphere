<?php

namespace models;

use models\base\SQL;
use utils\EmailUtils;
use utils\SessionHelpers;
use utils\TokenHelpers;

class EmprunteurModel extends SQL
{
    public function __construct()
    {
        parent::__construct('emprunteur', 'idemprunteur');
    }

    public function connexion(mixed $email, mixed $password)
    {
        /**
         * Rappel
         *
         * La validation du compte est un int qui prend plusieurs valeurs :
         * 0 : Compte non validé
         * 1 : email validé
         * 2 : Compte validé par un admin
         * 3 : Compte banni
         * 4 : Compte supprimé
         */

        // TODO Il ne faut pas autoriser la connexion si le compte n'est pas validé
        try {
            $sql = 'SELECT * FROM emprunteur WHERE emailemprunteur = ?';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute([$email]);
            $user = $stmt->fetch(\PDO::FETCH_OBJ);

            if ($user != null) {

                switch ($user->validationcompte) {
                    case 0:
                        return "Votre compte n'a pas encore été validé. Veuillez vérifier vos emails.";
                    case 1:
                    case 2:
                        return password_verify($password, $user->motpasseemprunteur)
                            ? (SessionHelpers::login($user) && SessionHelpers::email($email) && true)
                            : "Email ou mot de passe incorrect";
                    case 3:
                        return "Votre compte a été banni.";
                    case 4:
                        return "Email ou mot de passe incorrect";
                    default:
                        return "Erreur lors de la connexion.";
                }
            } else {
                return "Email ou mot de passe incorrect";
            }
        } catch (\Exception $e) {
            die($e->getMessage());
            return "Erreur lors de la connexion : " . $e->getMessage();
        }
    }


    public function creerEmprenteur(mixed $email, mixed $password, mixed $nom, mixed $prenom, mixed $tel, mixed $etatTel): bool
    {
        // Création du hash du mot de passe (pour le stockage en base de données)
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $config = include("configs.php");

        try {

            $sql = "SELECT * FROM emprunteur WHERE emailemprunteur = ?";
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute([$email]);
            $result = $stmt->fetch(\PDO::FETCH_OBJ);
            if ($result == null) {

                // Création de l'utilisateur en base de données.

                // La validation du compte est un int qui prend plusieurs valeurs :
                // 0 : Compte non validé
                // 1 : email validé
                // 2 : Compte validé par un admin
                // 3 : Compte banni
                // 4 : Compte supprimé

                $UUID = TokenHelpers::guidv4(); // Génération d'un UUID v4, qui sera utilisé pour la validation du compte
                $sql = 'INSERT INTO emprunteur (emailemprunteur, motpasseemprunteur, nomemprunteur, prenomemprunteur, datenaissance, telportable, etatTel, validationcompte, validationtoken) VALUES (?, ?, ?, ?, NOW(), ?, ?, 0, ?)';
                $stmt = parent::getPdo()->prepare($sql);
                $result = $stmt->execute([$email, $password_hash, $nom, $prenom, $tel, $etatTel, $UUID]);

                if ($result) {
                    // Envoi d'un email de validation du compte
                    // On utilise la fonction sendEmail de la classe EmailUtils
                    // L'email contient un lien vers la page de validation du compte, avec l'UUID généré précédemment
                    EmailUtils::sendEmail(
                        $email,
                        "Bienvenue $nom",
                        "newAccount",
                        array(
                            "url" => $config["URL_VALIDATION"] . '/valider-compte/' . $UUID,
                            "email" => $email,
                            "password" => $password
                        )
                    );
                }

                return true;
            } else {
                // L'email existe déjà en base de données
                return false;
            }
        } catch (\Exception $e) {
            die($e->getMessage());
            return false;
        }
    }

    public function validateAccount($uuid)
    {

        $sql = 'SELECT * FROM emprunteur WHERE validationtoken = ?';
        $stmt = parent::getPdo()->prepare($sql);
        $result = $stmt->execute([$uuid]);
        if ($result) {
            $user = $stmt->fetch(\PDO::FETCH_ASSOC);
            if ($user) {
                $id = $user['idemprunteur'];
                $sql = 'UPDATE emprunteur SET validationcompte = 1, validationtoken = NULL WHERE idemprunteur = ?';
                $stmt = parent::getPdo()->prepare($sql);
                $result = $stmt->execute([$id]);
                if ($result) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Récupère tous les utilisateurs sans leur mot de passe.
     * @return array
     */
    public function getAllWithoutPassword(): array
    {
        $all = parent::getAll();

        // Ici, on utilise la fonction array_map qui permet d'appliquer une fonction sur tous les éléments d'un tableau
        // L'autre solution est d'utiliser une boucle foreach ou via une requête SQL avec un SELECT qui ne récupère pas le mot de passe
        return array_map(function ($user) {
            // On supprime le mot de passe de l'utilisateur
            unset($user->motpasseemprunteur);

            // On retourne l'utilisateur
            return $user;
        }, $all);
    }

    public function updateUser($user, $nom, $prenom, $email, $telephone, $etatTel, $new_password)
    {
        if ($new_password != $user->motpasseemprunteur) {
            $sql = 'UPDATE emprunteur SET nomemprunteur = ?, prenomemprunteur = ?, emailemprunteur = ?, motpasseemprunteur = ?, telportable = ?, etatTel = ? WHERE idemprunteur = ?';
            $param = [$nom, $prenom, $email, $new_password, $telephone, $etatTel, $user->idemprunteur];
        } else {
            $sql = 'UPDATE emprunteur SET nomemprunteur = ?, prenomemprunteur = ?, emailemprunteur = ?, telportable = ?, etatTel = ? WHERE idemprunteur = ?';
            $param = [$nom, $prenom, $email, $telephone, $etatTel, $user->idemprunteur];
        }
        try {
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute($param);

            $_SESSION['LOGIN']->nomemprunteur = $nom;
            $_SESSION['LOGIN']->prenomemprunteur = $prenom;
            $_SESSION['LOGIN']->emailemprunteur = $email;
            $_SESSION['LOGIN']->telportable = $telephone;
            $_SESSION['LOGIN']->etatTel = $etatTel;
            $_SESSION['LOGIN']->motpasseemprunteur = $new_password;

            return true;
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public function getDataUser($id)
    {
        try {
            $sql = 'SELECT nomemprunteur, prenomemprunteur, datenaissance, emailemprunteur, telportable, etatTel FROM emprunteur WHERE idemprunteur = ?';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute([$id]);
            $user = $stmt->fetch(\PDO::FETCH_OBJ);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
        try {
            $sql = 'SELECT titre, libellecategorie, datedebutemprunt, dateretour FROM emprunter INNER JOIN ressource ON emprunter.idressource = ressource.idressource INNER JOIN categorie ON ressource.idcategorie = categorie.idcategorie WHERE idemprunteur = ?';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute([$id]);
            $emprunts = $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
        return array("user" => $user, "emprunts" => $emprunts);
    }

    public function commenter($idRessource, $id, $commentaire, $rating)
    {

        try {
            $sql = 'INSERT INTO commentaire (id_commentaire, id_ressource, id_emprunteur, commentaire, date_commentaire, evaluation, etat_commentaire) VALUES (NULL, ?, ?, ?, NOW(), ?, 0)';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute([$idRessource, $id, $commentaire, $rating]);
            $_SESSION['Succes'] = "Votre commentaire a bien été pris en compte ! Il sera visible après validation par un administrateur.";
            return $_SESSION['Succes'];
        } catch (\Exception $e) {
            die($e->getMessage());
            $_SESSION['Erreur'] = "Erreur lors de l'ajout du commentaire : " . $e->getMessage();
            return $_SESSION['Erreur'];
        }
    }

    public function reinitialisationMdp($email)
    {
        try {
            $sql = 'SELECT * FROM emprunteur WHERE emailemprunteur  = ?';
            $stmt = parent::getPdo()->prepare($sql);
            $result = $stmt->execute([$email]);
            if ($result) {
                $user = $stmt->fetch(\PDO::FETCH_ASSOC);
                if ($user) {
                    if ($user['validationcompte'] == 1 || $user['validationcompte'] == 2) {
                        $UUID = TokenHelpers::guidv4(); // Génération d'un UUID v4, qui sera utilisé pour la validation du compte
                        // On ajoute une date d'expiration de l'UUID = à 30 minutes après la génération. le type de la colonne est timestamp


                        $sql = 'UPDATE emprunteur SET validationtoken = ?, timetoken = NOW() + INTERVAL 30 MINUTE WHERE idemprunteur = ?';
                        $stmt = parent::getPdo()->prepare($sql);
                        $result = $stmt->execute([$UUID, $user['idemprunteur']]);
                        if ($result) {
                            $config = include("configs.php");
                            // Envoi d'un email de validation du compte
                            // On utilise la fonction sendEmail de la classe EmailUtils
                            // L'email contient un lien vers la page de validation du compte, avec l'UUID généré précédemment
                            EmailUtils::sendEmail(
                                $email,
                                "Reinitialisation de votre mot de passe",
                                "reinitMdp",
                                array(
                                    "url" => $config["URL_VALIDATION"] . '/reinitMdp/' . $UUID,
                                    "email" => $email,
                                )
                            );
                        }
                    } else {
                        return $_SESSION['Erreur'] = "Votre compte n'a pas encore été validé. Veuillez vérifier vos emails.";
                    }
                } else {
                    // L'email n'existe pas en base de données
                }
            }
        } catch (\Exception $e) {
            die($e->getMessage());
            return $_SESSION['Erreur'] = "Erreur lors de la réinitialisation du mot de passe : " . $e->getMessage();
        }
    }

    public function updateMdp($uuid, $pass)
    {
        try {
            $sql = 'SELECT * FROM emprunteur WHERE validationtoken = ?';
            $stmt = parent::getPdo()->prepare($sql);
            $result = $stmt->execute([$uuid]);
            if ($result) {
                $user = $stmt->fetch(\PDO::FETCH_ASSOC);
                if ($user) {
                    $sql = 'UPDATE emprunteur SET motpasseemprunteur = ?, validationtoken = null WHERE idemprunteur = ?';
                    $stmt = parent::getPdo()->prepare($sql);
                    $result = $stmt->execute([$pass, $user['idemprunteur']]);
                    if ($result) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    // L'email n'existe pas en base de données
                }
            }
        } catch (\Exception $e) {
            die($e->getMessage());
            return false;
        }
    }

    public function getExpirationToken($uuid)
    {
        try {
            $sql = 'SELECT timetoken FROM emprunteur WHERE validationtoken = ?';
            $stmt = parent::getPdo()->prepare($sql);
            $result = $stmt->execute([$uuid]);
            if ($result) {
                $user = $stmt->fetch(\PDO::FETCH_ASSOC);
                if ($user) {
                    // si le token est expiré
                    if ($user['timetoken'] < date("Y-m-d H:i:s")) {
                        $_SESSION["error"] = "Le lien de réinitialisation de mot de passe a expiré, veuillez réessayer.";
                        try {
                            $sql = 'UPDATE emprunteur SET validationtoken = null, timetoken = null WHERE validationtoken = ?';
                            $stmt = parent::getPdo()->prepare($sql);
                            $result = $stmt->execute([$uuid]);
                        } catch (\Exception $e) {
                            return $_SESSION['Erreur'] = "Erreur lors de la réinitialisation du mot de passe : " . $e->getMessage();
                        }
                    } else {
                        return true;
                    }
                } else {
                    // L'email n'existe pas en base de données
                }
            }
        } catch (\Exception $e) {
            die($e->getMessage());
            return false;
        }
    }

    public function deleteUser($id, $email)
    {
        try {
            $sql = 'SELECT * FROM emprunteur WHERE idemprunteur = ?';
            $stmt = parent::getPdo()->prepare($sql);
            $result = $stmt->execute([$id]);
            if ($result) {
                $user = $stmt->fetch(\PDO::FETCH_ASSOC);
                if ($user) {
                    if ($user['emailemprunteur'] == $email) {
                        $sql = 'UPDATE emprunteur SET validationcompte = 4, archive = 1 WHERE idemprunteur = ? AND emailemprunteur = ?';
                        $stmt = parent::getPdo()->prepare($sql);
                        $result = $stmt->execute([$id, $email]);
                        if ($result) {
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (\Exception $e) {
            die($e->getMessage());
            return false;
        }
    }
}
