<?php

/**
 * Roundcube attachment_position Plugin
 *
 * @copyright Copyright (c) 2016 Sonic.net, Inc. (https://www.sonic.com)
 * @author Drew Phillips <dapphp@sonic.net>
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

/**
 * attachment_position plugin for Roundcube 1.1+
 *
 * This plugin adds an option to Roundcube allowing users to change the
 * position of the attachments pane when composing messages from the right side
 * of the message window to the top, giving more space for composing messages,
 * especially on smaller screens.
 *
 */
class attachment_position extends rcube_plugin
{
    public $task = 'mail|settings';

    /** @var rcmail */
    protected $rc;

    /**
     * Plugin init function - called when Roundcube has initialized.
     *
     * @return void
     */
    public function init()
    {
        $this->rc = rcmail::get_instance();
        $position = $this->rc->config->get('attachment_position');
        $skin     = $this->rc->config->get('skin');

        if ($this->rc->task == 'mail') {
            $css = dirname(__FILE__) . "/skins/{$skin}/attachment_position.css";
            if (file_exists($css)) {
                // when composing mail, add CSS and JS for attachment_position
                $this->add_texts('localization/', true);

                $this->rc->output->set_env('attachment_position', $position);
                $this->include_script('attachment_position.js');
                $this->include_stylesheet("skins/{$skin}/attachment_position.css");
            }

        } elseif ($this->rc->task == 'settings') {
            // register hooks to add setting to preferences and save user preference
            $this->add_texts('localization/', false);
            $this->add_hook('preferences_list', array($this, 'prefs_list'));
            $this->add_hook('preferences_save', array($this, 'prefs_save'));
        }
    }

    /**
     * Invoked when user is in a settings screen
     *
     * @param array $args Array of preferences for current screen and prefs section
     * @return array New array of preferences
     */
    public function prefs_list($args)
    {
        if ($args['section'] == 'compose') {
            $position = $this->rc->config->get('attachment_position');
            $field_id = 'attachment_position_where';
            $select   = new html_select(array('name' => '_attachment_position', 'id' => '_attachment_position'));

            $select->add(
                rcube_utils::rep_specialchars_output($this->gettext('addattachmentpositiondefault')),
                'default'
            );
            $select->add(
                rcube_utils::rep_specialchars_output($this->gettext('addattachmentpositiontop')),
                'top'
            );

            $args['blocks']['main']['options']['attachment_position'] = array(
                'title'   => html::label($field_id, rcube_utils::rep_specialchars_output($this->gettext('addattachmentposition'))),
                'content' => $select->show($position),
            );
        }

        return $args;
    }

    /**
     * Invoked when user saves their preferences
     *
     * @param array $args Array of preferences and which section is being saved
     * @return array Modified preferences
     */
    public function prefs_save($args)
    {
        if ($args['section'] != 'compose') {
            return $args;
        }

        // get post value of _attachment_position setting
        $value = rcube_utils::get_input_value('_attachment_position', rcube_utils::INPUT_POST);

        if (!in_array($value, array('top', 'default'))) {
            // if invalid, set value to default
            $value = 'default';
        }

        // save value to user preference
        $args['prefs']['attachment_position'] = $value;

        return $args;
    }
}
