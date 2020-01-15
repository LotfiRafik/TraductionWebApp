<?php

namespace controller;
use model\traducteur;
use model\offre;
use model\traduction;


class Traducteurcontroleur extends \core\Controller\controller {

	public function rendreTraduction()
	{ 
		if(isset($_POST) && !empty($_POST))
		{
            //Insertion du traduction dans la base de donnée
			$traduction = new traduction();
			$array['traducteur_id']=$_SESSION['id'];
			$array['devis_id']=$_POST['devis_id'];
			$dest = "aa";
            $traduction->ajouter($array);
            //uploader le fichier traduit
            if (isset($_FILES['document']) AND $_FILES['document']['error']== 0)
            {
                $infosfichier = pathinfo($_FILES['document']['name']);
                $extension = $infosfichier['extension'];
                $dest = 'TraductionDocuments/'.$array['devis_id'].'_'.$_SESSION['id'].'.'.$extension ;
                move_uploaded_file($_FILES['document']['tmp_name'],$dest);
            }
			//Inserer le chemin du fichier dans la table 
            $traduction->update(array('file_path' => $dest),$array);    
        }
		$this->home();
	}

	public function ajouterOffre()
	{
		/*
            inserer une offre 
        */
		$offre = new offre();
		$array['traducteur_id']=$_SESSION['id'];
		$array['devis_id']=$_POST['devis_id'];
		$array['prix']=$_POST['prix'];
		$offre->ajouter($array);
		$this->home();
	}


    public function liste()
	{
		$traducteur = new traducteur();
		$liste = $traducteur->liste();
		//$liste : tableau d'objets  $liste = $data ;
		$this->render('profiles/profiles',$liste);
	}

	public function profile($id)
	{
		$array['id'] = $id;
		$traducteur = new traducteur();
		$data = $traducteur->listec($array);
		$this->render('profiles/traducteur_profile',$data);
	}

}
