<?php


class error_messages
{
    protected $messages;
    protected $type = 'error';
    protected $icon = true;

    public function __construct(array $messages, $type = "error", $icon = true)
    {
        $this->messages = $messages;
        $this->type = $type;
        $this->icon = $icon;
    }

    protected function renderMessage($type, $icon = true)
    {
        $message = $this->messages;
        if (!empty($message)) {
            $output = "";
            if (count($message) > 1) {
                $output .= "<ul>";
                foreach ($message as $error) {
                    $output .= "<li>" . $error . "</li>";
                }
                $output .= "</ul>";
            } else {
                $output = $message[0];
            }
            $classIcon = $icon ? 'block-rowMessage--iconic' : '';
            return "<div class=\"blockMessage blockMessage--$type $classIcon\">"
                . $output .
                "</div>";
        } else {
            return "";
        }
    }
}