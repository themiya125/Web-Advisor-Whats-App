<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', function() {

    Container::make( 'theme_options', __( 'WhatsApp Chat', 'webadvisor' ) )
        ->set_page_parent( false ) // top-level menu
        ->set_page_file( 'webadvisor-whatsapp' ) // unique slug
        ->set_icon( 'dashicons-whatsapp' )
        ->set_page_menu_position( 58 ) // position near other plugins (tweak if needed)
        ->add_fields( array(
            Field::make( 'checkbox', 'wa_enable_button', 'Enable WhatsApp Button' )
                ->set_default_value( true ),

            Field::make( 'text', 'wa_phone_number', 'WhatsApp Number' )
                ->set_help_text( __( 'Add full number with country code. Example: 94771234567', 'webadvisor' ) ),

            Field::make( 'text', 'wa_default_message', 'Default Message' )
                ->set_default_value( 'Hello 👋' )
                ->set_help_text( __( 'Message automatically added when user opens WhatsApp.', 'webadvisor' ) ),

            Field::make( 'select', 'wa_position', 'Button Position' )
                ->set_options( array(
                    'bottom-right' => 'Bottom Right',
                    'bottom-left'  => 'Bottom Left',
                ) )
                ->set_default_value( 'bottom-right' ),

            Field::make( 'color', 'wa_button_color', 'Button Color' )
                ->set_default_value( '#25D366' ),

   

// Checkbox: Use custom emoji/text icon
Field::make( 'checkbox', 'wa_use_custom_icon', 'Use Custom Icon' )
    ->set_default_value( false ), // OFF by default

// Text field: Emoji/Text icon (conditionally shown)
Field::make( 'text', 'wa_icon_text', 'Icon or Emoji' )
    ->set_default_value( '💬' )
    ->set_help_text( __( 'You can add an emoji or short text like "WA". Only used if the above option is turned on.', 'webadvisor' ) )
    ->set_conditional_logic( array(
        array(
            'field' => 'wa_use_custom_icon',
            'value' => true,  // show only if checkbox is ON
        ),
    ) ),


            Field::make( 'number', 'wa_button_size', 'Button Size (px)' )
                ->set_default_value( 55 )
                ->set_help_text( __( 'Adjust button diameter.', 'webadvisor' ) ),
        ) );
});
