<?php
/**
 * Created by PhpStorm.
 * User: VitorEmanuel
 * Date: 05/11/2017
 * Time: 01:22
 */


include 'db.php';
$_POST = json_decode(file_get_contents('php://input'), true);

$nome = $_POST['nome'] ;
$origem = $_POST['origem'] ;
$tipo = $_POST['tipo'];





if(isset($nome) && isset($origem) && isset($tipo) )  {
    if(strlen($nome) == 0 && strlen($origem) == 0 && strlen($tipo) == 0){
        $data = [
            'msg' => 'Ha campos vazios',
            'id' => 0
        ];
        echo json_encode($data);
        return false;
    }



    $stmt = $conn->prepare("select count(nome) from airplanes where nome = :nome");
    $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
    $stmt->execute();

    $res =$stmt->fetch(PDO::FETCH_COLUMN);

    if($res == 0) {


        $stmt = $conn->prepare("INSERT INTO airplanes(nome,origem,img,tipo) values(:nome, :origem,'', :tipo) ");
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':origem', $origem, PDO::PARAM_STR);
        $stmt->bindParam(':tipo', $tipo, PDO::PARAM_STR);
        $res = $stmt->execute();

        $data = [
            'msg' => '',
            'id' => 1
        ];
        echo json_encode($data);
    }
    else {

        $data = [
            'msg' => 'Esse aeroplano ja foi registrado',
            'id' => 0
        ];
        echo json_encode($data);

    }
}
