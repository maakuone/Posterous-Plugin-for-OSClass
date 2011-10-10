<?php
/*
Plugin Name: Posterous Plugin
Plugin URI: http://www.osclass.org/
Description: This plugin allows you to post to posterous.
Version: .1
Author: maakuone
Author URI: http://mark.lomongo.net
*/

    function info_call_after_install() {
    }

    function info_call_after_uninstall() {
    }

    function auto_post($itemId) {
        $item = Item::newInstance()->findByPrimaryKey($itemId);
        $title  = $item['s_title'];
        View::newInstance()->_exportVariableToView('item', $item);
        $contactEmail   = "post@posterous.com";
        $contactName    = "posterous";
        $item_url = osc_item_url();
        $item_url = '<a href="'.$item_url.'" >'.$item_url.'</a>';

        $item_url2 = '<a href="'.$item_url.'" >'.$item_url.'</a>';
        $body = $item['s_description'] . '<p/> For more details visit ' . $item_url;
        $emailParams =  array (
                            'subject'  => $title
                            ,'to'       => $contactEmail
                            ,'to_name'  => $contactName
                            ,'body'     => $body
                            ,'alt_body' => $body
                        );
        osc_sendMail($emailParams) ;
    }

    osc_add_hook('item_premium_on', 'auto_post') ;

    // This is needed in order to be able to activate the plugin
    osc_register_plugin(osc_plugin_path(__FILE__), 'info_call_after_install');
    // This is a hack to show a Uninstall link at plugins table (you could also use some other hook to show a custom option panel)
    osc_add_hook(osc_plugin_path(__FILE__). '_uninstall', 'info_call_after_uninstall');
?>