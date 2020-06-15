<?php
class tasksView extends basicView {
	function render($model) {		
		$page = indexController::paramByName("page");		
		if(!$page) $page = 1;
		if($page > 1) $url = "/page/$page";
		else $url = "";
		$url_sort = indexController::paramByName("sort");
		if($url_sort) $url_sort = "/sort/$url_sort";
		else $url_sort = "";
		
		?>
<div class="jumbotron text-center">
  <h1>Главная страница</h1>
</div>		

<?php echo indexController::renderMessages(); ?>
		
<div class="container-fluid">
	<table class="table table-striped table-bordered">
	<thead class="thead-dark">
		<tr>
			<th scope="col" style="width:20%"><a href="<?php 
			if("username" === indexController::paramByName("sort")) echo indexController::getUrl("sort/username_desc$url"); 
			else echo indexController::getUrl("sort/username$url"); ?>">имя пользователя</a></th>
			<th scope="col" style="width:20%"><a href="<?php
			if("email" === indexController::paramByName("sort")) echo indexController::getUrl("sort/email_desc$url"); 
			else echo indexController::getUrl("sort/email$url"); ?>">email</a></th>
			<th scope="col" style="width:40%"><a href="#">задача</a></th>
			<th scope="col" style="width:20%"><a href="<?php 
			if("status" === indexController::paramByName("sort")) echo indexController::getUrl("sort/status_desc$url"); 
			else echo indexController::getUrl("sort/status$url"); ?>">выполнение</a></th>
		</tr>
	</thead>
	<tbody>
		<?php 
		if($page > 1) $url = "page/$page";
		else $url = "";
		if(indexController::paramByName("sort")) $url = "sort/".indexController::paramByName("sort")."/$url";		
		
		foreach ($model->data as $row): ?>
		<tr scope="row">
			<td><?php echo ($row['username']); ?></td>
			<td><?php echo ($row['email']); ?></td>
			<td><?php echo ($row['text']); ?></td>
			<td><?php 
			$status = $row['status'];
			if($status) $out = "Выполнено";
			else $out = "Не выполнено";
			if(indexController::logged()) {	
				echo '<a href="'.indexController::getUrl("id/".$row['id']."/$url").'">'.$out.'</a>';
			}
			else echo $out;
			?></td>
		</tr>
		<?php 
	endforeach; 
	if($model->count > 3) {
		$pages = ceil($model->count / 3);
		$url = $url_sort;
		?>
		<tr><td colspan="4">
			<ul class="pagination">
				<?php				
				if($page > 1) echo '<li class="page-item"><a class="page-link" href="'.indexController::getUrl("page/".($page - 1)).$url.'">Предыдущий</a></li>';
				for($i=0; $i<$pages; $i++) {
					if($i + 1 == $page) $active = " active";
					else $active = "";
					echo '<li class="page-item'.$active.'"><a class="page-link" href="'.indexController::getUrl("page/".($i + 1)).$url.'">'.($i + 1).'</a></li>';
				}
				if($page < $pages) echo '<li class="page-item"><a class="page-link" href="'.indexController::getUrl("page/".($page + 1)).$url.'">Следующий</a></li>';
				?>
			</ul>
		</td></tr>
		<?php
	} 	
	?>
	<tr><td colspan="4"><a href="<?php echo indexController::getUrl("add"); ?>">добавить</a></td></tr>
	</tbody>		
	</table>
	<a href="<?php if(indexController::logged()) echo indexController::getUrl("admin/logoff"); else echo indexController::getUrl("admin/logon"); ?>">
	<?php if(indexController::logged()) echo "выход"; else echo "войти как администратор"; ?></a>
	
</div>
		<?php
	}
	
	function add($model) {		
		if($model) {
			$username = $model->data["username"];
			$email = $model->data["email"];
			$text = $model->data["text"];
		}
		else {
			$username = "";
			$email = "";
			$text = "";
		}
		?>
<div class="jumbotron text-center">
  <h1>Добавление записи</h1>
</div>		

<?php echo indexController::renderMessages(); ?>
	
<div class="container-fluid">	
<form method="post" action="<?php echo indexController::getUrl("add"); ?>">
	<div class="form-group">
		<a href="<?php echo indexController::getUrl(""); ?>">на главную</a>
	</div>
	<div class="form-group">
		<label for="username">Имя пользователя:</label>
		<input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
	</div>
	<div class="form-group">
		<label for="email">Email:</label>
		<input type="text" class="form-control" name="email" value="<?php echo $email; ?>">
	</div>
	<div class="form-group">
		<label for="text">Текст задачи:</label>
		<textarea class="form-control" rows="5" name="text" ><?php echo $text; ?></textarea>
	</div>
	<div class="form-group">
		<input type="submit" name="button" class="btn btn-info" value="Сохранить">
	</div>
</form>
</div>
		<?php
	}
	
}
?>