<?php
/**
 * 
 * 
 * @package     Motos&Servitecas_Web
 */
class MYS_Cargador
{
    public $plugin_mys_url;
    public $set_hooks;

    public function __construct()
    {
        $this->plugin_mys_url = plugins_url() . '/mys_woocommerce_service/';
        $this->set_hooks = [];
    }

    public function add_list_action( $action, $class, $function_class, $pos = 10, $args = 1)
    {
        $data_action = [
            'hook' => $action,
            'class' => $class,
            'function_class' => $function_class,
            'pos' => $pos,
            'args' => $args,
        ];
        array_push($this->set_hooks, $data_action);
    }

    public function run()
    {
        foreach ($this->set_hooks as $action_hook) {
            add_action($action_hook['hook'], [ $action_hook['class'], $action_hook['function_class'] ], $action_hook['pos'], $action_hook['args']);
        }
    }
}