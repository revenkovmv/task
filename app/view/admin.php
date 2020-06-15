<?php
class adminView extends basicView {
	function render() {
		?>
<div class="jumbotron text-center">
  <h1>Авторизация</h1>
</div>		

<?php echo indexController::renderMessages(); ?>
		
<div class="container-fluid">	
<form method="post" action="<?php echo indexController::getUrl("admin/logon"); ?>">
	<div class="form-group">
		<a href="<?php echo indexController::getUrl(""); ?>">на главную</a>
	</div>
	<div class="form-group">
		<label for="username">Имя пользователя:</label>
		<input type="text" class="form-control" name="login" value="">
	</div>
	<div class="form-group">
		<label for="email">Name:</label>
		<input type="password" class="form-control" name="pass" value="">
	</div>
	<div class="form-group">
		<input type="submit" name="button" class="btn btn-info" value="Войти">
	</div>
</form>
</div>
		<?php
	}
}
?>