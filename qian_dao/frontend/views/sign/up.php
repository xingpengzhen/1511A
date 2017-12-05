<?php
use yii\helpers\Html;
use yii\Widgets\ActiveForm;
use yii\helpers\Url;
?>

<?php $form = ActiveForm::begin(['action' => ['sign/update'],'method'=>'post',]); ?>
            <input type="hidden" value="<?= $data['id']?>" name='id'>
            <ul>
                <li>
                    <span>字段名</span>
                    <input class="filed-name" type="text" placeholder="<?= $data['name']?>" name='name'>
                </li>
                <li>
                   <span>请输入字段默认值</span>
                   <input class="filed-name" type="text" placeholder="<?= $data['value']?>" name='value'>
                </li>
                <li>
                    <span>请选择字段类型：</span>
                    <select name="stype" id="">
                        <option value="文本框">文本框</option>
                        <option value="单选框">单选框</option>
                        <option value="密码框">密码框</option>
                        <option value="文本域">文本域</option>
                    </select>
                </li>
                <li>
                    <span>请填写字段选项：</span>
                    <input type="text" class="filed-name" placeholder="选项1">
                    <input type="text" class="filed-name" placeholder="选项2">
                </li>
                <li>
                    <span>是否必填：</span>
                    <input type="checkbox" value="必填" name="tian">必填
                    <input type="checkbox" value="不必填" name="tian">不必填
                </li>
                <li>
                    <span>请选择验证规则：</span>
                    <select name="yan" id="">
                        <option value="0">无</option>
                        <option value="手机号码">手机号码</option>
                        <option value="长度">长度</option>
                    </select>
                </li>
                <li>
                    <span>请选择填写长度范围：</span>
                    <input class="length" type="text" value="1" name="leng[]" placeholder="请输入最小长度">
                    ~
                    <input class="length" type="text" value="2" name="leng[]" placeholder="请输入最大长度">
                </li>
                <li>
                    <?= Html::submitButton('提交', ['class'=>'submit']) ?>
                </li>
            </ul>
        <?php $form->end()?>