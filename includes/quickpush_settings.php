<?php  
/**
 * @package WP_QUICK_PUSH
 * @version 1.0
 * Settings Page
 */
if(isset( $_POST['quickpush_hidden'] ) && ( $_POST['quickpush_hidden'] == 'Y' )) {  
//Form data sent 
    $JoeAppName = sanitize_text_field($_POST['quickpush_appName']);
    update_option('quickpush_appName', $JoeAppName); 

    $JoeAppID = sanitize_text_field($_POST['quickpush_appID']);
    update_option('quickpush_appID', $JoeAppID);  

    $JoeRestApi = sanitize_text_field($_POST['quickpush_restApi']);  
    update_option('quickpush_restApi', $JoeRestApi); 

    $JoeEnableSound = '';
    if (isset($_POST['quickpush_enableSound'])) {  
        update_option('quickpush_enableSound', 'true');
        $JoeEnableSound = ' checked="checked"';
    }
    else
        update_option('quickpush_enableSound', 'false');

    $JoeNoChannel = '';
    if (isset($_POST['quickpush_noChannel'])) {  
        update_option('quickpush_noChannel', 'true');
        $JoeNoChannel = ' checked="checked"';
    }
    else
        update_option('quickpush_noChannel', 'false');

    $JoePushChannels = trim(sanitize_text_field($_POST['quickpush_pushChannels']), " ");
    update_option('quickpush_pushChannels', $JoePushChannels); ?>  
    <div class="updated"><p><strong><?php _e('WP Quick Push settings saved. Let\'s Push!'); ?></strong></p></div>  
<?php
} else {  
    //Normal page display  
    $JoeAppName   = get_option('quickpush_appName');
    $JoeAppID     = get_option('quickpush_appID');  
    $JoeRestApi   = get_option('quickpush_restApi'); 
    $JoeAutoSendTitle = '';
    if (get_option('quickpush_autoSendTitle') == 'true') 
            $JoeAutoSendTitle = ' checked="checked"';
    $JoeSaveLastMessage = '';
    if (get_option('quickpush_saveLastMessage') == 'true') 
        $JoeSaveLastMessage = ' checked="checked"';
    $JoeEnableSound = '';
    if (get_option('quickpush_enableSound') == 'true') 
        $JoeEnableSound = ' checked="checked"';

    $JoePushChannels = get_option('quickpush_pushChannels');

    $JoeNoChannel = '';
    if (get_option('quickpush_noChannel') == 'true') 
        $JoeNoChannel = ' checked="checked"';
} ?>
<div class="wrap">    
    <div id="icon-options-general" class="icon32"></div>
    <h2>WP Quick Push Settings</h2>    
    <div id="poststuff">    
        <div id="post-body" class="metabox-holder columns-2">        
            <div id="post-body-content">                
                <div class="meta-box-sortables ui-sortable">                    
                    <div class="postbox">                    
                        <div class="inside">
                            <form name="quickpush_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
                                <h3>
                                    <span><?php    echo __( 'Parse.com Push Service - Settings', 'quickpush_trdom' ) . " (Parse.com <a href=\"http://parse.com/apps\" target=\"_blank\">Dashboard</a>)"; ?>  </span>                                    
                                </h3>                        
                                <input type="hidden" name="quickpush_hidden" value="Y">                                  
                                <table class="form-table">
                                    <tr valign="top">
                                        <td scope="row"><label for="tablecell"><?php _e("Application name: " ); ?></label></td>
                                        <td><input type="text" name="quickpush_appName" placeholder="e.g. John Smith's App" value="<?php echo $JoeAppName; ?>" style="width:90%;"></td>
                                    </tr>
                                    <tr valign="top">
                                        <td scope="row"><label for="tablecell"><i><?php _e("Application ID: " ); ?></i></label></td>
                                        <td><input type="text" name="quickpush_appID" placeholder="Paste the Application ID from the Parse.com Dashboard > Settings > Keys" value="<?php echo $JoeAppID; ?>" style="width:90%;"></td>
                                    </tr>
                                    <tr valign="top">
                                        <td scope="row"><label for="tablecell"><i><?php _e("REST API Key: " ); ?></i></label></td>
                                        <td><input type="text" name="quickpush_restApi" placeholder="Paste the REST API Key from the Parse.com Dashboard > Settings > Keys" value="<?php echo $JoeRestApi; ?>" style="width:90%;"></td>
                                    </tr>
                                    <tr valign="top">
                                        <td scope="row"><label for="tablecell">Sound</label></td>
                                        <td>
                                            <input type="checkbox" name="quickpush_enableSound"<?php echo $JoeEnableSound; ?> /> Enable
                                            <p class="description">Enables the default sound for Push Alerts.</p>
                                        </td>
                                    </tr>                                    
                                </table>                                
                                <hr/>
                                <table class="form-table">
                                    <tr valign="top">
                                        <td scope="row"><label for="tablecell">Push channels</label></td>
                                        <td><input type="text" name="quickpush_pushChannels" placeholder="e.g. arts,fitness,political" value="<?php echo $JoePushChannels; ?>" class="regular-text">
                                            <p class="description"><strong>Comma</strong> separated (Space Counted) names for channels to be receiving the notifications. If not specified, then by default Global Broadcast Channel (GBC) shall be selected.</p>
                                        </td>
                                    </tr>
                                    <tr valign="top" >
                                        <td scope="row"><label for="tablecell"></label></td>
                                        <td><input type="checkbox" name="quickpush_noChannel" <?php echo $JoeNoChannel; ?> > Do not include channels, just send notifications to everyone.</td>
                                    </tr>
                                </table>
                                                                
                                <hr />
                                <p class="submit">
                                    <input type="submit" name="Submit" class="button button-primary" value="<?php _e('Save Settings', 'quickpush_trdom' ) ?>" />
                                </tr>
                            </form>
                        </div>                    
                    </div>                    
                </div>                
            </div>                                      
            <?php include('quickpush_sidebar.php'); ?>
        </div>        
        <br class="clear">
    </div>    
</div>