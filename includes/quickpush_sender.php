<?php  
/*
 * @package WP_QUICK_PUSH
 * @version 1.0
 * Let's Push Page
 */
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $quickpush_title = ($_POST['quickpush_push_title']) ? stripslashes(sanitize_text_field($_POST['quickpush_push_title'])) : "";
    $quickpush_content = ($_POST['quickpush_push_content']) ? stripslashes(sanitize_text_field($_POST['quickpush_push_content'])) : "";
    $quickpush_url = ($_POST['quickpush_push_url']) ? sanitize_text_field($_POST['quickpush_push_url']) : "";
    if (get_option('quickpush_appID') == null || get_option('quickpush_restApi') == null) { ?>
    <div class="error"><p><strong><?php _e('Incomplete details! Kindly check Parse.com Account settings and try again.' ); ?></strong></p></div>
    <?php } elseif(empty($quickpush_title) || !isset($quickpush_title)){ ?>
    <div class="error"><p><strong><?php _e('Title is a required field. Kindly enter the title and try again.' ); ?></strong></p></div>
    <?php } elseif(empty($quickpush_url) || !isset($quickpush_url)){
        if(isset($quickpush_content) || !empty($quickpush_content)){ 
            $set_title = $quickpush_title;
            $set_content = $quickpush_content; ?>
    <div class="error"><p><strong><?php _e('Customized Json Push requires a URL field. Kindly enter a valid URL and try again.' ); ?></strong></p></div>
        <?php } } else {  
            include('quickpush_engine.php');
            $json = array('title' => $quickpush_title,'content' => stripslashes($quickpush_content),'url' => $quickpush_url);
            if(empty($quickpush_content) && empty($quickpush_url)){
                $push_status_json = quickpushme(get_option('quickpush_appID'), get_option('quickpush_restApi'), $quickpush_title, get_option('quickpush_pushChannels'), false);
            } else {
                $push_status_json = quickpushme(get_option('quickpush_appID'), get_option('quickpush_restApi'), $json, get_option('quickpush_pushChannels'), true);
            }
            $push_status = json_decode($push_status_json,true);
            if($push_status['result']){ ?>
    <div class="updated"><p><strong><?php _e('Push sent successfully.'); ?></strong></p></div>            
    <?php } else { ?>
    <div class="error"><p><strong><?php _e('Something went wrong. Check your settings again.'); ?></strong></p></div>            
    <?php }
    }
}   
?>
<div class="wrap">    
    <div id="icon-options-push" class="icon32"></div>
    <h2>WP Quick Push</h2>    
    <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-2">        
            <div id="post-body-content">                
                <div class="meta-box-sortables ui-sortable">                                        
                    <div class="postbox">
                        <h3><span>For your information:</span></h3>                        
                        <div class="inside">
                            <p class='description'>This Push Message can be send in two different ways:</p>
                                <ol>
                                    <li><strong>Standard Alert Push:</strong> If you just specify the title of the push below,
<pre>
{
"alert": "This is an Example Push"
}
</pre>
                                        then it will go as an alert to all channels or GBC.</li>
                                    <li><strong>Customized Json Push:</strong> This feature is for advanced Apps crafted to receive custom Json data. We're still advancing with this feature, but you can use 3 fields for now, that is,
<pre>
{
"title": "This is an Example Push",
"content": "This is short description about the push being sent."
"url" : "http://www.example.com"
}
</pre>
                                        and it will go as Json data to all channels or GBC.
                                    </li>
                                </ol>                            
                            <form name="sendPush_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
                                <table class="form-table">
                                    <tr valign="top">
                                        <td scope="row">
                                            <label for="tablecell"><i><?php _e("Title:"); ?></i></label>                                            
                                            <p class='description'>json{"title"}</p>
                                        </td>
                                        <td>
                                            <input type="text" placeholder="eg. Explain how awesome can this push be." name="quickpush_push_title" style="width:90%;" required="required" value="<?php echo ($set_title)? $set_title : ""; ?>" />
                                            <p class='description'>Keep it short and sweet.</p>
                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <td scope="row">
                                            <label for="tablecell"><i><?php _e("Content:"); ?></i></label>
                                            <p class='description'>json{"content"}</p>
                                        </td>
                                        <td>
                                            <textarea name="quickpush_push_content" placeholder="If not specified, then this push will go as a standard alert." style="width:90%;"><?php echo $set_content; ?></textarea>
                                            <p class='description'>Max. 100 characters or otherwise it will be trimed and affect the interface.</p>
                                        </td>                                        
                                    </tr>
                                    <tr valign="top">
                                        <td scope="row">
                                            <label for="tablecell"><i><?php _e("URL:"); ?></i></label>
                                            <p class='description'>json{"url"}</p>
                                        </td>
                                        <td>
                                            <input type="text" placeholder="If not specified, then this push will go as a standard alert." name="quickpush_push_url" style="width:90%;" />
                                            <p class='description'><code>http://</code> or <code>https://</code> is required with the URL.</p>
                                        </td>
                                    </tr>                                   
                                    <tr valign="top">
                                        <td scope="row">
                                            <label for="tablecell"><i><?php _e("Broadcast Type:"); ?></i></label>                                            
                                        </td>
                                        <td>
                                            <p class='description'><?php echo (get_option('quickpush_noChannel')=='true') ? _e('Everyone') : _e('Channels'); ?></p>
                                        </td>
                                    </tr>                                   
                                </table>                                
                                <p class="submit">  
                                    <input type="submit" name="Submit" class="button button-primary" value="<?php _e('Push It!') ?>" />  
                                </p> 
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