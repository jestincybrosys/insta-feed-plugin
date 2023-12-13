
<?php 

function my_insta_feed_customization_page() {
    ?>
    <div class="wrap">
        <h1>Instagram Feed Customization</h1>
        
        <!-- Your radio options -->
        <div class="sqf-radio-options">
            <!-- ... (unchanged HTML) ... -->
        </div>
        
        <!-- Preview area -->
        <div id="insta-feed-preview">
            <?php echo get_insta_feed_preview(); ?>
        </div>

        <?php
        // Enqueue the JavaScript file for live preview
        wp_enqueue_script('customization-preview', plugins_url('customization-preview.js', __FILE__), array('jquery'), null, true);
    }

    // Function to get the current preview content
    function get_insta_feed_preview() {
        $feed_layout = isset($_POST['layout']) ? sanitize_text_field($_POST['layout']) : get_option('sqf_my_instagram_feed_view_type', 'grid');
        
        // Generate and return the preview content based on the layout
        switch ($feed_layout) {
            case 'grid':
                return '<div class="grid-preview" style="border: 1px solid #ccc; padding: 10px;">Grid Preview</div>';
            case 'scrollable':
                return '<div class="scrollable-preview" style="overflow: auto; height: 200px; border: 1px solid #ccc; padding: 10px;">Scrollable Preview</div>';
            case 'carousel':
                return '<div class="carousel-preview" style="display: flex; justify-content: center; align-items: center; height: 200px; background-color: #f0f0f0; border: 1px solid #ccc; padding: 10px;">Carousel Preview</div>';
            case 'masonry':
                return '<div class="masonry-preview" style="column-count: 3; column-gap: 10px; border: 1px solid #ccc; padding: 10px;">Masonry Preview</div>';
            default:
                return '';
        }
    }
