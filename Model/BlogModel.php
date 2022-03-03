<?php
/**
 * @author           Pierre-Henry Soria <phy@hizup.uk>
 * @copyright        (c) 2015-2017, Pierre-Henry Soria. All Rights Reserved.
 * @license          Lesser General Public License <http://www.gnu.org/copyleft/lesser.html>
 * @link             http://hizup.uk
 */

namespace Model;


class BlogModel extends MainModel
{

    protected $oDb;
    protected $CommnetModel;

    public function __construct()
    {
        $this->oDb = MainModel::getInstance()->getConnection();
        //$this->CommnetModel = new Comment();


    }

    /**
     * pobranie okrslonej  ilosci postow (tutja njprwd  5)
     * @param $iOffset
     * @param $iLimit
     * @return array
     *
     *
     */
    public function get($iOffset, $iLimit)
    {
        if ($this->CommnetModel->get() == false) {

            $oStmt = $this->oDb->prepare('SELECT * FROM Posts ORDER BY createdDate DESC LIMIT :offset, :limit');
            $oStmt->bindParam(':offset', $iOffset, \PDO::PARAM_INT);
            $oStmt->bindParam(':limit', $iLimit, \PDO::PARAM_INT);
            $oStmt->execute();
            return $oStmt->fetchAll(\PDO::FETCH_OBJ);

        }
        if ($this->CommnetModel->get() == true) {

            $oStmt = $this->oDb->prepare('SELECT posts.id, posts.title, posts.body,posts.createdDate, comments.comment
      FROM comments
       RIGHT JOIN posts ON comments.post_id = posts.id  ORDER BY createdDate DESC LIMIT :offset, :limit');
            $oStmt->bindParam(':offset', $iOffset, \PDO::PARAM_INT);
            $oStmt->bindParam(':limit', $iLimit, \PDO::PARAM_INT);
            $oStmt->execute();
            return $oStmt->fetchAll(\PDO::FETCH_OBJ);
        }

    }

    /**
     * pobranie wszytskich postow
     *
     * @return array
     */
    public function getAll()
    {
        $oStmt = $this->oDb->query('SELECT * FROM Posts ORDER BY createdDate DESC');
        return $oStmt->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     *
     * dodoaje post
     *
     * @param array $aData
     * @return bool
     *
     *
     */
    public function add(array $aData)
    {
        $oStmt = $this->oDb->prepare('INSERT INTO Posts (title, body, createdDate) VALUES(:title, :body, :created_date)');
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
        $oStmt = $this->oDb->prepare('SELECT * FROM Posts WHERE id = :postId LIMIT 1');
        $oStmt->bindParam(':postId', $iId, \PDO::PARAM_INT);
        $oStmt->execute();
        return $oStmt->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * aktuazlizacja postu wg id
     * @param array $aData
     * @return bool
     */
    public function update(array $aData)
    {
        $oStmt = $this->oDb->prepare('UPDATE Posts SET title = :title, body = :body WHERE id = :postId LIMIT 1');
        $oStmt->bindValue(':postId', $aData['post_id'], \PDO::PARAM_INT);
        $oStmt->bindValue(':title', $aData['title']);
        $oStmt->bindValue(':body', $aData['body']);
        return $oStmt->execute();
    }

    /**
     * usuwanie posta
     *
     * @param $iId
     * @return bool
     */
    public function delete($iId)
    {
        $oStmt = $this->oDb->prepare('DELETE FROM Posts WHERE id = :postId LIMIT 1');
        $oStmt->bindParam(':postId', $iId, \PDO::PARAM_INT);
        return $oStmt->execute();
    }
}
