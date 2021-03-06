<?php
include_once '../include/header/header.php';
?>
    <!-- Navbar -->
<? include_once '../include/navbar/navbar.php' ?>

    <!-- Main Sidebar Container -->
<? include_once '../include/main-sidebar/main-sidebar.php' ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Команды бота</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
        <!-- /.content-header -->

        <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="shadow">
        <div class="row p-4">
            <?if($_SESSION['alert']):?>
							<div class="alert alert-success alert-dismissible fade show w-100" role="alert">
										<?=
                    $_SESSION['alert'];
                    unset($_SESSION['alert']);
                    ?>
								</div>
            <?endif;?>
					<a href="#gameAdd" class="btn btn-success my-2" data-toggle="modal">Добавить команду</a>
								<table class="table table-striped">
										<thead>
												<tr>
														<th scope="col">#</th>
														<th scope="col">Цвет</th>
														<th scope="col">Текст кнопки</th>
														<th scope="col">Ответ на команду</th>
														<th scope="col">Изменить</th>
														<th scope="col">Удалить</th>
												</tr>
										</thead>
										<tbody>
												<?
                        $games = $Database->SelectUserMenuCommends(1);
                        for($i = 0; $i < count($games); $i++):
                            ?>
													<tr>
																<th scope="row">
																		<?=$i + 1?>
																</th>
																<td class="d-flex">
																		<?=htmlspecialchars($games[$i]['color'])?>
																</td>
																<td>
																		<?=htmlspecialchars($games[$i]['button_text'])?></td>
																<td>
																		<?=htmlspecialchars($games[$i]['value'])?></td>
																<td><a href="#gameUpdate<?=$i?>" class="btn btn-primary" data-toggle="modal">Изменить</a></td>
																<td><a href="#gameDelete<?=$i?>" class="btn btn-danger" data-toggle="modal">Удлаить</a></td>
														</tr>
                        <?endfor;?>
										</tbody>
								</table>
								<div class="modal fade" id="gameAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog modal-lg" role="document">
												<div class="modal-content">
														<div class="modal-header">
																<h5 class="modal-title" id="exampleModalLabel<?=$i?>">Добавить команду</h5>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
														</div>
														<div class="modal-body">
																<form action="actions/action_add_commend.php" method="post">
																		<div class="md-form mt-4">
																				<label for="color">Цвет</label>
																				<input type="text" id="color" class="form-control" name="color" maxlength="500">
																		</div>
																		<div class="md-form mt-4">
																				<label for="button_text">Текст кнопки</label>
																				<input type="text" id="button_text" class="form-control" name="button_text" maxlength="20">
																		</div>
																		<div class="md-form mt-4">
																				<label for="value">Ответ на команду</label>
																				<textarea name="value" id="value" cols="30" rows="10" class="form-control w-100" maxlength="5000"></textarea>
																		</div>
																		<div class="text-center mt-4 d-flex justify-content-center">
																					<button type="submit" class="btn btn-primary btn-block btn-rounded z-depth-1a" style="width: 40%;height: 50px;border-radius: 34px">Добавить</button>
																		</div>
																</form>
														</div>
														<div class="modal-footer">
																<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
														</div>
												</div>
										</div>
								</div>
            <? for($i = 0; $i < count($games); $i++):?>
							<div class="modal fade" id="gameUpdate<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel<?=$i?>" aria-hidden="true">
										<div class="modal-dialog modal-lg" role="document">
												<div class="modal-content">
														<div class="modal-header">
																<h5 class="modal-title" id="exampleModalLabel<?=$i?>"><?echo 'Редактирование кнопки'. htmlspecialchars($games[$i]['button_text'])?></h5>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
														</div>
														<div class="modal-body">
																<form action="actions/action_upd_commend.php" method="post">
																		<div class="md-form mt-4" style="display: none">
																				<label for="id">id</label>
																				<input type="text" id="id" class="form-control" name="id" maxlength="500" value="<?=htmlspecialchars($games[$i]['id'])?>">
																		</div>
																		<div class="md-form mt-4">
																				<label for="color">Цвет</label>
																				<input type="text" id="color" class="form-control" name="color" maxlength="500" value="<?=htmlspecialchars($games[$i]['color'])?>">
																		</div>
																		<div class="md-form mt-4">
																				<label for="button_text">Текст кнопки</label>
																				<input type="text" id="button_text" class="form-control" name="button_text" maxlength="20" value="<?=htmlspecialchars($games[$i]['button_text'])?>">
																		</div>
																		<div class="md-form mt-4">
																				<label for="value">Ответ на команду</label>
																				<textarea name="value" id="value" cols="30" rows="10" class="form-control w-100" maxlength="5000"><?=htmlspecialchars($games[$i]['value'])?></textarea>
																		</div>
																		<div class="text-center mt-4 d-flex justify-content-center">
																					<button type="submit" class="btn btn-primary btn-block btn-rounded z-depth-1a" style="width: 40%;height: 50px;border-radius: 34px">Сохранить</button>
																		</div>
																</form>
														</div>
														<div class="modal-footer">
																<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
														</div>
												</div>
										</div>
								</div>
            <?endfor;?>
            <? for($i = 0; $i < count($games); $i++):?>
							<div class="modal fade" id="gameDelete<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel<?=$i?>" aria-hidden="true">
										<div class="modal-dialog modal-lg" role="document">
												<div class="modal-content">
														<div class="modal-header">
																<h5 class="modal-title" id="exampleModalLabel<?=$i?>"><?echo 'Удаление кнопки'. htmlspecialchars($games[$i]['button_text'])?></h5>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
														</div>
														<div class="modal-body">
																<h4 class="text-center ">Вы действительно хотите удалить кнопку <?=htmlspecialchars($games[$i]['button_text'])?>?</h4>
																<form action="actions/action_del_commend.php" method="post">
																		<div class="md-form mt-5" style="display: none">
																				<label for="Form-id" class="disabled">ID</label>
																				<input type="text" id="Form-id" class="form-control disabled" name="id" value="<?=htmlspecialchars($games[$i]['id'])?>"> </div>
																		<div class="text-center mt-4 d-flex justify-content-center">
																					<button type="submit" class="btn btn-danger btn-block btn-rounded z-depth-1a" style="width: 40%;height: 50px;border-radius: 34px">Удалить</button>
																		</div>
																</form>
														</div>
														<div class="modal-footer">
																<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
														</div>
												</div>
										</div>
								</div>
            <?endfor;?>
        </div>
    </div>
          <!-- /.row -->
      </div>
        <!-- /.container-fluid -->
    </div>
        <!-- /.content -->
  </div>

    <!-- Control Sidebar -->
<? include_once '../include/control-sidebar/control-sidebar.php' ?>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
<? include_once '../include/footer/footer.php' ?>
