<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//Custom made alternative to PyroCMS's default paginator.
function pagination($offset = 0, $limit = 12, $total_pages, $total_results, $tags = '', $title = '', $controller = 'project', $method = 'find')
{
    $pager = '';
    $tags = strtolower($tags);
    //Build the 'Previous' button link.
    if ($offset > 0)
        $pager .= '<a href="'.base_url("$controller/$method/".($offset - 1)."/$limit/$tags").'" title="'.$title.'" data-offset="'.($offset - 1).'" class="btn"><i class="icon-arrow-left"></i> Prev</a>';
    //Numeric button links.
    for ($c = 0; $c < $total_pages; $c++)
        if ($c == $offset OR $c == ($offset - 1) OR $c == ($offset + 1) OR $c == ($offset + 2))
            $pager .= '<a href="' . base_url("$controller/$method/$c/$limit/$tags") .'" title="'.$title.'" data-offset="'.$c.'" class="btn' . (($offset == $c) ? ' active' : '').'">'.($c + 1) .'</a>';
    //Build the 'Next' button link.
    if ($total_results - ($offset * $limit) > $limit )
        $pager .= '<a href="'.base_url("$controller/$method/".($offset + 1)."/$limit/$tags").'" title="'.$title.'" data-offset="'.($offset + 1).'" class="btn">Next <i class=" icon-arrow-right"></i></a>';
    //Return the pager.
    return $pager;
}
