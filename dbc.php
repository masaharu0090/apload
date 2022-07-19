<?php


require_once('env.php');
class Dbc
{
    // namespace Blog\Dbc;

    protected $table_name;


    // 1データーベース接続
    protected function dbConnect()
    {

        $host = DB_HOST;
        $dbname = DB_NAME;
        $user = DB_USER;
        $pass = DB_PASS;
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";


        try {
            $dbh = new \PDO($dsn, $user, $pass, [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            ]);
        } catch (\PDOException $e) {
            echo '接続失敗' . $e->getMessage();
            exit();
        };
        return $dbh;
    }
    // ２データを取得する
    public function getAll()
    {
        $dbh = $this->dbConnect();
        // 1SQLの準備
        $sql = "SELECT*FROM $this->table_name";
        // 2SQLの実行
        $stmt = $dbh->query($sql);
        // 3SQLの結果を受け取る
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
        $dbh = null;
    }




    public function getById($id)
    {
        if (empty($id)) {
            exit('IDが不正です。');
        }


        $dbh = $this->dbConnect();

        // SQL準備
        $stmt = $dbh->prepare("SELECT*FROM $this->table_name Where id = :id");
        $stmt->bindValue(':id', (int)$id, \PDO::PARAM_INT);
        // SQL実行
        $stmt->execute();
        // 結果を取得
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$result) {
            exit('ブログがありません');
        }
        return $result;
    }

    public function delete($id)
    {
        if (empty($id)) {
            exit('IDが不正です。');
        }


        $dbh = $this->dbConnect();

        // SQL準備
        $stmt = $dbh->prepare("DELETE FROM $this->table_name Where id = :id");
        $stmt->bindValue(':id', (int)$id, \PDO::PARAM_INT);
        // SQL実行
        $result = $stmt->execute();
        echo 'ブログを削除しました';
        return $result;
    }
    public function getByTitle()
    {
        // if (empty($id)) {
        //     exit('IDが不正です。');
        // }


        $dbh = $this->dbConnect();

        // SQL準備
        $stmt = $dbh->prepare("SELECT*FROM $this->table_name Where title LIKE '%" . $_POST["title"] . "%' ");
        // $stmt->bindValue(':id', (int)$id, \PDO::PARAM_INT);
        // SQL実行
        $stmt->execute();
        // 結果を取得
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$result) {
            exit('ブログがありません');
        }
        return $result;
    }
}