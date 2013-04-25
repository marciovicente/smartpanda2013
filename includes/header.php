<header id="header">
	<div class="central">
		<a href="<?php echo $server ?>"><div id="logo"><span>O shopping na palma da mão</span></div></a>
		<div id="statusLogin">
			<div class="imgLogin">
				<img src="" alt="Facebook profile">
			</div>
			<div class="profile">
				<h6>Davi Ricardo Castro</h6>
				<a href="#"><i class="icon icon-user icon-white"></i>Meu cadastro</a>
				<a href="#" class="logout"> <i class="icon icon-white icon-remove"></i>Sair</a>
				
			</div>
		</div>
	</div>

	<div id="filter">
		<div class="central">
			<form action="" id="formQuery">
				<label class="select">
					<select name="cbCategorias" id="cbCategorias" class="select" title="Filtrar por Categoria">
						<option value="0">Todas as Categorias</option>
					</select>
				</label>
				<label class="select">
					<select name="selectShAtivos" id="selectShAtivos" class="select" title="Filtrar por Shopping">
						<option value="0">Todos os shoppings</option>
					</select>
				</label>

				<input type="search" class="input" id="searchInput" placeholder="Pesquise por palavra chave"> <i class="icon icon-search"></i>
				<div id="teste"></div>
			</form>
		</div>
	</div>
</header>