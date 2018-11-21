<?php
if (!$this->input->is_ajax_request()) {
    exit('<h3>Not allowed</h3>');
} else {
    echo $output;
}

?>