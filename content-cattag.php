<?php
	global $aryCatTag;
	$html = '';
	$cat  = '';
	$tag  = '';

	if (count($aryCatTag['cat']) > 0) {
		foreach ($aryCatTag['cat'] as $key => $value) {
			if (count($value) > 0) {
				$cat .= '<li><a href="'.$value[0].'">'.$value[1].'</a></li>'."\n";
			}
		}

		if ($cat != '') {
			$cat  = '<li><i class="glyphicon glyphicon-book"></i></li>'.$cat;
			$html .= $cat;
		}
	}

	if (count($aryCatTag['tag']) > 0) {
		foreach ($aryCatTag['tag'] as $key => $value) {
			if (count($value) > 0) {
				$tag .= '<li><a href="'.$value[0].'">'.$value[1].'</a></li>'."\n";
			}
		}

		if ($tag != '') {
			$tag  = '<li><i class="glyphicon glyphicon-tag"></i></li>'.$tag;
			$html .= $tag;
		}
	}

	if ($html != '') {
		$html = '<ul class="list-inline cate_list">'.$html.'</ul>'."\n";
	}
	echo $html;
?>