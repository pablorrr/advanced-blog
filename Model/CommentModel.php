<?php


namespace Model;


use PDO;

class CommentModel extends MainModel
{

    protected $oDb;

    public function __construct()
    {
        $this->oDb = MainModel::getInstance()->getConnection();
    }

    /**
     * pobranie okrslonej  ilosci postow (tutja njprwd  5)
     * @param $iOffset
     * @param $iLimit
     * @return bool
     *
     *
     */
    public function get()
    {
        $oStmt = $this->oDb->prepare('SELECT * FROM Comments ');
        $oStmt->execute();
        return !empty($oStmt->fetchAll(PDO::FETCH_OBJ));

    }


    /**
     * @param array $aData
     * @return bool
     */
    public function add(array $aData)
    {
        $oStmt = $this->oDb->prepare('INSERT INTO Comments (comment, post_id ) VALUES( :comment, :post_id)');
        return $oStmt->execute($aData);
    }

    /**
     *
     * pobiera pojedynczy post za pomaca jego id
     * @param $iId
     * @return mixed
     */
    public function getById($iId)
    {
        $oStmt = $this->oDb->prepare('SELECT * FROM Comments WHERE post_id = :commentId LIMIT 1');
        $oStmt->bindParam(':commentId', $iId, PDO::PARAM_INT);
        $oStmt->execute();
        return $oStmt->fetch(PDO::FETCH_OBJ);
    }

    public function getByIdCheck($iId)
    {
        return !empty($this->getById($iId));
    }

    /**
     * @param array $aData
     * @return bool
     */
    public function update(array $aData)
    {
        $oStmt = $this->oDb->prepare('UPDATE Comments SET comment = :comment WHERE post_id = :postId LIMIT 1');
        $oStmt->bindValue(':postId', $aData['post_id'], PDO::PARAM_INT);
        $oStmt->bindValue(':comment', $aData['comment']);

        return $oStmt->execute();
    }

    /**
     *
     * @param $iId
     * @return bool
     */
    public function delete($iId)
    {
        $oStmt = $this->oDb->prepare('DELETE FROM comments WHERE post_id = :commentId LIMIT 1');
        $oStmt->bindParam(':commentId', $iId, PDO::PARAM_INT);
        return $oStmt->execute();
    }

}