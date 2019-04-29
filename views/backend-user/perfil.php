<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveField;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\models\BackendUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Perfil De Usuario';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="backend-user-perfil">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        
        <!-- <?= '<h1>Usuario: '.Yii::$app->user->identity->username.'</h1>' ?> -->
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="container emp-profile">
    	<div id='passw_camb_alert' class="alert alert-warning alert-dismissable" style="display: none;"><button type="button" class="close" aria-hidden="true" onclick="
    			document.getElementById('passw_camb_alert').style.display = 'none';
    	">&times;</button>
		      <p>Contraseña cambiada satisfactoriamente</p>
		</div>
		<script type="text/javascript">
			window.onload = function(){
    	 		console.log(1)
    	 		var url = new URL(window.location);
    	 		console.log(url.searchParams.get('alertFlag'))
    	 		if(url.searchParams.get('alertFlag')=='1'){
    	 			document.getElementById('passw_camb_alert').style.display = 'block';
    	 		}else{
    	 			document.getElementById('passw_camb_alert').style.display = 'none';
    	 		}
    	 	}

		</script>
		<!-- Modal -->
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h2 class="modal-title" id="exampleModalLabel">Cambio de contraseña</h2>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		       	

			    


		      	<?= Html::label('Antigua Contraseña'); ?><br>
			    <?= Html::input('password','passw_antig','',['id'=>'passw_antig']); ?><br>
			    <?= Html::label('Nueva Contraseña'); ?><br>
			    <?= Html::input('password','passw_nuev','',['id'=>'passw_nueva']); ?><br>
			    <?= Html::label('Confirme Nueva Contraseña'); ?><br>
			    <?= Html::input('password','passw_re'); ?><br>
			    <?= Html::input('text','',Yii::$app->user->identity->passw, ['style' => 'display:none','id'=>'passw_user']);?>
				<?= Html::input('text','',Yii::$app->user->identity->id, ['style' => 'display:none','id'=>'id_user']);?>

			    

			    <div id="passw_re_alert" class="alert alert-danger alert-dismissible" style="display:none" role="alert">
				  <strong>Error de contraseña!</strong> La nueva contraseña no coincide.
				 </div>
				 <div id="passw_antig_alert" class="alert alert-danger alert-dismissible" style="display:none" role="alert">
				  <strong>Error de contraseña!</strong> La contraseña antigua no coincide.
				 </div>



		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <?= Html::button('Guardar Cambios',['onClick'=>'
		        	if(document.getElementsByName("passw_nuev")[0].value == document.getElementsByName("passw_re")[0].value){
		        		parametros = {
		        			"flag": false,
		        			"passw_antig": $("#passw_antig")[0].value,
		        			"passw_user": $("#passw_user")[0].value
		        		}
		        		//Coinciden
		        		console.log("todo bien")
		        		$.get("cambiarpassword",parametros, function(data){
		        			
		        				if(data == 1){
		        					//Contraseña antigua confirmada, Actualizando contraseña, enviando parametros (flag Change, id de usuario loggeado y nueva contraseña para usuario loggeado)
		        					parametros = {
		        						flag: 1,
		        						passw_antig: $("#id_user")[0].value,
		        						passw_user: $("#passw_nueva")[0].value
		        					}
		        					console.log(parametros)
		        					$.get("cambiarpassword",parametros, function(data){
		        						console.log("todo virgo papi")
		        						})
		        					
		        					}else{
		        						//error en antigua contraseña
		        						if ($("#passw_antig_alert")[0].style.display === "none") {
										    $("#passw_antig_alert")[0].style.display = "block";
										}
		        					}

		        		});

		        		
		        	}else{

		        		//No coinciden las contraseñas
		        		if ($("#passw_re_alert")[0].style.display === "none") {
						    $("#passw_re_alert")[0].style.display = "block";
						  }

		        		
		        	}

		        ','class'=>'btn btn-primary'])?>
		        
		      </div>
		    </div>
		  </div>
		</div>
		<!-- END MODAL -->
            <form method="post">
                <div class="row">
                   <!--  <div class="col-md-4">
                        <div class="profile-img">
                            
                            <div class="file btn btn-lg btn-primary">
                                Change Photo
                                <input type="file" name="file"/>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-md-6">
                        <div class="profile-head">
                                    <h1>
                                        <?=Yii::$app->user->identity->username?>
                                    </h1>
                                    <h4>
                                        Web Developer and Designer
                                    </h4>
                                    <!-- <p class="proile-rating">RANKINGS : <span>8/10</span></p> -->
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item active">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Informacion</a>
                                </li>
                                
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <?=  Html::a('Editar Perfil',['update','id'=>Yii::$app->user->identity->id,'userRequest'=>1],['class'=>'btn btn-primary']) ?>
                    </div>
                </div>
                <div class="row">
                    
                    <div class="col-md-8">
                        <div class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane fade show active in" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Nombre:</label>
                                            </div>
                                            <div class="col-md-6">
                                                <?=Yii::$app->user->identity->first_name?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Apellido:</label>
                                            </div>
                                            <div class="col-md-6">
                                                <?=Yii::$app->user->identity->last_name?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Correo:</label>
                                            </div>
                                            <div class="col-md-6">
                                                <?=Yii::$app->user->identity->email?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Contraseña:</label>
                                            </div>
                                            <div class="col-md-6">
                                                <?= Html::label('Cambiar','',['data-toggle'=>'modal', 'data-target'=>'#exampleModal','style'=>'color:#8d8be8;cursor:pointer'])?>
                                            </div>
                                        </div>
                                        
                            </div>
                            
                        </div>
                    </div>
                </div>
            </form>           
        </div>



</div>