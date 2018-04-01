<?php
defined('_JEXEC') or die;
?>

<nav id="mp-menu" class="mp-menu">
	<div class="mp-level">
		<ul>
			<?php
			foreach ($list as $i => &$item) {
					$class = 'item-' . $item->id;

					if (($item->id == $active_id) OR ( $item->type == 'alias' AND $item->params->get('aliasoptions') == $active_id)) {
						$class .= ' current';
					}

					if (in_array($item->id, $path)) {
						$class .= ' active';
					} elseif ($item->type == 'alias') {
						$aliasToId = $item->params->get('aliasoptions');

						if (count($path) > 0 && $aliasToId == $path[count($path) - 1]) {
							$class .= ' active';
						} elseif (in_array($aliasToId, $path)) {
							$class .= ' alias-parent-active';
						}
					}

					if ($item->type == 'separator') {
						$class .= ' divider';
					}

					if ($item->deeper) {
						$class .= ' deeper';
					}

					if ($item->parent) {
						$class .= ' parent';
					}

					if (!empty($class)) {
						$class = ' class="' . trim($class) . '"';
					}

					echo '<li' . $class . '>';

					if (!$item->deeper) {
						// Render the menu item.
						switch ($item->type) :
							case 'separator':
							case 'heading':
							case 'url':
							case 'component':
								require JModuleHelper::getLayoutPath('mod_menu', 'headermenu_heading');
								break;

							default:
								require JModuleHelper::getLayoutPath('mod_menu', 'headermenu_heading');
								break;
						endswitch;
					}else {
						echo '<a href="#">' . $item->title . '</a>';
					}
					// The next item is deeper.
					if ($item->deeper) {
						echo '<div class="mp-level">
<h2 class="icon icon-display mp-back"><i class="fa fa-angle-left" aria-hidden="true"></i>' . $item->title . '</h2><ul>';
					} elseif ($item->shallower) {
						// The next item is shallower.
						echo '</li>';
						echo str_repeat('</ul></div></li>', $item->level_diff);
					} else {
						// The next item is on the same level.
						echo '</li>';
					}
			}
			?>
		</ul>
	</div>
</nav>

