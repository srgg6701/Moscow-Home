<?php
$test=false;

$form=$_POST['jform'];

$file_name=$file_path=$file_full_name=false;
if($attach=$_FILES['attach-file']){
    $file_path=$attach['tmp_name'];
    $file_name=$attach['name'];
    $file_full_name=$file_path . DIRECTORY_SEPARATOR . $file_name;
}
/**
 * Получить данные админов/суперюзеров, принимающих рассылку
 */
/*function getAdminsForMail(){
    $db = JFactory::getDbo();
    $query = "SELECT
  users.email,
  users.sendEmail,
  users.name
      FROM #__user_usergroup_map AS users_map
INNER JOIN #__usergroups         AS usergroups
           ON users_map.group_id = usergroups.id
              AND ( usergroups.title = 'Super Users'
                    OR usergroups.title = 'Administrator' )
INNER JOIN #__users              AS users
           ON users_map.user_id = users.id";
              //-- AND sendEmail = 1 ";
    $db->setQuery($query);
    $results = $db->loadObjectList();
    return $results;
}*/
/**
 * Разослать сообщения админам/суперюзерам/юзерам, принимающим рассылку
 * Формат отсылаемого сообщения (HTML/text) определяется опциональным 6-м аргументом
 * метода sendMail(). Если он имеет вещественное значение, используется HTML.
 */
$subject="Сообщение посетителя сайта";
$emailBody=nl2br("Посетитель " . $form['name'] . "
сайта MoscowHome задал вопрос: 
" .
$form['message'] .
"
Телефон посетителя: " . $form['telephone']);
$config = new JConfig();
$admins_mail = $config->mailfrom;//getAdminsForMail();
$emails = $admins_mail;
// Send mail to all superadministrators id
$errors=array();
$fromname = "MoscowHome";
if($local){
    echo "<br/><br/>
                <div><b>Отправлено сообщение(я)</b> на тему <i style='color: darkviolet;'>$subject</i>.
                  <br/>по адресам: ";
    if(is_string($emails)){
        echo "<span style='color: blue'>".$emails."</span>";
    }else{
        foreach( $emails as $i=>$row ){
            if($i) echo ", ";
            echo "<span style='color: blue'>".$row->email."</span>";
        }
    }
    echo "    <hr>Текст сообщения: <br/>$emailBody";
}
if($file_name) {
    if($test){
        echo "      <div>
				    Файлы:
				    <PRE>";
        var_dump($_FILES);
        echo "</PRE>
                </div>
                Контент файла: ";
        if(file_exists($file_path))
            echo file_get_contents($file_path);
        elseif (file_exists($file_full_name))
            echo file_get_contents($file_full_name);
        else echo " не получен...";
    }elseif(!file_exists($file_path)&&!file_exists($file_full_name)){?>
    <div><span style="color: red;">ОШИБКА присоединения файла.</span> Вложение не отправлено...</div>
<?php
    }
}
if(!$local){
    if(is_string($emails)) { // just email
        try{
            if($test) var_dump('<pre>',array($form['email'],$fromname,$emails,$subject,$emailBody,$file_full_name),'</pre>');

            $mail =& JFactory::getMailer();
            $mail->setSender(array($form['email'],$fromname));
            $mail->addRecipient($emails);
            $mail->setSubject($subject);
            $mail->setBody($emailBody);
            $mail->addAttachment($file_path,$file_name);
            $mail->IsHTML(true);
            $sent=$mail->Send();
            if(!$sent) echo "<div style='color:red'>".__LINE__.": Сообщение не отправлено...</div>";
            elseif ($test) echo "<div style='color:blue'>".__LINE__.": Сообщение  отправлено...</div>";
        }catch(Exception $e){
            $errors[]='email: '.$emails.', ошибка: ' . $e->getMessage();
        }
    }else{ // массив объектов с emails
        foreach( $emails as $row ){
            try{// разослать сообщения:
                $mail =& JFactory::getMailer();
                $mail->setSender(array($form['email'],$fromname));
                $mail->addRecipient($row->email);
                $mail->setSubject($subject);
                $mail->setBody($emailBody);
                $mail->addAttachment($file_path,$file_name);
                $mail->IsHTML(true);
                $sent=$mail->Send();
                if(!$sent) echo "<div style='color:red'>".__LINE__.": Сообщение не отправлено...</div>";
                elseif ($test) {
                    echo "<div style='color:blue'>".__LINE__.": Сообщение  отправлено...</div>";
                    echo "<div style='z-index:12;padding:10px;background-color: #efefef'><pre>";
                    var_dump(array('emailfrom'=>$form['email'],'fromname'=>$fromname,'emailto'=>$row->email,'subject'=>$subject,'emailBody'=>$emailBody,'attachment'=>$file_full_name));
                    echo "</pre></div>
				<div>Файлы:<pre>";
	var_dump($_FILES); echo "</pre></div>";
                }
            }catch (Exception $e){
                $errors[]='email: '.$row->email.', ошибка: ' . $e->getMessage();
            }
        }
    }
}
// отослать админам сообщение об ошибке
if(!empty($errors)) {
    $message = implode("\n", $errors);
    foreach ($admins_mail as $admin_mail) {
        JFactory::getMailer()->sendMail($form['email'],'Test mail',$admin_mail,"Ошибка отправки сообщения",$message,true);
    }
    if($test){
        echo "<div>".__LINE__.": Обнаружены ошибки отправки почты.</div>";
        var_dump('<pre>',array($errors,$emails),'</pre>');
    }
}