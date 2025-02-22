<?php

require_once 'Conexao.php';

class BuscaoPet extends Conexao {
    public function CadastrarPet($tipo_pet, $porte_pet, $img_pet, $data_hora, $info) {
        if ($tipo_pet == '' || $porte_pet == '' || $data_hora == '' || $info == '') {
            return 0;
        } else {
            $conexao = parent::retornarConexao();

            $injet_sql = 'INSERT INTO tb_pet (tipo_pet, porte_pet, img_pet, data_hora, descricao) VALUES (?, ?, ?, ?, ?)';

            $sql = $conexao->prepare($injet_sql);

            $sql->bindValue(1, $tipo_pet, PDO::PARAM_INT);
            $sql->bindValue(2, $porte_pet, PDO::PARAM_INT);
            $sql->bindValue(3, $img_pet, PDO::PARAM_LOB); // Bind do campo BLOB para a imagem
            $sql->bindValue(4, $data_hora);
            $sql->bindValue(5, $info);

            try {
                $sql->execute();
                return 1;
            } catch (Exception $ex) {
                echo $ex->getMessage();
                return -1;
            }
        }
    }

    public function ConsultarPet() {
        $conexao = parent::retornarConexao();

        $injet_sql = 'SELECT id_pet, tipo_pet, porte_pet, img_pet, data_hora, descricao FROM tb_pet';

        $sql = $conexao->prepare($injet_sql);

        $sql->setFetchMode(PDO::FETCH_ASSOC);

        try {
            $sql->execute();
            return $sql->fetchAll();
        } catch (Exception $ex) {
            echo $ex->getMessage();
            return [];
        }
    }
}
