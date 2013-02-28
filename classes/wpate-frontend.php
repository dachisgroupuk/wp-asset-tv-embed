<?php
/**
 * Frontend class to handle the auto embedding of Asset TV videos into post content.
 *
 * Description: This allows for the embedding of Asset TV videos from their URLs
 * Version: 1.0
 * Author: Ross Tweedie
 * Author URI: http://www.dachisgroup.com
 */
class WpAssetTvEmbedFrontend extends WpAssetTvEmbedCore
{

    function init()
    {
        parent::init();

        /**
         * Add the Asset TV embeds
         */
        wp_embed_register_handler( 'assettv', '#http://web\.asset\.tv/player/\?sc=(?<sc>[A-za-z0-9]+)&i=(?<video_id>[0-9]+)(?:&width=(?<width>[0-9]+))*(?:&height=(?<height>[0-9]+))*#i', array( __CLASS__, 'wp_embed_handler_assettv' ) );
    }


    /**
    * The Asset TV embed handler callback.
    *
    * @see WP_Embed::register_handler()
    * @see WP_Embed::shortcode()
    *
    * @param array $matches The regex matches from the provided regex when calling {@link wp_embed_register_handler()}.
    * @param array $attr Embed attributes.
    * @param string $url The original URL that was matched by the regex.
    * @param array $rawattr The original unmodified attributes.
    * @return string The embed HTML.
    */
    function wp_embed_handler_assettv( $matches, $attr, $url, $rawattr ) {
        // Initialise the variables
        $video_id = $sc = $width = $height = null;

        $video_id = isset ( $matches['video_id'] ) ? $matches['video_id'] : '';
        $sc = isset ( $matches['sc'] ) ? $matches['sc'] : '';

        // If the user supplied a fixed width AND height, use it
        if ( !empty($rawattr['width']) && !empty($rawattr['height']) ) {
            $width  = (int) $rawattr['width'];
            $height = (int) $rawattr['height'];
        } else {

            list( $width, $height ) = wp_expand_dimensions( 640, 360, $attr['width'], $attr['height'] );
            
            if ( isset( $matches['width'] ) ){
                $width = $matches['width'];
            }
            if ( isset( $matches['height'] ) ){
                $height = $matches['height'];
            }
        }

        $script = <<<VIDEO
<script>
    sc = '{$sc}';
    containerID = 'asset_{$video_id}'; //Input Container ID e.g. 'microsite-wrapper'.
    videoID = '{$video_id}'; //Optional
    playerWidth = {$width};
    playerHeight = {$height};
</script>
<script type="text/javascript" id="site_embed" src="https://api.nona.asset.tv/embed/site_embed.js"></script>
<div id = 'asset_{$video_id}' style="width:{$width}px; height: {$height} "></div>
VIDEO;

    	return apply_filters( 'embed_assettv', $script, $matches, $attr, $url, $rawattr );
    }

}
