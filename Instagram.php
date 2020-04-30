<?php
include ('Unsplash.php');
// Pour plus de facilité de transmission de votre travail et de correction, tout se passe dans 
//ce fichier. 

// Il y a donc une partie du code à réaliser ci-dessous et l'autre partie dans l'objet qui 
//se trouve dans ce même fichier

// Veuillez bien suivre les numéros : [1], [2] jusque [10] avec une question bonus [11]


// -------------------------------------------------


// Code et affichage

// [2] Initialisez l'objet Instagram dans une variable en choisissant un nom pour votre compte
$insta = new Instagram('JCVD');

// [4] Ajoutez 3 followers à votre compte et 5 comptes suivis. 
//Choisissez les noms comme vous voulez

$insta->ajoutFollower('JaimeLesChats');
$insta->ajoutFollower('JaimeLesChians');
$insta->ajoutFollower('JaimeLesPoissonsRouges');

$insta->ajoutSuivi('LesChatsRigolos');
$insta->ajoutSuivi('LesChiensRigolos');
$insta->ajoutSuivi('LesPoissonsRigolos');
$insta->ajoutSuivi('LesLapinsRigolos');
$insta->ajoutSuivi('LesAnimeauxRigolos');

// [6] Ajoutez 5 photos à votre compte
$insta->ajoutPhoto('Un Chat','moon', '2017-05-18');
$insta->ajoutPhoto('Un Chien', 'lark', '2017-09-25');
$insta->ajoutPhoto('Un Poisson', 'jonu', '2018-01-15');
$insta->ajoutPhoto('Un Lapin', 'aden', '2018-12-25');
$insta->ajoutPhoto('Un Oiseau', 'rise', '2019-02-01');

// [8] Faites des essais avec les 3 méthodes créées au point 7.

/*echo '<pre>';
print_r ($insta->getPhoto(2));
print_r ($insta->getFirstPhoto());
print_r ($insta->getLastPhoto());
echo '</pre>';*/

// [10] Affichez votre compte au format HTML

echo $insta->compteHTML();

// -------------------------------------------------


// Objet
class Instagram
{

	// Attributs
	public $nomDuCompte;
	public $nbFollowers;
	public $followers = [];
	public $nbSuivis;
	public $suivis = [];
	public $nbPhotos;
	public $photos = [];

	// Constructeur
	public function __construct($nom)
	{
		// [1] Le constructeur permet d'initialiser le nom du compte, le nombre de followers à 0, 
		//et le nombre de comptes suivis à 0

		$this->nomDuCompte = $nom;
		$this->nbFollowers = 0;
		$this->nbSuivis = 0;
		$this->nbPhotos = 0;
	}

	// [3] Créez 2 méthodes :
		// 	- 1 pour ajouter un nouveau follower (1 follower est défini par son nom)
		// 	- 1 pour ajouter un nouveau compte suivi (1 compte suivi est défini par son nom)
		// Le nombre de followers et de comptes suivis doivent être mis à jour en même temps

	public function ajoutFollower($name)
	{
		$this->nbFollowers += 1;
		$this->followers[] = $name;
		return true;
	}

	public function ajoutSuivi($name)
	{
		$this->nbSuivis += 1;
		$this->suivis[] = $name;
		return true;
	}

	// [5] Nous allons maintenant ajouter des photos
	// 1 photo est définie par plusieurs informations : 
	//		- nom
	//		- filtre (filtres possibles : moon, lark, juno, aden, rise, sierra, valencia)
	//		- date de publication au format AAAA-MM-JJ (exemple 2019-01-01 pour le premier Janvier)
	

	// Indications :
	// 		- La fonction d'ajout aura donc 3 paramètres
	// 		- Une photo sera représentée par un tableau associatif, et "rangée" dans l'attribut $photos de l'objet
	//		- Le nombre de photos doit être mis à jour en même temps

	public function ajoutPhoto($name, $filtre, $date)
	{
		$unsplash = new Unsplash();
		$unsplash->constructionURL();
		$unsplash->launch();
		$this->photos[] = [
			'nom' => $name,
			'filtre' => $filtre,
			'date de publication' => $date,
			'url' => $unsplash->extrairePhoto()[rand(0,9)],
		];
		$this->nbPhotos += 1;

		return true;
	}

	// [7] Créez 3 méthodes "getteurs" :
		//	- 1 pour retourner la toute première photo postée
		//  - 1 pour retourner la toute dernière photo postée
		//  - 1 pour retourner la photo en position N (cette méthode aura donc un paramètre)

	public function getFirstPhoto()
	{
		//return $this->photos[array_key_first($this->photos)]; -> PHP 7.3 mais wamp pas a jour mdr
		return $this->photos[0];
	}

	public function getLastPhoto()
	{
		return end($this->photos);
	}

	public function getPhoto($index)
	{
		if (array_key_exists($index, $this->photos)){
			return $this->photos[$index];
		}
		else{
			return 'mauvais index ...' . '<br/>';
		}
	}

	// [9] Créez une méthode récapitulative qui retourne au format HTML toutes les informations du compte :
		// Son nom
		// Le nombre de followers et leurs noms
		// Le nombre de comptes suivis et leurs noms
		// L'ensemble des photos postées
	public function compteHTML()
	{
		$out = '';
		
		$out .= '<h2>' . $this->nomDuCompte . '</h2>';
		$out .= $this->nbFollowers . 'Followers : ' . '<br/>';
		
		foreach ($this->followers as $followers){
			$out .= $followers . ', ';
		}

		$out .= '<br/>' . '<br/>';
		$out .= $this->nbSuivis . ' Suivis : ' . '<br/>';
		
		foreach ($this->suivis as $suivis){
			$out .= $suivis . ', ';
		}

		$out .= '<br/>' . '<br/>';
		$out .= $this->nbPhotos . ' Photos postées : ' . '<br/>';

		foreach ($this->photos as $photos){
			$out .= '<img src=' . $photos['url'] . '></img>' . '<br/>';
			$out .= $photos['nom'] . ', ' . 'Date : ' . $photos['date de publication'] . '<br/>'; 
			$out .= 'Filtre : ' . $photos['filtre'] . '<br/>' . '<br/>';  
		}

		return $out;
	}


	// [11] Question bonus : Créez une méthode permettant de retourner toutes les photos
	// comprises entre 2 dates différentes
}