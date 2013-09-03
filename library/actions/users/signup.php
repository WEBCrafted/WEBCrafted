<?php
if(
    !isset(
        $_POST["token"],
        $_POST["username"],
        $_POST["password"],
        $_POST["password2"],
        $_POST["email"]
    )) {
    setFlash("Un champ est manquant.", "error");
}
else {
    if($_POST["password"] != $_POST["password2"]) {
        setFlash("Les mots de passe sont différents", "error");
    }
    else {
        if($_users->userExists($_POST["username"])) {
            setFlash("Le pseudo existe déjà. Choisissez-en un autre !", "error");
        }
        else {
            $group = $_groups->getDefaultGroup();
            $id = DataBase::read(PREFIX . "users", array("fields" => array("id"), "limit" => 1, "order" => array("method" => "DESC")));

            if(empty($id))
                $id = 1;
            else
                $id = current($id) + 1;

            $success = $_users->signup(
                $id,
                $_POST["username"],
                $_POST["password"],
                $_POST["email"],
                $group["id"]
            );

            if(!$success) {
                setFlash("Impossible de vous inscrire, réessayez", "error");
            }
            else {
                setFlash("Votre êtes inscrit sous {$_POST["username"]}", "success");
                redirect("login");
            }
        }
    }
}

redirect("signup");
