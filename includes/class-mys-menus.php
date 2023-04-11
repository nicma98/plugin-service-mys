<?php

/**
 * Registrar todas los menús y submenús de mi plugin
 * 
 * @package     Motos&Servitecas_Web
 */

/**
 * Agrega todos los menús y submenus a utilizar en el plugin
 * donde los métodos add_menu_page() y add_submenu_page()
 * tienen que ser llamados junto con el gancho
 * de acción 'admin_menu'
 * 
 * @package     Motos&Servitecas_Web
 * 
 * @property array $menus
 * @property array $submenus
 */
class MYS_Menus {
    
    /**
	 * El array de menús a registrar en WordPress.
	 */
    protected $menus;
    
    /**
	 * El array de submenús a registrar en WordPress.
	 */
    protected $submenus;
    
    public function __construct()
	{    
        $this->menus = [];
        $this->submenus = [];   
    }
    
    /**
	 * Añade un nuevo menú al array ($this->menus) a iterar para registrarlo en WordPress.
     * 
	 * @param    string    $pageTitle        El texto que se mostrará en las etiquetas de título de la página cuando se selecciona el menú.
	 * @param    string    $menuTitle        El texto que se utilizará para el menú.
	 * @param    string    $capability       La capacidad necesaria para que este menú se muestre al usuario.
	 * @param    string    $menuSlug         El nombre del slug para referirse a este menú por (debe ser único para este menú).
	 * @param    callable  $functionName     La función a la que se llama para emitir el contenido de esta página.
	 * @param    string    $iconUrl          (Opcional) La URL del icono que se va a utilizar para este menú. Valor por defecto: ''
	 * @param    int       $position         (Opcional) La posición en el orden de los menús debería aparecer. Valor por defecto: null
	 */
    public function add_menu_page( $pageTitle, $menuTitle, $capability, $menuSlug, $functionName, $iconUrl = '', $position = null ) {
        
        $this->menus = $this->add_menu( $this->menus, $pageTitle, $menuTitle, $capability, $menuSlug, $functionName, $iconUrl, $position );
        
    }
    
    /**
	 * Función de utilidad que se utiliza para ir agregando los menús para iterar.
     * 
	 * @param    array     $menus            La colección de ganchos que se está registrando (es decir, acciones o filtros).
	 * @param    string    $pageTitle        El texto que se mostrará en las etiquetas de título de la página cuando se selecciona el menú.
	 * @param    string    $menuTitle        El texto que se utilizará para el menú.
	 * @param    string    $capability       La capacidad necesaria para que este menú se muestre al usuario.
	 * @param    string    $menuSlug         El nombre del slug para referirse a este menú por (debe ser único para este menú).
	 * @param    callable  $functionName     La función a la que se llama para emitir el contenido de esta página.
	 * @param    string    $iconUrl          (Opcional) La URL del icono que se va a utilizar para este menú. Valor por defecto: ''
	 * @param    int       $position         (Opcional) La posición en el orden de los menús debería aparecer. Valor por defecto: null
     * 
	 * @return   array                       La colección de menús para proceder a iterar y registrarlos en WordPress en el método run().
	 */
    private function add_menu( $menus, $pageTitle, $menuTitle, $capability, $menuSlug, $functionName, $iconUrl, $position ) {
        
        $menus[] = [
            'pageTitle'     => $pageTitle,
            'menuTitle'     => $menuTitle,
            'capability'    => $capability,
            'menuSlug'      => $menuSlug,
            'functionName'  => $functionName,
            'iconUrl'       => $iconUrl,
            'position'      => $position
        ];
        
        return $menus;
        
    }
    
    /**
	 * Añade un nuevo menú al array ($this->menus) a iterar para registrarlo en WorlññññdPress.
     * 
	 * @param    string    $parentSlug       El nombre de slug para el menú principal (o el nombre de archivo de una página de administración de WordPress estándar).
	 * @param    string    $pageTitle        El texto que se mostrará en las etiquetas de título de la página cuando se selecciona el menú.
	 * @param    string    $menuTitle        El texto que se utilizará para el menú.
	 * @param    string    $capability       La capacidad necesaria para que este menú se muestre al usuario.
	 * @param    string    $menuSlug         El nombre del slug para referirse a este menú por (debe ser único para este menú).
	 * @param    callable  $functionName     La función a la que se llama para emitir el contenido de esta página.
	 */
    public function add_submenu_page( $parentSlug, $pageTitle, $menuTitle, $capability, $menuSlug, $functionName ) {
        
        $this->submenus = $this->add_submenu( $this->submenus, $parentSlug, $pageTitle, $menuTitle, $capability, $menuSlug, $functionName );
        
    }    
    
    /**
	 * Función de utilidad que se utiliza para ir agregando los menús para iterar.
     * 
	 * @param    array     $submenus         La colección de ganchos que se está registrando (es decir, acciones o filtros).
	 * @param    string    $parentSlug       El nombre de slug para el menú principal (o el nombre de archivo de una página de administración de WordPress estándar).
	 * @param    string    $pageTitle        El texto que se mostrará en las etiquetas de título de la página cuando se selecciona el menú.
	 * @param    string    $menuTitle        El texto que se utilizará para el menú.
	 * @param    string    $capability       La capacidad necesaria para que este menú se muestre al usuario.
	 * @param    string    $menuSlug         El nombre del slug para referirse a este menú por (debe ser único para este menú).
	 * @param    callable  $functionName     La función a la que se llama para emitir el contenido de esta página.
     * 
	 * @return   array                       La colección de submenús para proceder a iterar y registrarlos en WordPress en el método run().
	 */
    private function add_submenu( $submenus, $parentSlug, $pageTitle, $menuTitle, $capability, $menuSlug, $functionName) {
        
        $submenus[] = [
            'parentSlug'    => $parentSlug,
            'pageTitle'     => $pageTitle,
            'menuTitle'     => $menuTitle,
            'capability'    => $capability,
            'menuSlug'      => $menuSlug,
            'functionName'  => $functionName
        ];
        
         return $submenus;
        
    }
    
    /**
	 * Registra los menús y submenús con WordPress.
	 */
    public function run() {
        
        foreach( $this->menus as $menus ) {
            
            extract( $menus, EXTR_OVERWRITE );
            
            add_menu_page( $pageTitle, $menuTitle, $capability, $menuSlug, $functionName, $iconUrl, $position );
            
        }
        
        foreach( $this->submenus as $submenus ) {
            
            extract( $submenus, EXTR_OVERWRITE );
            
            add_submenu_page( $parentSlug, $pageTitle, $menuTitle, $capability, $menuSlug, $functionName );
            
        }
        
    }
    
}
















