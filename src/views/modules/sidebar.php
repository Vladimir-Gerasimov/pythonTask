<? $sidebar = '<div class="col m3 hide-on-small-only">
	<ul class="side-bar">
		<li><h5><a href="./">Главная</a></h5></li>
		<li' . ($page == 'Документы' ? ' class="active"' : '') . '><h5><a href="doc">Документы</a></h5></li>
		<li' . ($page == 'Общение' ? ' class="active"' : '') . '><h5><a href="community">Общение</a></h5></li>
		<li' . ($page == 'Трекер проблем' ? ' class="active"' : '') . '><h5><a href="tracker">Трекер проблем</a></h5></li>
	</ul>
</div>'; ?>