<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BackendUser */
/* @var $form yii\widgets\ActiveForm */
?>
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
                

                


                
                <?= Html::label('Nueva Contraseña'); ?><br>
                <?= Html::input('password','passw_nuev','',['id'=>'passw_nueva']); ?><br>
                <?= Html::label('Confirme Nueva Contraseña'); ?><br>
                <?= Html::input('password','passw_re'); ?><br>
                <?= Html::input('text','',Yii::$app->getRequest()->getQueryParam('id'), ['style' => 'display:none','id'=>'id_user']);?>

                

                <div id="passw_re_alert" class="alert alert-danger alert-dismissible" style="display:none" role="alert">
                  <strong>Error de contraseña!</strong> La nueva contraseña no coincide.
                 </div>



              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <?= Html::button('Guardar Cambios',['onClick'=>'
                    if(document.getElementsByName("passw_nuev")[0].value == document.getElementsByName("passw_re")[0].value){
                         //Coinciden
                       
                       
                        console.log("todo bien")
                        
                        
                        parametros = {
                            id_user: $("#id_user")[0].value,
                            passw_nueva: $("#passw_nueva")[0].value
                        }
                        $.get("cambiopasswdirecto",parametros, function(data){
                            console.log("todo virgo papi");
                            })
                                    
                                    

                        
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
<div class="backend-user-form">

    <?php $form = ActiveForm::begin(); ?>

     <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

     <?=$form->field($model,'id_rol')->dropdownlist(ArrayHelper::map($vista_user->find()->asArray()->all(),'id_rol','nombre')) ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

   

    


        <?php 

            if(Yii::$app->getRequest()->getQueryParam('id')){
                
                echo Html::label('Cambiar Contraseña','',['data-toggle'=>'modal', 'data-target'=>'#exampleModal','style'=>'color:#8d8be8;cursor:pointer']);
            }
            

        ?>
        <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
