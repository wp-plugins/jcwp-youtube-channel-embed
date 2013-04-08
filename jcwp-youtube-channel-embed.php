<?php
  /*
    Plugin Name: jcwp youtube channel embed
    Plugin URI: http://jaspreetchahal.org/wordpress-youtube-channel-embed-plugin
    Description: This plugin embeds a custom channel to wordpress page or post
    Author: JasChahal
    Version: 1.5.1
    Author URI: http://jaspreetchahal.org
    License: GPLv2 or later
    */

    /*
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    */
    
    // if not an admin just block access
    if(preg_match('/admin\.php/',$_SERVER['REQUEST_URI']) && is_admin() == false) {
        return false;
    }

    register_activation_hook(__FILE__,'jcorgytce_activate');
    function jcorgytce_activate() {
            add_option('jcorgytce_mode','list');
            add_option('jcorgytce_thumbnail_width',240);
            add_option('jcorgytce_video_width',640);
            add_option('jcorgytce_show_title','yes');
            add_option('jcorgytce_max_results',6);
            add_option('jcorgytce_start_index',1);
            add_option('jcorgytce_order_by',"published");
            add_option('jcorgytce_filter_by_keyword',"");
            add_option('jcorgytce_channel_name',"");
            add_option('jcorgytce_thumb_quality',"1");
            add_option('jcorgytce_use',"frame");
            add_option('jcorgytce_linkback',"no");
    }
    add_action("admin_menu","jcorgytce_menu");
    function jcorgytce_menu() {
        add_options_page('JCWP Youtube channel embed', 'JCWP Youtube channel embed', 'manage_options', 'jcorgytce-plugin', 'jcorgytce_plugin_options');
    }
    add_action('admin_init','jcorgytce_regsettings');
    function jcorgytce_regsettings() {        
        register_setting("jcorgytce-setting","jcorgytce_mode");
        register_setting("jcorgytce-setting","jcorgytce_thumbnail_width");
        register_setting("jcorgytce-setting","jcorgytce_video_width");
        register_setting("jcorgytce-setting","jcorgytce_show_title");     
        register_setting("jcorgytce-setting","jcorgytce_max_results");     
        register_setting("jcorgytce-setting","jcorgytce_start_index");     
        register_setting("jcorgytce-setting","jcorgytce_order_by");     
        register_setting("jcorgytce-setting","jcorgytce_filter_by_keyword");     
        register_setting("jcorgytce-setting","jcorgytce_channel_name");     
        register_setting("jcorgytce-setting","jcorgytce_thumb_quality");
        register_setting("jcorgytce-setting","jcorgytce_use");
        register_setting("jcorgytce-setting","jcorgytce_linkback");    
        wp_enqueue_script('jquery');
    }   
    
    add_action('wp_footer','jcorgytce_inclscript_foot',100);
	function jcorgytce_inclscript_foot() {
		if(get_option('jcorgytce_linkback') =="Yes") {
            echo '<a style="margin-left:45%;color:#f1f1f1;font-size:0.2em !important;" href="http://jaspreetchahal.org/wordpress-youtube-channel-embed-plugin">Youtube channel embed is powered by http://jaspreetchahal.org</a>';
        }
	}
    add_action('wp_head','jcorgytce_inclscript',100);
    function jcorgytce_inclscript() {
	global $post;

{
        wp_enqueue_script('jquery');
        wp_enqueue_script('jcorgytce_pp',plugins_url("jquery.prettyPhoto.js",__FILE__),array('jquery'));
        wp_enqueue_script('jcorgytce_ytce',plugins_url("jcorgYoutubeUserChannelEmbed.js",__FILE__),array('jquery'));
        wp_enqueue_style('jcorgytce_ppstyle',plugins_url("css/prettyPhoto.css",__FILE__));
        wp_enqueue_style('jcorgytce_ytcestyle',plugins_url("css/jcYoutubeChannelEmbedd.css",__FILE__));
        
        
}
    }
     function jcorgcrYTEMShortCodeHandler($atts) {
        global $wpdb;
        extract(shortcode_atts(array(
            "mode"=>"list",
            "videowidth"=>"640",
            "thumbnailwidth"=>"240",
            "showtitle"=>'yes',
            "maxresults"=>"6",
            "startindex"=>"1",
            "orderby"=>"published",
            "filterkeyword"=>"none",
            "channelname"=>"jassiechahal",
            "thumbquality"=>"1",
            "embedType"=>"frame",
            ),$atts));
        $uniq_id = uniqid("jvorgyt_");
        return "<div id='$uniq_id'></div><div style='clear:both !important'>&nbsp;</div>
             <script type=\"text/javascript\">
                    jQuery(document).ready(function(){
                        jQuery(\"#$uniq_id\").jcorgYoutubeUserChannelEmbed({
                            mode:'".($mode?$mode:'list')."',
                            videoWidth:'".(intval($videowidth)>0?$videowidth:640)."',
                            thumbnailWidth:'".(intval($thumbnailwidth)>0?$thumbnailwidth:240)."',
                            showTitle:".($showtitle == 'yes'?'true':'false').",
                            maxResults:'".($maxresults?$maxresults:6)."',
                            startIndex:'".($startindex?$startindex:1)."',
                            thumbQuality:'".($thumbquality != ''?$thumbquality:0)."',
                            orderBy:'".($orderby?$orderby:'published')."',
                            filterKeyword:'".($filterkeyword != 'none'?$filterkeyword:'')."',
                            channelUserName:'$channelname',
                            useIncl:'".($embedtype?$embedtype:'frame')."'
                        });     
                    });
             </script>
        ";
        
    }

    add_shortcode('jcorg_youtube_channel','jcorgcrYTEMShortCodeHandler');
    function jcorgytce_plugin_options() {
        jcorgytceDonationDetail();           
        ?> 
        <style type="text/css">
        .jcorgbsuccess, .jcorgberror {   border: 1px solid #ccc; margin:0px; padding:15px 10px 15px 50px; font-size:12px;}
        .jcorgbsuccess {color: #FFF;background: green; border: 1px solid  #FEE7D8;}
        .jcorgberror {color: #B70000;border: 1px solid  #FEE7D8;}
        .jcorgb-errors-title {font-size:12px;color:black;font-weight:bold;}
        .jcorgb-errors { border: #FFD7C4 1px solid;padding:5px; background: #FFF1EA;}
        .jcorgb-errors ul {list-style:none; color:black; font-size:12px;margin-left:10px;}
        .jcorgb-errors ul li {list-style:circle;line-height:150%;/*background: url(/images/icons/star_red.png) no-repeat left;*/font-size:11px;margin-left:10px; margin-top:5px;font-weight:normal;padding-left:15px}
        td {font-weight: normal;}
        </style><br>
        <div class="wrap" style="float: left;" >
            <?php             
            
            screen_icon('tools');?>
            <h2>JaspreetChahal's youtube custom channel enbed settings</h2>
            <?php 
                $errors = get_settings_errors("",true);
                $errmsgs = array();
                $msgs = "";
                if(count($errors) >0)
                foreach ($errors as $error) {
                    if($error["type"] == "error")
                        $errmsgs[] = $error["message"];
                    else if($error["type"] == "updated")
                        $msgs = $error["message"];
                }

                echo jcorgytceMakeErrorsHtml($errmsgs,'warning1');
                if(strlen($msgs) > 0) {
                    echo "<div class='jcorgbsuccess' style='width:90%'>$msgs</div>";
                }

            ?><br><br> 
            
            <form action="options.php" method="post" id="jcorgbotinfo_settings_form">
            <?php settings_fields("jcorgytce-setting");?>

    <table class="widefat" style="width: 700px;" cellpadding="7">
                 <tr valign="top">
                    <th scope="row">Channel mode</th>
                    <td><input type="radio" name="jcorgytce_mode" <?php if(get_option('jcorgytce_mode') == "list" || get_option('jcorgytce_mode') == "") echo "checked='checked'";?>
                            value="list" 
                            /> List
                            <input type="radio" name="jcorgytce_mode" <?php if(get_option('jcorgytce_mode') == "thumbnails") echo "checked='checked'";?>
                            value="thumbnails" 
                            /> Thumbnails 
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Channel name</th>
                    <td><input type="text" name="jcorgytce_channel_name"
                            value="<?php echo get_option('jcorgytce_channel_name'); ?>"  style="padding:5px" size="40"/>
                    </td>
                </tr> 
                <tr valign="top">
                    <th scope="row">Maximum results</th>
                    <td><input type="number" name="jcorgytce_max_results"
                            value="<?php echo get_option('jcorgytce_max_results'); ?>"  style="padding:5px" size="40"/>
                    </td>
                </tr> 
                <tr valign="top">
                    <th scope="row">Start Index</th>
                    <td><input type="number" name="jcorgytce_start_index"
                            value="<?php echo get_option('jcorgytce_start_index'); ?>"  style="padding:5px" size="40"/><br>(Pointer from where the videos should be shown. Handy, if you want to show videos from a given position)
                    </td>
                </tr> 
               
                <tr valign="top">
                    <th scope="row">Filter by keyword</th>
                    <td><input type="text" name="jcorgytce_filter_by_keyword"
                            value="<?php echo get_option('jcorgytce_filter_by_keyword'); ?>"  style="padding:5px" size="40"/><br>(Look for keyword in the video title)
                    </td>
                </tr> 
                <tr valign="top">
                    <th scope="row">Thumbnail width </th>
                    <td><input type="number" name="jcorgytce_thumbnail_width"
                            value="<?php echo get_option('jcorgytce_thumbnail_width'); ?>"  style="padding:5px" size="40"/><br>(for thumbnail mode)
                    </td>
                </tr> 
                <tr valign="top">
                    <th scope="row">Video width</th>
                    <td><input type="number" name="jcorgytce_video_width"
                            value="<?php echo get_option('jcorgytce_video_width'); ?>"  style="padding:5px" size="40"/>
                    </td>
                </tr> 
                <tr valign="top">
                    <th scope="row">Show video title</th>
                    <td><input type="radio" name="jcorgytce_show_title" <?php if(get_option('jcorgytce_show_title') == "yes" || get_option('jcorgytce_show_title') == "") echo "checked='checked'";?>
                            value="yes" 
                            /> Yes
                            <input type="radio" name="jcorgytce_show_title" <?php if(get_option('jcorgytce_show_title') == "no" ) echo "checked='checked'";?>
                            value="no" 
                            /> No 
                    </td>
                </tr>
        <tr valign="top">
            <th scope="row">Thumb Quality</th>
            <td><input type="radio" name="jcorgytce_thumb_quality" <?php if(get_option('jcorgytce_thumb_quality') == "0" || get_option('jcorgytce_thumb_quality') == "") echo "checked='checked'";?>
                       value="0"
                    /> High
                <input type="radio" name="jcorgytce_thumb_quality" <?php if(get_option('jcorgytce_thumb_quality') == "1" ) echo "checked='checked'";?>
                       value="1"
                        /> Medium
                <input type="radio" name="jcorgytce_thumb_quality" <?php if(get_option('jcorgytce_thumb_quality') == "2" ) echo "checked='checked'";?>
                       value="2"
                        /> Low
            </td>
        </tr>
        <tr valign="top">
                    <th scope="row">Embed using</th>
                    <td><input type="radio" name="jcorgytce_use" <?php if(get_option('jcorgytce_use') == "frame" || get_option('jcorgytce_use') == "") echo "checked='checked'";?>
                            value="frame" 
                            /> IFrame (remomended)
                            <input type="radio" name="jcorgytce_use" <?php if(get_option('jcorgytce_use') == "object") echo "checked='checked'";?>
                            value="object" 
                            /> Object (Old but works) 
                    </td>
                </tr>  
                <tr valign="top">
                    <th scope="row">Sort By</th>
                    <td> 
                    <select name="jcorgytce_order_by">
                    <option value="published" <?php if(get_option('jcorgytce_order_by') == "published"){  _e('selected');}?> >Publish date</option>
                    <option value="rating" <?php if(get_option('jcorgytce_order_by') == "rating") { _e('selected');}?> >Ratings</option>
                    <option value="relevance" <?php if(get_option('jcorgytce_order_by') == "relevance") { _e('selected');}?> >Relevance</option>
                    <option value="viewCount" <?php if(get_option('jcorgytce_order_by') == "viewCount") { _e('selected');}?> >View count</option>
                    </select>
               </tr>
               <tr valign="top">
                    <th scope="row">Place 'protected by' link</th>
                    <td><input type="checkbox" name="jcorgytce_linkback"
                            value="Yes" <?php if(get_option('jcorgytce_linkback') =="Yes") echo "checked='checked'";?> /> <br>
                            <strong>An link will be placed in the footer which points to author's website</strong></td>
                </tr> 
        </table>
        <p class="submit">
            <input type="submit" class="button-primary"
                value="Save Defaults" />
                
        </p>          
            </form>
            <script type="text/javascript">
            
                function jcorgYTChannelEmbedCreateShortCode() {
                          var mode = jQuery("input[name$='jcorgytce_mode']:checked").val();
                          var videoWidth = jQuery("input[name$='jcorgytce_video_width']").val();
                          var thumbnailWidth = jQuery("input[name$='jcorgytce_thumbnail_width']").val();
                          var showTitle = jQuery("input[name$='jcorgytce_show_title']:checked").val();
                          var maxResults = jQuery("input[name$='jcorgytce_max_results']").val();
                          var startIndex = jQuery("input[name$='jcorgytce_start_index']").val();
                          var orderBy = jQuery("select[name$='jcorgytce_order_by']").val();
                          var filterKeyword = jQuery("input[name$='jcorgytce_filter_by_keyword']").val();
                          var channelUserName = jQuery("input[name$='jcorgytce_channel_name']").val();
                          var useIncl = jQuery("input[name$='jcorgytce_use']:checked").val();
                          var thumbQuality = jQuery("input[name$='jcorgytce_thumb_quality']:checked").val();
                          jQuery("#jcorgyt-shortcode").html('[jcorg_youtube_channel mode="'+mode+'" videoWidth="'+videoWidth+'" thumbQuality="'+thumbQuality+'" thumbnailWidth="'+thumbnailWidth+'" showTitle="'+showTitle+'" maxResults="'+maxResults+'" startIndex="'+startIndex+'" orderBy="'+orderBy+'" filterKeyword="'+filterKeyword+'" channelName="'+channelUserName+'" embedType="'+useIncl+'"]');
                          return false;
                }
                function jcorgSelectText() {
                    var text = document.getElementById('jcorgyt-shortcode');
                    if (jQuery.browser.msie) {
                        var range = document.body.createTextRange();
                        range.moveToElementText(text);
                        range.select();
                    } else if (jQuery.browser.mozilla || jQuery.browser.opera) {
                        var selection = window.getSelection();
                        var range = document.createRange();
                        range.selectNodeContents(text);
                        selection.removeAllRanges();
                        selection.addRange(range);
                    } else if (jQuery.browser.safari) {
                        var selection = window.getSelection();
                        selection.setBaseAndExtent(text, 0, text, 1);
                    }
                }
            </script>
            <input type="button" class="button-primary"
                value="Create shortcode" onclick="return jcorgYTChannelEmbedCreateShortCode()"/>
                <div id="jcorgyt-shortcode" style="padding:10px; font-size:14px; font-family: calibri; background: #f9f9f9; border:2px #666 solid">Your short will appear here. Copy and paste shortcode to your post.</div>
                <br><a href="#select" onclick="jcorgSelectText()" class="button">Select</a>
        </div>
        <?php     
        echo "<div style='float:left;margin-left:20px;margin-top:75px'>".jcorgytcefeeds()."</div>";
    }
    
    function jcorgytceDonationDetail() {
        ?>    
        <style type="text/css"> .jcorgcr_donation_uses li {float:left; margin-left:20px;font-weight: bold;} </style> 

        <div style="padding: 10px; background: #f1f1f1;border:1px #EEE solid; border-radius:15px;width:98%"> 
        <h2>If you like this Plugin, please consider donating a small amount.</h2> 
        You can choose your own amount. Developing this awesome plugin took a lot of effort and time; days and weeks of continuous voluntary unpaid work. 
        If you like this plugin or if you are using it for commercial websites, please consider a donation to the author to 
        help support future updates and development. 
        <div class="jcorgcr_donation_uses"> 
        <span style="font-weight:bold">Main uses of Donations</span><ol ><li>Web Hosting Fees</li><li>Cable Internet Fees</li><li>Time/Value Reimbursement</li><li>Motivation for Continuous Improvements</li></ol> </div> <br class="clear"> <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=MHMQ6E37TYW3N"><img src="https://www.paypalobjects.com/en_AU/i/btn/btn_donateCC_LG.gif" /></a> <br><br><strong>For help please visit </strong><br> 
        <a href="http://jaspreetchahal.org/wordpress-youtube-channel-embed-plugin">http://jaspreetchahal.org/wordpress-youtube-channel-embed-plugin</a> <br><strong> </div>
        
        <?php
        
    }
    function jcorgytcefeeds() {
        $list = "
        <table style='width:400px;' class='widefat'>
        <tr>
            <th>
            Latest posts from JaspreetChahal.org
            </th>
        </tr>
        ";
        $max = 5;
        $feeds = fetch_feed("http://feeds.feedburner.com/jaspreetchahal/mtDg");
        $cfeeds = $feeds->get_item_quantity($max); 
        $feed_items = $feeds->get_items(0, $cfeeds); 
        if ($cfeeds > 0) {
            foreach ( $feed_items as $feed ) {    
                if (--$max >= 0) {
                    $list .= " <tr><td><a href='".$feed->get_permalink()."'>".$feed->get_title()."</a> </td></tr>";}
            }            
        }
        return $list."</table>";
    }
    
    
    function jcorgytceMakeErrorsHtml($errors,$type="error")
    {
        $class="jcorgberror";
        $title=__("Please correct the following errors","jcorgbot");
        if($type=="warnings") {
            $class="jcorgberror";
            $title=__("Please review the following Warnings","jcorgbot");
        }
        if($type=="warning1") {
            $class="jcorgbwarning";
            $title=__("Please review the following Warnings","jcorgbot");
        }
        $strCompiledHtmlList = "";
        if(is_array($errors) && count($errors)>0) {
                $strCompiledHtmlList.="<div class='$class' style='width:90% !important'>
                                        <div class='jcorgb-errors-title'>$title: </div><ol>";
                foreach($errors as $error) {
                      $strCompiledHtmlList.="<li>".$error."</li>";
                }
                $strCompiledHtmlList.="</ol></div>";
        return $strCompiledHtmlList;
        }
    }