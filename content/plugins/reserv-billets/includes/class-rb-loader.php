<?php

/**
 * RB_Spectacle_Loader
 * ===========
 *
 * Le Loader de tous les éléments.
 *
 * @package RB
 */
class RB_Loader
{
	const PRIORITÉ_DÉFAUT = 10; // La priorité d'exécution par défaut des hooks.
	const ARGS_ACCEPTÉS_DÉFAUT = 1; // Le nb d'arguments acceptés par défaut des callbacks des hooks.

	/** @var Array Les actions */
	protected $actions;
	/** @var Array Les filtres */
	protected $filters;

	/**
	 * Constructeur.
	 *
	 * Crée les listes de queues d'actions et de filtres.
	 */
	public function __construct()
	{
		$this->actions = array();
		$this->filters = array();
	}

	/**
	 * Ajoute une action à la liste.
	 * Note: Les actions ne sont pas encore appliqués à ce stade-là;
	 *
	 * @see RB_Loader::run() <<< C'est là qu'ils sont appliqués.
	 *
	 * @param String $tag           L'identifiant de l'action. Exemple: "init"
	 * @param Mixed  $composant     Le composant (objet) ayant la fonction à assigner à l'action.
	 * @param String $fnCallback    La fonction dans la composante qui sera appelée par l'action.
	 * @param int    $priorité      La priorité d'exécution de l'action.
	 * @param int    $args_acceptés Le nb d'arguments acceptés par le callback de l'action.
	 */
	public function queue_action( $tag, $composant, $fnCallback, $priorité = self::PRIORITÉ_DÉFAUT, $args_acceptés = self::ARGS_ACCEPTÉS_DÉFAUT )
	{
		$this->actions = self::add( $this->actions, $tag, $composant, $fnCallback, $priorité, $args_acceptés );
	}

	/**
	 * Ajoute un filtre dans la table de filtres.
	 * Note: Les filtres ne sont pas encore appliqués à ce stade-là;
	 *
	 * @see RB_Loader::run() <<< C'est là qu'ils sont appliqués.
	 *
	 * @param String $tag           L'identifiant du filtre. Exemple: "the_content"
	 * @param Mixed  $composant     Le composant (objet) ayant la fonction à assigner au filtre.
	 * @param String $fnCallback    La fonction dans la composante qui sera appelée pour le filtre.
	 * @param int    $priorité      La priorité d'exécution du filtre.
	 * @param int    $args_acceptés Le nb d'arguments acceptés par le callback du filtre.
	 */
	public function queue_filter( $tag, $composant, $fnCallback, $priorité = self::PRIORITÉ_DÉFAUT, $args_acceptés = self::ARGS_ACCEPTÉS_DÉFAUT )
	{
		$this->filters = self::add( $this->filters, $tag, $composant, $fnCallback, $priorité, $args_acceptés );
	}

	/**
	 * Ajoute un hook dans l'exécution de Wordpress.
	 *
	 * N'ayant nul besoin de savoir le type de hook impliqué, cette fonction représente vulgairement
	 * l'immigré mexicain illégal qui prend tes meubles et qui les transporte dans le camion de déménagement!
	 *
	 * > NOTE DE FÉLIX: <br />
	 * > On va changer cte description-là, assurément.
	 *
	 * @see   RB_Loader::queue_action
	 * @see   RB_Loader::queue_filter
	 * @see   add_action
	 * @see   add_filter
	 *
	 * @param        $hookListe     Array La liste d'actions ou de filtres auquel on ajoutera le hook
	 *                              (voir 3 prochains params).
	 * @param String $tag           L'identifiant du hook. <u>Exemple pour une action:</u> <em>"init"</em>
	 * @param Mixed  $composant     Le composant <u>(objet)</u> ayant la fonction à assigner au hook.
	 * @param String $fnCallback    La fonction dans la composante qui sera appelée pour le hook.
	 * @param int    $priorité      La priorité d'exécution.
	 * @param int    $args_acceptés Le nb d'arguments acceptés par le callback.
	 *
	 * @return Array La liste des hooks auquel on a ajouté un hook avec les 3
	 *                 derniers paramètres.
	 */
	private static function add(array $hookListe, $tag, $composant, $fnCallback, $priorité, $args_acceptés)
	{
		// Pousser les 5 derniers paramètres dans la liste de hooks.
		$hookListe[] = array(
			'tag' => $tag,
			'composant' => $composant,
			'fnCallback' => $fnCallback,
			'priorité' => $priorité,
			'args_acceptés' => $args_acceptés
		);

		// Retourner la liste des hooks.
		return $hookListe;
	}

	/**
	 * Ajoutes toutes les actions et tous les filtres qui ont été mis dans les deux listes
	 * afin que leurs contenus soient considérés durant l'exécution du core de Wordpress.
	 *
	 * @see   RB_Spectacle::run()
	 */
	public function run()
	{
		// Parcourir l'array de filtres qui ont été assignés à l'avance.
		foreach ( $this->filters as $filter ) {
			// Ajouter un filtre à WP.
			add_filter(
				$filter['tag'],
	            array( $filter['composant'], $filter['fnCallback'] ),
	            $filter['priorité'],
	            $filter['args_acceptés']
			);
		}

		// Parcourir l'array d'actions qui ont été assignées à l'avance.
		foreach ( $this->actions as $action ) {
			// Ajouter une action à WP.
			add_action(
				$action['tag'],
	            array( $action['composant'], $action['fnCallback'] ),
	            $action['priorité'],
	            $action['args_acceptés']
			);
		}
	}
}